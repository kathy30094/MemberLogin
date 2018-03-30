<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyTree extends Model
{
    protected $table = 'familyTree';

    // public function scopeSearchMembersByID($query, $arrayOfID)
    // {
    //     return $query->whereIn('ID', $arrayOfID);
    // }
    public $timestamps = false;
}
