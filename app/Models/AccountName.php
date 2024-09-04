<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountName extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function startingBalance()
    {
        return $this->hasOne(StartingBalance::class, 'account_id');
    }
    public function earnings()
    {
        return $this->hasMany(Earning::class, 'account_id');
    }


    public function postPaymentsFrom()
    {
        return $this->hasMany(PostPayment::class, 'from_account');
    }

    public function postPaymentsTo()
    {
        return $this->hasMany(PostPayment::class, 'to_account');
    }
}
