<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustomerDecide extends Model
{
    use HasFactory;
    protected $table = "crm_product_cus_decide";
    protected $fillable = ['tr_code', 'item_category', 'item_pattern', 'product_buy', 'size', 'item_brand'];
}