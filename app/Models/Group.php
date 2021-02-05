<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'folders';
    
    public function channels()
    {
        return $this->hasMany(Channel::class,'group_id');
    }

}
