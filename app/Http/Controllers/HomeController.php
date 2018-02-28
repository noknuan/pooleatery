<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $d1 = strtotime(date("d-M-Y", strtotime("-7 days")));
        $d2 = strtotime(date("d-M-Y"));
        $iv = array();
        $morning = array();
        $afternoon = array();
        $evening = array();
        $daily = array();
        $interval = $d2 - $d1;
        $count = date('d', $interval);
        for ($i = 1; $i <= $count; $i++) {
            $current = gmdate("d-M-Y", strtotime("+$i day", $d1));
            $iv[$i - 1] = intVal(date("d", strtotime($current)));
            $m = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select(DB::raw("sum(order_details.quantity * order_details.price*(1-orders.discount/100)) as total"))
                ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime($current)))
                ->where('orders.status', 'Completed')
                ->where('order_details.deleted_at', NULL)
                ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['00:00', '10:59'])
                ->first();
            $a = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select(DB::raw("sum(order_details.quantity * order_details.price*(1-orders.discount/100)) as total"))
                ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime($current)))
                ->where('orders.status', 'Completed')
                ->where('order_details.deleted_at', NULL)
                ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['11:00', '14:59'])
                ->first();
            $e = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select(DB::raw("sum(order_details.quantity * order_details.price*(1-orders.discount/100)) as total"))
                ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime($current)))
                ->where('orders.status', 'Completed')
                ->where('order_details.deleted_at', NULL)
                ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['15:00', '23:59'])
                ->first();
            $d = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select(DB::raw("sum(order_details.quantity * order_details.price*(1-orders.discount/100)) as total"))
                ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime($current)))
                ->where('orders.status', 'Completed')
                ->where('order_details.deleted_at', NULL)
                ->first();
            $morning[$i - 1] = floatval($m->total ? $m->total : 0);
            $afternoon[$i - 1] = floatval($a->total ? $a->total : 0);
            $evening[$i - 1] = floatval($e->total ? $e->total : 0);
            $daily[$i - 1] = floatval($d->total ? $d->total : 0);
        }
        // Get Daily Sale Summary
        $order['Breakfast'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price - (order_details.quantity * order_details.price*orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d'))
            ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['00:00', '10:59'])
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        $order['Lunch'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price-(order_details.quantity * order_details.price*orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d'))
            ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['11:00', '14:59'])
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        $order['Dinner'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price-(order_details.quantity * order_details.price*orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d'))
            ->whereBetween(DB::raw("date_format(orders.created_at,'%H:%i')"), ['15:00', '23:59'])
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        $order['Total'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price-(order_details.quantity * order_details.price*orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d'))
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();
        // sale by food type
        foreach (ProductCategory::orderBy('name')->pluck('name', 'id') as $key => $value) {
            $sale[$value] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'products.id', '=', 'order_details.product_id')
                ->select(DB::raw('sum(order_details.quantity * order_details.price-(order_details.quantity * order_details.price*orders.discount/100)) as total'))
                ->where(DB::raw("date(orders.created_at)"), date('Y-m-d'))
                ->where('products.product_category_id', $key)
                ->where('orders.status', 'Completed')
                ->where('order_details.deleted_at', NULL)
                ->groupBy(DB::raw("date(orders.created_at)"))
                ->first();
        }
        $sale['Open'] = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw('sum(order_details.quantity * order_details.price-(order_details.quantity * order_details.price*orders.discount/100)) as total'))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d', strtotime(Session::get('report_from'))))
            ->whereNull('order_details.product_id')
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy(DB::raw("date(orders.created_at)"))
            ->first();

        // Get detail report
        $orderDetails = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(DB::raw("product_id,description,sum(order_details.quantity) as total,price,sum(order_details.quantity * order_details.price*orders.discount/100) as discount"))
            ->where(DB::raw("date(orders.created_at)"), date('Y-m-d'))
            ->where('orders.status', 'Completed')
            ->where('order_details.deleted_at', NULL)
            ->groupBy('order_details.product_id')
            ->groupBy('order_details.description')
            ->groupBy('order_details.price')
            ->orderBy('total', 'desc')
            ->take(20)
            ->get();
        return view('home', [
            'iv' => $iv,
            'morning' => $morning,
            'afternoon' => $afternoon,
            'evening' => $evening,
            'daily' => $daily,
            'order' => $order,
            'sale' => $sale,
            'orderDetails' => $orderDetails,
        ]);
    }
}