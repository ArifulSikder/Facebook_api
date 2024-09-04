<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function postPaymentsFrom()
    {
        return $this->belongsTo(AccountName::class, 'from_account');
    }
    
    public function postPaymentsTo()
    {
        return $this->belongsTo(AccountName::class, 'to_account');
    }
    
}
