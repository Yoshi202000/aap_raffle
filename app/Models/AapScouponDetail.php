<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ScouponDetail extends Model
{
    protected $table = 'aap_scoupon_detail';

    protected $primaryKey = 'ascd_id';

    public $timestamps = false; // You handle timestamps manually via DB

    protected $fillable = [
        'asc_id',
        'ascd_couponcode',
        'ascd_status',
        'ascd_addedwhen',
        'ascd_addedby',
        'ascd_modifiedwhen',
    ];

    protected $casts = [
        'ascd_addedwhen' => 'datetime',
        'ascd_modifiedwhen' => 'datetime',
    ];

    // Optional: If you want to format date
    public function getAscdAddedwhenAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getAscdModifiedwhenAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    // Relationships (example)
    public function header()
    {
        return $this->belongsTo(ScouponHeader::class, 'asc_id', 'asc_id');
    }
}
