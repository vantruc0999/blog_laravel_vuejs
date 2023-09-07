<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Save extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'saved';
    protected $guarded = [];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function blogger(){
        return $this->belongsTo(Blogger::class);
    }
}
