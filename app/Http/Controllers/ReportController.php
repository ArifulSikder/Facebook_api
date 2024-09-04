<?php

namespace App\Http\Controllers;

use App\Models\AccountName;
use App\Models\Earning;
use App\Models\Payment;
use App\Models\PostPayment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = $request->year ?? now()->year; // Use the selected year or default to the current year

        // Define the start and end of the selected or current year
        $startDate = Carbon::createFromDate($currentYear)->startOfYear();
        $endDate = Carbon::createFromDate($currentYear)->endOfYear();
        
        // Fetch the data from the database
        $earnings = Earning::whereBetween('date', [$startDate, $endDate])
            ->when($request->account_id, function ($query) use ($request) {
                $query->where('account_id', $request->account_id);
            })
            ->when($request->member_id, function ($query) use ($request) {
                $query->where('member_id', $request->member_id);
            })
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
        
        $months = range(1, 12); // Months from January to December
        $postOfferingData = array_fill_keys($months, 0);
        
        // Populate data
        foreach ($earnings as $month => $total) {
            $postOfferingData[$month] = $total;
        }
        
        $categories = array_map(function ($month) {
            return date('M', mktime(0, 0, 0, $month, 10));
        }, $months);
        
        $members = User::orderBy('name', 'ASC')->get();
        $accounts = AccountName::orderBy('name', 'asc')->get();
        
        return view('backend.pages.reports.report_index', [
            'categories' => $categories,
            'postOffering' => array_values($postOfferingData),
            'accounts' => $accounts,
            'members' => $members,
            'selectedAccount' => $request->account_id,
            'selectedMember' => $request->member_id,
            'selectedYear' => $currentYear,
        ]);
    }
}
