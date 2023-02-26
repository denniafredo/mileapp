<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;  
  
class Package extends Eloquent  
{  
    protected $collection = 'package';  
    public function connote()
    {
        return $this->hasOne(Connote::class,"transaction_id","transaction_id");
    }
    public function koli_data()
    {
        return $this->hasMany(Koli::class,"connote_id","connote_id");
    }
}
