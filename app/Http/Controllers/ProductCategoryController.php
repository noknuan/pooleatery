<?php
namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function index()
    {
        Session::put('product_category_search', Input::has('ok') ? Input::get('search') : (Session::has('product_category_search') ? Session::get('product_category_search') : ''));
        Session::put('product_category_field', Input::has('field') ? Input::get('field') : (Session::has('product_category_field') ? Session::get('product_category_field') : 'name'));
        Session::put('product_category_sort', Input::has('sort') ? Input::get('sort') : (Session::has('product_category_sort') ? Session::get('product_category_sort') : 'asc'));
        $product_categories = ProductCategory::where('name', 'like', '%' . Session::get('product_category_search') . '%')->orderBy(Session::get('product_category_field'), Session::get('product_category_sort'))->paginate(20);
        return view('product_category.index', ['product_categories' => $product_categories]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get'))
            return view('product_category.form', ['product_category' => ProductCategory::find($id)]);
        else {
            $product_category = ProductCategory::find($id);
            $rules = ["ordering" => "nullable|numeric"];
            if ($product_category->name != Input::get('name'))
                $rules += ['name' => 'required|unique:product_categories'];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $product_category->name = Input::get('name');
            $product_category->ordering = Input::get('ordering');
            $product_category->save();
            Session::put('msg_status', true);
        }
    }


    public function create(Request $request)
    {
        if ($request->isMethod('get'))
            return view('product_category.form');
        else {
            $validator = Validator::make(Input::all(), [
                "name" => "required|unique:product_categories",
                "ordering" => "nullable|numeric"
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $product_category = new ProductCategory();
            $product_category->name = Input::get('name');
            $product_category->ordering = Input::get('ordering');
            $product_category->save();
            Session::put('msg_status', true);
        }
    }

    public function delete($id)
    {
        ProductCategory::destroy($id);
        return redirect('product_category');
    }

}