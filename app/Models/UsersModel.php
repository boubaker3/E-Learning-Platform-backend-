<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'userid',
        'remember_token',
        'fullname',
        'email',
        'password',
        'photo',

    ];
    public $table="users";
}
