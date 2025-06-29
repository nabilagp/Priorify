<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    //
    public function tasks()
{
    return $this->hasMany(Task::class)->orderBy('order');
}

}
