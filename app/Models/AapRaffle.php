<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AapRaffle extends Model
{
    protected $table = 'aap_raffle';
    protected $primaryKey = 'ar_id';
    public $timestamps = false; // if you don't have created_at, updated_at

    protected $fillable = [
        'branch_id', 'ar_cat', 'ar_members', 'ar_attendees',
        'ar_nameprize', 'ar_nameprizet', 'ar_noprize',
        'ar_noattendees', 'ar_date', 'ar_order', 'raffle_image',
    ];
}
