<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = "unit";
    protected $guarded = ['id'];
    public function itjob(){
      return $this->hasMany('App\IT');
    }
}
