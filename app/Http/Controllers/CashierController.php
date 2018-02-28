<?php
namespace App\Http\Controllers;

use App\Customer;
use App\Item;
use App\Product;
use App\ProductCategory;
use App\Order;
use App\OrderDetail;
use App\Recipe;
use App\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CashierController extends Controller
{
    public function index()
    {
        Session::put('menuCategory_id', Input::has('menuCategory_id') ? Input::get('menuCategory_id') : (Session::has('menuCategory_id') ? Session::get('menuCategory_id') : env('DEFAULT_MENU_CATEGORY')));
        if (Session::get('order_id') != '')
            $order = Order::find(Session::get('order_id'));
        else
            $order = [];
        return view('cashier.index', [
            'menuCategories' =>
                ProductCategory::orderBy('ordering')->get(),
            'order' => $order
        ]);
    }

    public function products()
    {
        Session::put('menuCategory_id', Input::has('menuCategory_id') ? Input::get('menuCategory_id') : (Session::has('menuCategory_id') ? Session::get('menuCategory_id') : env('DEFAULT_MENU_CATEGORY')));
        $str = '<ul class="list-group" style="height: 520px;overflow-y: auto;border: 2px outset;background: white">';
        $products = new Product();
        if (Input::has('search') && trim(Input::get('search')) != '')
            $products = $products->where(function ($q) {
                $q->where('name', 'like', '%' . trim(Input::get('search')) . '%')
                    ->orWhere('id', trim(Input::get('search')));
            });
        if (Input::has('menuCategory_id') || trim(Input::get('search')) == '')
            $products = $products->where('product_category_id', Session::get('menuCategory_id'));
        $products = $products->orderBy('name')->get();
        foreach ($products as $menu) {
            $str .= '<li class="list-group-item" style="font-size: 16px;padding:0px;height: 80px"
            onclick="if($(\'#table_id\').text()==\'Table #\') alert(\'Please select table first\'); else ajaxLoad(\'cashier/order/' . $menu->id . '\',\'orderList\');">
            <img src=' . ($menu->image != '' && File::exists("images/products/" . $menu->image) ? "/images/products/" . $menu->image : "/images/default.jpg") . ' class="pull-left" width="80px" height="70px"
                                 style="margin: 5px 5px 0px 5px"/>
                            <div style="margin:20px">
                                <span style="color: red;font-size: 15px"
                                      class="pull-right">$' . number_format($menu->unitprice, 2) . '</span>
                                <div>' . $menu->name . ' <span style="color: gray">(' . $menu->id . ')</span></div>
                            </div></li>';
        }
        $str .= '</ul>';
        return $str;
    }

    public function order($id)
    {
        $menu = Product::find($id);
        if (count($menu) > 0 or ($id == 0 and env('KTV'))) {
            $order = Order::find(Session::get('order_id'));
            if (count($order) == 0) {
                $order = new Order();
                $order->table_id = Session::get('table_id');
                $order->checked_in = date('Y-m-d H:i:s');
                $order->user_id = Auth::user()->id;
            }
            $order->status = 'Busy';
            $order->table->status = 'Busy';
            $order->push();
            $order_detail = OrderDetail::where('order_id', $order->id)->where('product_id', $id)->first();
            if (count($order_detail) == 0) {
                $order_detail = new OrderDetail();
                $order_detail->order_id = $order->id;
                $order_detail->product_id = $id;
                $order_detail->ordered_date = $order->created_at;
                if ($id > 0)
                    $order_detail->quantity = 1;
                $order_detail->description = $menu->name;
                $order_detail->price = $menu->unitprice;
                $order_detail->user_id = Auth::user()->id;
                $order_detail->save();
            } else {
                if ($id > 0)
                    $order_detail->quantity += 1;
                $order_detail->user_id = Auth::user()->id;
                $order_detail->save();
            }
            Session::put('order_id', $order->id);
        }
        return view('cashier._order', ['order' => Order::find(Session::get('order_id'))]);
    }

    public function updateDescription($id, $value)
    {
        $orderDetail = OrderDetail::where('id', $id)->first();
        if (count($orderDetail)) {
            $orderDetail->description = $value;
            $orderDetail->save();
        }
        return view('cashier._order', ['order' => Order::find(Session::get('order_id'))]);
    }

    public function updateQuantity($id, $value)
    {
        $orderDetail = OrderDetail::where('id', $id)->first();
        if (count($orderDetail)) {
            $orderDetail->quantity = $value;
            $orderDetail->save();
        }
        return view('cashier._order', ['order' => Order::find(Session::get('order_id'))]);
    }

    public function updatePrice($id, $value)
    {
        $orderDetail = OrderDetail::where('id', $id)->first();
        if (count($orderDetail)) {
            $orderDetail->price = $value;
            $orderDetail->save();
        }
        return view('cashier._order', ['order' => Order::find(Session::get('order_id'))]);
    }

    public function updateCustomer($id, $value)
    {
        $order = Order::find($id);
        $order->customer_id = $value;
        $order->discount = $value > 0 ? Customer::find($value)->discount : 0;
        $order->save();
        return view('cashier._order', ['order' => Order::find(Session::get('order_id'))]);
    }

    public function updateDiscount($id, $value)
    {
        $order = Order::find($id);
        $order->discount = $value;
        $order->save();
        return view('cashier._order', ['order' => Order::find(Session::get('order_id'))]);
    }

    public function switchTable($id)
    {
        Session::put('table_id', $id);
        $ids = Input::get('ids');
        $oldorder = Order::find(Session::get('order_id'));
        $neworder = Order::where('table_id', Session::get('table_id'))->where('status', '!=', 'Completed')->where('status', '!=', 'Moved')->where(DB::raw('date(created_at)'), date('Y-m-d'))->first();
        if (count($neworder) == 0) {
            $neworder = new Order();
            $neworder->table_id = Session::get('table_id');
            $neworder->checked_in = $oldorder->checked_out;
            $neworder->user_id = Auth::user()->id;
        }
        $neworder->status = 'Busy';
        $neworder->table->status = 'Busy';
        $neworder->push();
        if ($ids != '')
            $orderDetails = OrderDetail::where('order_id', Session::get('order_id'))->whereIn('id', explode(',', $ids))->get();
        else
            $orderDetails = OrderDetail::where('order_id', Session::get('order_id'))->get();
        foreach ($orderDetails as $orderDetail) {
            $orderDetail->order_id = $neworder->id;
            $orderDetail->save();
        }
        if (count($oldorder->order_details) == 0) {
            $oldorder->table->status = 'Free';
            $oldorder->push();
            $oldorder->delete();
        }
        Session::put('order_id', $neworder->id);
        return view('cashier._order', ['order' => $neworder]);
    }

    public function table()
    {
        return view('cashier.table', ['tables' => Table::orderBy('name')->get()]);

    }

    public function selectTable($id)
    {
        Session::put('table_id', $id);
        $order = Order::where('table_id', Session::get('table_id'))->where('status', '!=', 'Completed')->where('status', '!=', 'Moved')->where(DB::raw('date(created_at)'), date('Y-m-d'))->first();
        if (count($order) > 0)
            Session::put('order_id', $order->id);
        else {
            Session::put('order_id', '');
            $order = [];
        }
        return view('cashier._order', ['order' => $order]);
    }

    public function changeTable()
    {
        Session::put('selected_items', Input::get('ids'));
        return view('cashier.change_table', ['tables' => Table::where('id', '!=', Session::get('table_id'))->orderBy('name')->get()]);
    }

    public function delete($id)
    {
        $order_detail = OrderDetail::find($id);
//        if ($order_detail->product_id != 0) {
        $order_detail->user_id = Auth::user()->id;
        $order_detail->save();
        $order_detail->delete();
//        }
        return view('cashier._order', ['order' => Order::find(Session::get('order_id'))]);
    }

    public function open(Request $request)
    {
        if ($request->isMethod('get'))
            return view('cashier.open');
        else {
            $validator = Validator::make(Input::all(), [
                "description" => "required",
                "quantity" => "required|numeric",
                "price" => "required|numeric",
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $order = Order::find(Session::get('order_id'));
            if (count($order) == 0) {
                $order = new Order();
                $order->table_id = Session::get('table_id');
                $order->checked_in = date('Y-m-d H:i:s');
                $order->user_id = Auth::user()->id;
            }
            $order->status = 'Busy';
            $order->table->status = 'Busy';
            $order->push();
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->ordered_date = $order->created_at;
            $orderDetail->description = Input::get('description');
            $orderDetail->quantity = Input::get('quantity');
            $orderDetail->price = Input::get('price');
            $orderDetail->user_id = Auth::user()->id;
            $orderDetail->save();
            Session::put('order_id', $order->id);
            return view('cashier._order', ['order' => $order]);
        }
    }

    public function returnOrder()
    {
        return view('cashier._order', ['order' => []]);
    }

    public function printPayment()
    {
        DB::beginTransaction();
        try {
            $order = Order::find(Session::get('order_id'));
            $order->status = 'Completed';
            $order->usd = Session::get('usd');
            $order->table->status = 'Free';
            $order->push();
            foreach ($order->order_details()->whereNotNull('product_id')->get() as $order_detail) {
                $recipes = Recipe::where('product_id', $order_detail->product_id)->get();
                foreach ($recipes as $recipe) {
                    $item = Item::find($recipe->item_id);
                    $item->quantity -= ($recipe->quantity * $order_detail->quantity);
                    $item->save();
                }
            }
            DB::commit();
            Session::put('order_id', '');
        } catch (\Exception $ex) {
            DB::rollback();
            return view('cashier._order', ['order' => $order, 'pay_error' => 1]);
        }
        return view('cashier.print_payment', ['order' => $order]);
    }

    public function pay(Request $request)
    {
        if ($request->isMethod('get')) {
            $order = Order::find(Session::get('order_id'));
            return view('cashier.pay', ['order' => $order]);
        } else {
            $validator = Validator::make(Input::all(), [
                "usd" => "numeric"
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $order = Order::find(Session::get('order_id'));
            $total = $order->order_details()->select(DB::raw('sum(quantity*price*(1-discount/100)) as  total'))->first()->total;
            $total = $total * (1 - $order->discount / 100);
            $cashin = Input::get('usd');
            if ($total > $cashin)
                return array(
                    'fail' => true,
                    'errors' => ['usd' => 'The cash must be equal or higher than total price!']);
            Session::put('usd', Input::get('usd'));
            $change = $cashin - $total;
            Session::put('change_us', $change);
        }
    }

    public function getPrint()
    {
        $order = Order::find(Session::get('order_id'));
        $order->status = 'Printed';
        $order->checked_out = date('Y-m-d H:i:s');
        $order->table->status = 'Printed';
        $order->push();
        return View('cashier.print', ['order' => $order]);
    }

    public function reloadOrder()
    {
        return view('cashier._order', ['order' => Order::find(Session::get('order_id'))]);
    }
}