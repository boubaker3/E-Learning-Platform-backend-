<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingModel extends Model
{
    use HasFactory;
    protected $fillable = ['ratingid' ,'courseid' ,'senderid', 'review', 'rating' ];

    public $table="ratings";
}
