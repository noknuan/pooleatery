<?php
namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        Session::put('item_search', Input::has('ok') ? Input::get('search') : (Session::has('item_search') ? Session::get('item_search') : ''));
        Session::put('item_category', Input::has('category') ? Input::get('category') : (Session::has('item_category') ? Session::get('item_category') : -1));
        Session::put('item_field', Input::has('field') ? Input::get('field') : (Session::has('item_field') ? Session::get('item_field') : 'name'));
        Session::put('item_sort', Input::has('sort') ? Input::get('sort') : (Session::has('item_sort') ? Session::get('item_sort') : 'asc'));
        $items = new Item();
        if (Session::get('item_category') != -1)
            $items = $items->where('item_category_id', Session::get('item_category'));
        $items = $items->where('name', 'like', '%' . Session::get('item_search') . '%')->orderBy(Session::get('item_field'), Session::get('item_sort'))->paginate(20);
        return view('item.index', ['items' => $items]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get'))
            return view('item.form', ['item' => Item::find($id)]);
        else {
            $item = Item::find($id);
            $rules = ["unit" => "required"];
            if (strtolower($item->name) != strtolower(Input::get('name')))
                $rules += ['name' => 'required'];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $item->name = Input::get('name');
            $item->item_category_id = Input::get('item_category_id');
            $item->unit = Input::get('unit');
            $item->user_id = Auth::user()->id;
            $item->save();
            Session::put('msg_status', true);
        }
    }

    public function unit($item_id)
    {
        return Item::find($item_id)->unit;
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get'))
            return view('item.form');
        else {
            $validator = Validator::make(Input::all(), [
                "name" => "required",
                "unit" => "required"
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $item = new Item();
            $item->name = Input::get('name');
            $item->item_category_id = Input::get('item_category_id');
            $item->unit = Input::get('unit');
            $item->user_id = Auth::user()->id;
            $item->save();
            Session::put('msg_status', true);
        }
    }

    public function delete($id)
    {
        Item::destroy($id);
        return redirect('item');
    }

}