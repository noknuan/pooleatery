<?php

namespace App\Http\Controllers;

use App\Item;
use App\ProductCategory;
use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class ReportController extends Controller
{
    public function dailySummary()
    {
        Session::put('report_from', Input::has('report_from') ? Input::get('report_from') : (Session::has('report_from') ? Session::get('report_from') : date("Y-m-d")));
        $order['Breakfast'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['00:00', '10:59'])
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        $order['Lunch'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['11:00', '14:59'])
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        $order['Dinner'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['15:00', '23:59'])
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        $order['Total'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        // sale by food type
        foreach (ProductCategory::orderBy('name')->pluck('name', 'id') as $key => $value) {
            $sale[$value] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
                ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
                ->where('products.product_category_id', $key)
                ->where('orders.status', 'Completed')
                ->where('order_details.deleted_at', NULL)
                ->groupBy(DB::raw("date(orders.created_at)"))
                ->first();
        }
        $sale['Open'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->whereNull('order_details.product_id')
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        return view('report.daily_summary', ['orders' => $order, 'sale' => $sale]);
    }

    public function printDailySummary()
    {
        Session::put('report_from', Input::has('report_from') ? Input::get('report_from') : (Session::has('report_from') ? Session::get('report_from') : date("Y-m-d")));
        $order['Breakfast'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['00:00', '10:59'])
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        $order['Lunch'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['11:00', '14:59'])
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        $order['Dinner'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['15:00', '23:59'])
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        $order['Total'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        // sale by food type
        foreach (ProductCategory::orderBy('name')->pluck('name', 'id') as $key => $value) {
            $sale[$value] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
                ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
                ->where('products.product_type_id', $key)
                ->where('orders.status', 'Completed')
                ->where('order_details.deleted_at', NULL)
                ->groupBy(DB::raw("date(orders.created_at)"))
                ->first();
        }
        $sale['Open'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price * (1-order_details.discount/100) * (1-orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->whereNull('order_details.product_id')
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        //return view('report.print_daily_summary', ['orders' => $order, 'sale' => $sale]);
        PDF::setOptions(['dpi' => 80, 'defaultFont' => 'sans-serif']);
        $pdf=PDF::loadView('report.print_daily_summary', ['orders' => $order, 'sale' => $sale]);
        $pdf->setPaper('A4');
        return $pdf->stream("report.pdf", array("Attachment" => false));
    }
}