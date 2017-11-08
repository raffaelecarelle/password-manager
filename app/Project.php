<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description'];

    public function properties() {
        return $this->hasMany(Property::class, 'project_id', 'id')->orderBy('name', 'asc');
    }
}
