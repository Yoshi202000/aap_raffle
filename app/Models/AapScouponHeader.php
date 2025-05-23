<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ScouponHeader extends Model
{
    protected $table = 'aap_scoupon_header';

    protected $primaryKey = 'asc_id';

    public $timestamps = false; // Custom timestamp columns are used

    protected $fillable = [
        'asc_criteria',
        'asc_subcriteria',
        'members_id',
        'vehicleinfohead_id',
        'vehicleinfohead_activedate',
        'vehicleinfohead_expiredate',
        'ai_id',
        'asc_coupons',
        'asc_addedwhen',
        'asc_addedby',
        'asc_modifiedwhen',
        'asc_resent_counter',
        'asc_resent_by',
        'asc_resent_when',
        'asc_manual',
        'asc_remarks',
    ];

    protected $casts = [
        'vehicleinfohead_activedate' => 'date',
        'vehicleinfohead_expiredate' => 'date',
        'asc_addedwhen' => 'datetime',
        'asc_modifiedwhen' => 'datetime',
        'asc_resent_when' => 'datetime',
    ];

    // Relationships (Optional: Define if needed)
    public function member()
    {
        return $this->belongsTo(Member::class, 'members_id', 'members_id');
    }

    public function couponDetails()
    {
        return $this->hasMany(ScouponDetail::class, 'asc_id', 'asc_id');
    }
}
