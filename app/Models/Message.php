<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'contact_group_id',
        'message',
        'at_response',
    ];

    public function contactGroup()
    {
        return $this->belongsTo(ContactGroup::class);
    }

    public function messageDetails()
    {
        return $this->hasMany(MessageDetail::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
