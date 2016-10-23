<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{

    protected $fillable = ['title'];

    public function todoList()
    {
        return $this->belongsTo('App\Models\TodoList');
    }

}
