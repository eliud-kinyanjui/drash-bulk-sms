<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'uuid', 'name', 'email', 'email_verified_at', 'password',
        'avatar', 'provider_id', 'provider', 'access_token',
        'credit', 'credit_updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function contactGroups()
    {
        return $this->hasMany(ContactGroup::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function paymentRequests()
    {
        return $this->hasMany(PaymentRequest::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
