<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{

    protected $fillable = ['title'];

    public function todoItems()
    {
        return $this->hasMany('App\Models\TodoItem');
    }

}
