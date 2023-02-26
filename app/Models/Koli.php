<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;  

class Koli extends Eloquent
{
    protected $collection = 'koli';  
    public function connote()
    {
        return $this->belongsTo(Connote::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class,'connote_id','connote_id');
    }
}
