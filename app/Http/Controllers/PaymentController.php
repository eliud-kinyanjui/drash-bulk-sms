<?php

namespace App\Http\Controllers;

use App\Events\MpesaCallbackSaved;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Traits\Payments;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PaymentController extends Controller
{
    use Payments;

    public function index()
    {
        $payments = Auth::user()->payments()->latest()->get();

        return Inertia::render('Payments/Index', [
            'payments' => $payments,
        ]);
    }

    public function create()
    {
        return Inertia::render('Payments/Create');
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'amount' => 'required|numeric',
            'phone' => 'required|numeric|digits:10',
        ]);

        $phone = substr_replace($validData['phone'], '254', 0, 1);

        $response = $this->stkPush($phone, $validData['amount']);

        if (is_object($response)) {
            try {
                Auth::user()->paymentRequests()->create([
                    'phone' => $phone,
                    'amount' => $validData['amount'],
                    'merchant' => $response->merchant,
                    'checkout' => $response->checkout,
                ]);

                return redirect()->route('payments.index')->with('status', [
                    'type' => 'alert-success',
                    'message' => 'A payment request of KES '.$validData['amount'].' sent to '.$validData['phone'].'.',
                ]);
            } catch (Exception $ex) {
                Log::error($ex);

                return redirect()->back()->with('status', [
                    'type' => 'alert-danger',
                    'message' => 'Could not save the payment request.',
                ]);
            }
        } else {
            return redirect()->back()->with('status', [
                'type' => 'alert-danger',
                'message' => 'Could not send payment request.',
            ]);
        }
    }

    /**
     * MPESA STK callback URL.
     *
     * @param  Request  $request
     * @return void
     */
    public function stkCallback(Request $request)
    {
        if ($request->isMethod('post')) {
            $meta = $this->stkCallbackData();

            if ($meta) {
                try {
                    $paymentRequest = PaymentRequest::where('merchant', $meta['merchantRequestID'])
                        ->where('checkout', $meta['checkoutRequestID'])
                        ->first();

                    if (is_null($paymentRequest)) {
                        Log::error('Payment request not found. Merchant: '.$meta['merchantRequestID'].', Checkout: '.$meta['checkoutRequestID']);
                    } else {
                        $user = User::findOrFail($paymentRequest->user_id);

                        DB::transaction(function () use ($user, $meta, $paymentRequest) {
                            $payment = $user->payments()->create([
                                'merchant' => $meta['merchantRequestID'],
                                'checkout' => $meta['checkoutRequestID'],
                                'receipt' => $meta['mpesaReceiptNumber'],
                                'phone' => $meta['phoneNumber'],
                                'amount' => $meta['amount'],
                                'date' => $meta['transactionDate'],
                            ]);

                            $user->update([
                                'credit' => $user->credit + $meta['amount'],
                                'credit_updated_at' => now(),
                            ]);

                            $paymentRequest->delete();

                            MpesaCallbackSaved::dispatch($user, $payment);
                        });

                        Log::info('Payment entry saved.');
                    }
                } catch (Exception $ex) {
                    Log::error('Saving the payment entry failed.');
                    Log::error($ex);
                }

                Log::info('===');
            } else {
                Log::error('Invalid meta from callback: '.print_r($meta, true));
                Log::info('===');
            }
        } else {
            Log::error('STK callback was not a POST request.');
            Log::info('===');
        }
    }
}
