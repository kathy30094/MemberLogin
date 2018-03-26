<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = 'employees';

    public function scopeSearchMembersByID($query, $arrayOfID)
    {
        return $query->whereIn('ID', $arrayOfID);
    }
}
