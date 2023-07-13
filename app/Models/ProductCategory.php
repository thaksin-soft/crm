<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'crm_product_category';
    protected $fillable = ['pg_id', 'prc_name', 'note', 'code_fb', 'from_base'];
    use HasFactory;
}