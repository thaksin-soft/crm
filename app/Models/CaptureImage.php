<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptureImage extends Model
{
    protected $table = "crm_cap_image";
    protected $fillable = ['tr_code', 'image_name'];
    use HasFactory;
}