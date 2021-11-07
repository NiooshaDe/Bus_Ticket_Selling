<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;

class Company extends Model
{
    use HasApiTokens, HasFactory;
    protected $fillable = ['name', 'phone_number', 'email', 'password', 'owner_name'];

}
