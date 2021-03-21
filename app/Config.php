<?php

namespace App;

class Config extends Eloquent
{
    protected $table = 'configs';
    protected $fillable = array('config_name', 'config_value');
    protected $guarded = array('id');
}
