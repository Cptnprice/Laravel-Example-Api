<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    protected $guarded = [];

    public function author(){
        return $this->belongsTo(User::class);
    }
}
