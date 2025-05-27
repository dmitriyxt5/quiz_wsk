<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = ['quiz_id', 'short_link_id', 'user_agent', 'ip_address', 'submitted_at'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function shortLink()
    {
        return $this->belongsTo(ShortLink::class);
    }

    public function responseAnswers()
    {
        return $this->hasMany(ResponseAnswer::class);
    }
}
