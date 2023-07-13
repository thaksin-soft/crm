<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomcreditModel extends Model
{
    use HasFactory;
    protected $table ="crm_c_product";
    protected $fillable = ['doc_run','cc_emp_id','c_cus_id','cus_tel','doc_date','item_code','item_name','item_type','item_brand','item_model','item_price','creator','approve_status'];
}
