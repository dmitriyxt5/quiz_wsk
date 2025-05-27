<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    protected $fillable = ['quiz_id', 'code'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
