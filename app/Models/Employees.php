<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
    protected $table = 'crm_employee';
    protected $fillable = ['emp_name', 'emp_lname', 'emp_gender', 'tel', 'email', 'depend_id', 'code_fb', 'from_base', 'emp_name_fb'];
}