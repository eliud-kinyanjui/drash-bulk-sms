<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'at_status_code',
        'at_number',
        'at_cost',
        'at_status',
        'at_message_id',
    ];
}
