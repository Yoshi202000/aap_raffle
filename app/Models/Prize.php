<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $fillable = [
        'prize_name',
        'prize_value',
        'prize_image',
        'raffle_id'
        
    ];  
    public function raffle()
    {
        return $this->belongsTo(Raffle::class, 'raffle_id', 'raffle_id');
    }
}
