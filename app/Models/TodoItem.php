<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Valitron\Validator;

class TodoItem extends Model
{

    protected $fillable = ['title'];

    public function todoList()
    {
        return $this->belongsTo('App\Models\TodoList');
    }

    public function validator($data)
    {
        $validator = new Validator($data);

        $validator->rule('required', 'title');

        return $validator;
    }

}
