<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchedModel extends Model
{
    use HasFactory;
    protected $fillable=["courseid","userid"];
    public $table="watched";
}
