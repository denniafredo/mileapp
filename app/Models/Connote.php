<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;  

class Connote extends Eloquent
{
    protected $collection = 'connote';  
    public function koli()
    {
        return $this->hasMany(Koli::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class,"transaction_id","transaction_id");
    }
}
