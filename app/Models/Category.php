<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['title'];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
