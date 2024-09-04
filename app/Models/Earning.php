<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Earning extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'type_id');
    }
    public function account()
    {
        return $this->belongsTo(AccountName::class, 'account_id');
    }
}
