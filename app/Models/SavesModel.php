<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavesModel extends Model
{
    use HasFactory;
    protected $fillable=["saveid","courseid","userid"];
    public $table="saves";
}
