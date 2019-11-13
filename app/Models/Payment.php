<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
      'demand_id', 'status'  
    ];

    public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }
}
