<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Users extends Model
{
    use HasApiTokens, HasFactory;
    protected $fillable = ['name', 'phone_number', 'email', 'password'];

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
}
