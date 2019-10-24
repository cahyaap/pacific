<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandList extends Model
{
    protected $fillable = [
        'demand_id', 'demand_item_id', 'price', 'desc'
    ];

    public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }
    public function demand_item()
    {
        return $this->hasMany(DemandItem::class, 'id');
    }
}
