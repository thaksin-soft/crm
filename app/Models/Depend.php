<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depend extends Model
{
    use HasFactory;
    protected $table = "crm_depend";
    protected $fillable = ['depend_code', 'depend_name'];
}