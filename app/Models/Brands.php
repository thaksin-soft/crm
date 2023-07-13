<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $table = "crm_brands";
    protected $fillable = ['code', 'brand_name', 'code_fb', 'from_base'];
    use HasFactory;
}