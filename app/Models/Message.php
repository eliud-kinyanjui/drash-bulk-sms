<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'contact_group_id',
        'message',
        'at_response',
    ];

    protected $appends = ['total_sent'];

    public function contactGroup()
    {
        return $this->belongsTo(ContactGroup::class);
    }

    public function messageDetails()
    {
        return $this->hasMany(MessageDetail::class);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->diffForHumans(),
        );
    }

    protected function totalSent(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $attributesArray = explode(' ', $attributes['at_response']);

                return $attributesArray[2];
            },
        );
    }
}
