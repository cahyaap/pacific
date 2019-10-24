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
        return $this->belongsTo(DemandList::class);
    }
}
