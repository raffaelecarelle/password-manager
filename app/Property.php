<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ["name", "description", "project_id"];

    public function credentials() {
        return $this->hasMany(Credential::class,'property_id', 'id')->orderBy('name', 'asc');
    }
}
