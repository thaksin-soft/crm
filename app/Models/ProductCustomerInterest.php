<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustomerInterest extends Model
{
    use HasFactory;
    protected $table = "crm_product_cus_interest";
    protected $fillable = ['tr_code', 'cus_interest_product', 'item_category', 'item_pattern', 'pr_size', 'item_brand'];
}