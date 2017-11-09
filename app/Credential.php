<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $fillable = ['name', 'value', 'property_id'];
}
