<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_transaction extends Model
{
    use HasFactory;
    public function ledger(){
        return $this->belongsTo(Ledger::class);
    }
    public function sub_ledger(){
        return $this->belongsTo(Sub_ledger::class);
    }
}
