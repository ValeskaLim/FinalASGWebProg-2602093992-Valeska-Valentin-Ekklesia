<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    public function users() {
        return $this->belongsToMany(User::class, 'user_avatar');
    }
}
