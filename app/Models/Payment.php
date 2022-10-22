<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'merchant',
        'checkout',
        'receipt',
        'phone',
        'amount',
        'date',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y @ h:i A',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
