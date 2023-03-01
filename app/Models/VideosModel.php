<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideosModel extends Model
{
    use HasFactory;
    protected $fillable = ['videoid','courseid', 'title','path' ];
public $table="videos";

}
