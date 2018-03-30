<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasManyByID extends Model
{
    public function member()
    {
        return $this->hasMany('App\Employees');
    }
}
