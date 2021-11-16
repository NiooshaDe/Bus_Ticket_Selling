<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roles extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
