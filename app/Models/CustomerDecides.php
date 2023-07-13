<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDecides extends Model
{
    use HasFactory;
    protected $table = "crm_customer_decides";
    protected $fillable = ['tr_code', 'decide_status', 'cus_name', 'cus_address', 'cus_tel', 'bill_id', 'date_sale', 'description'];
} 