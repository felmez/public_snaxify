<?php

namespace App\Http\Controllers\Dashboard;

use DB;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Order;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $range = $request->input('range');
        if ($range == null) {
            $range = 'today';
        }
        $date_from = Carbon::today()->startOfDay();
        $date_to = Carbon::now();
        switch ($range) {
            case 'yesterday':
                $date_from = Carbon::today()->subDays(1)->startOfDay();
                $date_to = Carbon::today()->subDays(1)->endOfDay();
                break;
            case 'this_month':
                $date_from = Carbon::today()->startOfMonth(2)->subDays(1);
                break;
            case 'last_month':
                $date_from = Carbon::today()->startOfMonth()->subMonths(1);
                $date_to = (clone $date_from)->endOfMonth();
                break;
        }
        $new_customers = Customer::where('created_at', '>=', $date_from)->where('created_at', '<=', $date_to)->count();
        $orders_count = Order::where('created_at', '>=', $date_from)->where('created_at', '<=', $date_to)->count();
        $orders_sum = Order::where('created_at', '>=', $date_from)
                           ->where('created_at', '<=', $date_to)
                           ->sum('total_with_tax');

        $days = $date_to->diffInDays($date_from);
        $days_stats = [
            'days' => [],
            'sums' => []
        ];
        for ($i = 0; $i < $days; $i++) {
            $dt = (clone $date_from)->addDays($i + 1);
            $days_stats['days'][] = $dt->format(Settings::getSettings()->date_format);
            $days_stats['sums'][] = Order::whereDate('created_at', $dt)->sum('total_with_tax');
        }

        $orders = Order::latest()->get();

        return view('dashboard.home',
            compact('days_stats', 'orders_sum', 'orders_count', 'new_customers', 'range', 'orders'));
    }
}
