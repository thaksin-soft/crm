<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    protected $table = 'crm_product_group';
    protected $fillable = ['prg_name', 'note', 'code_fb', 'from_base'];
    use HasFactory;
}