<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
    ];

    protected $appends = ['total_contacts'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    protected function totalContacts(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->contacts()->count(),
        );
    }
}
