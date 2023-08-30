<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Blogger extends Authenticatable
{
    use HasFactory, HasApiTokens, HasRoles;

    protected $table = 'bloggers';
    protected $guarded = [];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function follows(){
        return $this->hasMany(Follow::class);
    }
}
