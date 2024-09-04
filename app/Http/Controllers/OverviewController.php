<?php

namespace App\Http\Controllers;

use App\Models\AccountName;
use App\Models\StartingBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Transaction;

class OverviewController extends Controller
{
    public function index(Request $request)
    {
        
        // Retrieve accounts with their starting balance
        $accounts = AccountName::with('startingBalance')->orderBy('name', 'ASC')->get();
        $query = Transaction::with('account')->orderBy('date', 'desc');

        $account = $request->input('account');
        $dateRange = $request->input('from_and_to_date');

        // Filter Earning records
        if ($account) {
            $query->where('account_id', $account);
            $accountIds = [$account];
        } else {
            $accountIds = $accounts->pluck('id')->toArray();
        }

        $account_id[] = $account ?? $accounts->pluck('id');

        if ($dateRange) {
            [$startDate, $endDate] = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            if (strtolower($endDate) === 'current') {
                $endDate = Carbon::now()->endOfDay();
            } else {
                $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();
            }
            $query->whereBetween('date', [$startDate, $endDate]);

            
            $startingBalances = StartingBalance::whereIn('account_id', $accountIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();
        }

        $data['transactions'] = $query->paginate(20);

        $data['startingBalances'] = isset($startingBalances) ? $startingBalances : 0;

        $data['accounts'] = $accounts;
        return view('backend.pages.overview.index', $data);
    }

}
