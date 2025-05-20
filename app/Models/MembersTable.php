<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersTable extends Model
{
    Protected $table ='members_table';
    protected $primaryKey = 'ar_id';
    public $timestamp = false;

    protected $fillable = [
        'members_id', 'members_title', 'members_titlem', 'members_lastname', 'members_firstname',
        'members_middlename', 
    ];
}
