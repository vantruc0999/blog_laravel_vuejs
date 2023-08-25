<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $guarded = [];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function blogger(){
        return $this->belongsTo(Blogger::class);
    }
}
