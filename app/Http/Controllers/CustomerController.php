<?php
namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        Session::put('customer_search', Input::has('ok') ? Input::get('search') : (Session::has('customer_search') ? Session::get('customer_search') : ''));
        Session::put('customer_field', Input::has('field') ? Input::get('field') : (Session::has('customer_field') ? Session::get('customer_field') : 'name'));
        Session::put('customer_sort', Input::has('sort') ? Input::get('sort') : (Session::has('customer_sort') ? Session::get('customer_sort') : 'asc'));
        $customers = new Customer();
        $customers = $customers->where('name', 'like', '%' . Session::get('customer_search') . '%')->orderBy(Session::get('customer_field'), Session::get('customer_sort'))->paginate(20);
        return view('customer.index', ['customers' => $customers]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get'))
            return view('customer.form', ['customer' => Customer::find($id)]);
        else {
            $customer = Customer::find($id);
            $rules = ["discount" => "numeric|min:0|max:100"];
            if ($customer->name != Input::get('name'))
                $rules += ['name' => 'required|unique:customers'];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $customer->name = Input::get('name');
            $customer->discount = Input::get('discount');
            $customer->user_id = Auth::user()->id;
            $customer->save();
            Session::put('msg_status', true);
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get'))
            return view('customer.form');
        else {
            $validator = Validator::make(Input::all(), [
                "name" => "required|unique:customers",
                "discount" => "numeric|min:0|max:100"
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $customer = new Customer();
            $customer->name = Input::get('name');
            $customer->discount = Input::get('discount');
            $customer->user_id = Auth::user()->id;
            $customer->save();
            Session::put('msg_status', true);
        }
    }

    public function delete($id)
    {
        Customer::destroy($id);
        return redirect('customer');
    }

}