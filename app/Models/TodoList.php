<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Valitron\Validator;

class TodoList extends Model
{

    protected $fillable = ['title'];

    public function todoItems()
    {
        return $this->hasMany('App\Models\TodoItem');
    }

    public function validator($data)
    {
        $validator = new Validator($data);

        $validator->rule('required', 'title');

        return $validator;
    }

}
