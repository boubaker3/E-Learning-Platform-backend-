<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesModel extends Model
{
    use HasFactory;
 
    protected $fillable = ['title','courseid','userid','description','category','benefits','requirements','paid_or_free','price','thumb','rating'];
    public $table="courses";
}
