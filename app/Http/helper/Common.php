<?php

use App\Models\Payment;
use App\Models\PostPayment;
use Carbon\Carbon;

if (!function_exists('memberId')) {
    function memberId($id)
    {
        return intval($id) - 1333;
    }
}

if (!function_exists('encriptMemberId')) {
    function encriptMemberId($id)
    {
        return intval($id) + 1333;
    }
}

if (!function_exists('formatedDate')) {
    function formatedDate($date)
    {
        return Carbon::parse($date)->format('m-d-Y');
    }
}

if (!function_exists('formatedNumber')) {
    function formatedNumber($amount)
    {
        return number_format($amount, 2, '.', '');
    }
}

if (!function_exists('earning_YTD')) {
    function earning_YTD($account)
    {
        $startOfYear = now()->startOfYear(); // January 1st of the current year
        $endDate = now(); // Current date
        $earning = $account->earnings->whereBetween('date', [$startOfYear, $endDate])->sum('amount');
        
        $transferAmount = PostPayment::where('from_account', $account->id)->sum('amount');
        $addAmmount = PostPayment::where('to_account', $account->id)->sum('amount');

        $startingBalance = $account->startingBalance
            ->whereBetween('date', [$startOfYear, $endDate])
            ->where('account_id', $account->id)
            ->sum('amount');
        $total = $earning + $startingBalance - $transferAmount + $addAmmount;
        return number_format($total, 2);
    }
}

if (!function_exists('member_earning_YTD')) {
    function member_earning_YTD($account, $member_id)
    {
        $startOfYear = now()->startOfYear(); // January 1st of the current year
        $endDate = now(); // Current date
        $amount = $account->earnings
            ->where('member_id', $member_id)
            ->whereBetween('date', [$startOfYear, $endDate])
            ->sum('amount');
        
        return number_format($amount, 2);
    }
}


if (!function_exists('calculateTotalBalance')) {
    function calculateTotalBalance($account, $staringBalanceAmount)
    {
        $earning = $account->earnings->sum('amount') + $staringBalanceAmount;
        $payment = Payment::where('from_account', $account->id)->sum('amount');
        $transferAmount = PostPayment::where('from_account', $account->id)->sum('amount');
        $addAmmount = PostPayment::where('to_account', $account->id)->sum('amount');
        
        $existingBalance = $earning - $payment - $transferAmount + $addAmmount;
        return $existingBalance;
    }
}


if (!function_exists('calculateTotalBalanceForMember')) {
    function calculateTotalBalanceForMember($account, $member_id)
    {
        $earning = $account->earnings->where('member_id', $member_id)->sum('amount');
        return $earning;
    }
}