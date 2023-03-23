<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsModel extends Model
{
    use HasFactory;
    protected $fillable=['followerid','followingid'];
    public $table="subscriptions";
}
