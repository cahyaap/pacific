<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandItem extends Model
{
    protected $fillable = [
        'name', 'desc'
    ];

    public function demand_list()
    {
        return $this->hasMany(DemandList::class, 'demand_item_id');
    }
}
