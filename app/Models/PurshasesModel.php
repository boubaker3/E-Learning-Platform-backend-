<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurshasesModel extends Model
{
    use HasFactory;
    protected $fillable = ['purshaseid','userid' ,'courseid' ,'payerid', 'paymentid', 'amount' ];

    public $table="purshases";
}
