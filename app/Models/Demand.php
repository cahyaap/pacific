<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    protected $fillable = [
        'invoice', 'ppn', 'materai', 'note', 'status', 'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function demand_list()
    {
        return $this->hasMany(DemandList::class);
    }
}
