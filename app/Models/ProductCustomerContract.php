<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustomerContract extends Model
{
    protected $table = "crm_product_cus_contract";
    protected $fillable = ['tr_code', 'item_category', 'item_pattern', 'product_purchased', 'product_size', 'item_brand', 'cc_id'];
    use HasFactory;
}