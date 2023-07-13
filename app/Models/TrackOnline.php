<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackOnline extends Model
{
    use HasFactory;
    protected $table = "crm_track_online";
    protected $fillable = ['tr_code', 'tr_name', 'tr_tel', 'tr_cus_facebook', 'tr_con_channel', 
    'tr_cos_address', 'tr_con_from', 'emp_id', 'status', 'note', 'dates', 'complete_status'];
}