<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function questions()
    {
        return ~$this->hasMany(Question::class);
    }

    public function shortLinks()
    {
        return $this->hasMany(ShortLink::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
