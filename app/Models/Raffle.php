<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    protected $primaryKey = 'raffle_id';

    protected $fillable = [
        'raffle_name',
        'start_date',
        'end_date',
        'bg_image',
    ];
    public function prizes()
    {
        return $this->hasMany(Prize::class, 'raffle_id', 'raffle_id');
    }
}