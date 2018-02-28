<?php
namespace App\Http\Controllers;

use App\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ItemCategoryController extends Controller
{
    public function index()
    {
        Session::put('item_category_search', Input::has('ok') ? Input::get('search') : (Session::has('item_category_search') ? Session::get('item_category_search') : ''));
        Session::put('item_category_field', Input::has('field') ? Input::get('field') : (Session::has('item_category_field') ? Session::get('item_category_field') : 'name'));
        Session::put('item_category_sort', Input::has('sort') ? Input::get('sort') : (Session::has('item_category_sort') ? Session::get('item_category_sort') : 'asc'));
        $item_categories = ItemCategory::where('name', 'like', '%' . Session::get('item_category_search') . '%')->orderBy(Session::get('item_category_field'), Session::get('item_category_sort'))->paginate(20);
        return view('item_category.index', ['item_categories' => $item_categories]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get'))
            return view('item_category.form', ['item_category' => ItemCategory::find($id)]);
        else {
            $item_category = ItemCategory::find($id);
            if (strtolower($item_category->name) != strtolower(Input::get('name'))) {
                $validator = Validator::make(Input::all(), [
                    'name' => 'required|unique:item_categories'
                ]);
                if ($validator->fails()) {
                    return array(
                        'fail' => true,
                        'errors' => $validator->getMessageBag()->toArray()
                    );
                }
            }
            $item_category->name = Input::get('name');
            $item_category->save();
            Session::put('msg_status', true);
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get'))
            return view('item_category.form');
        else {
            $validator = Validator::make(Input::all(), [
                "name" => "required|unique:item_categories"
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $item_category = new ItemCategory();
            $item_category->name = Input::get('name');
            $item_category->save();
            Session::put('msg_status', true);
        }
    }

    public function delete($id)
    {
        ItemCategory::destroy($id);
        return redirect('item_category');
    }

}