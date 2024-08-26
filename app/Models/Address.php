<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_address',
        'city',
        'state',
        'postal_code',
        'country',
        'is_primary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPrimary()
    {
        return $this->is_primary; // Assuming you have an 'is_primary' column
    }
}
