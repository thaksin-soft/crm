<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractCustomer extends Model
{
    protected $table = "crm_contract_customer";
    protected $fillable = ['tr_code', 'status', 'note'];
    use HasFactory;
} 