<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifModel extends Model
{
    use HasFactory;
    protected $fillable=["notifid","senderid","receiverid","type","seen"];
    public $table="notifications";
}
