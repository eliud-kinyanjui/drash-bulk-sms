<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'user_id',
    ];

    protected $appends = ['total_contacts'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function getTotalContactsAttribute()
    {
        return $this->contacts()->count();
    }
}
