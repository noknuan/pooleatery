<?php
namespace App\Http\Controllers;

use App\Lib\ResizeImageFile;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        Session::put('product_search', Input::has('ok') ? Input::get('search') : (Session::has('product_search') ? Session::get('product_search') : ''));
        Session::put('product_category', Input::has('category') ? Input::get('category') : (Session::has('product_category') ? Session::get('product_category') : -1));
        Session::put('product_field', Input::has('field') ? Input::get('field') : (Session::has('product_field') ? Session::get('product_field') : 'name'));
        Session::put('product_sort', Input::has('sort') ? Input::get('sort') : (Session::has('product_sort') ? Session::get('product_sort') : 'asc'));
        $products = new Product();
        if (Session::get('product_category') != -1)
            $products = $products->where('product_category_id', Session::get('product_category'));
        $products = $products->where('name', 'like', '%' . Session::get('product_search') . '%')
            ->orderBy(Session::get('product_field'), Session::get('product_sort'))->paginate(10);
        return view('product.index', ['products' => $products]);
    }

    public function printProducts()
    {
        if (Session::get('product_category') != -1)
            $categories = ProductCategory::find(Session::get('product_category'));
        else
            $categories = ProductCategory::orderBy('name')->get();
        return view('product.print', ['categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get'))
            return view('product.form', ['product' => Product::find($id)]);
        else {
            $product = Product::find($id);
            $rules = ["unitprice" => "required|numeric"];
            if ($product->name != Input::get('name'))
                $rules += ['name' => 'required|unique:products'];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $product->name = Input::get('name');
            $product->product_category_id = Input::get('product_category_id');
            $product->product_type_id = Input::get('product_type_id');
            $product->unitprice = Input::get('unitprice');
            $product->user_id = Auth::user()->id;
            if (Input::hasFile('image')) {
                if ($product->image != '')
                    File::delete('/images/products/' . $product->image);
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $dir = 'images/products/';
                $fileName = str_random() . '.' . $extension; // renameing image
                Input::file('image')->move($dir, $fileName);
                $resize = new ResizeImageFile($dir . $fileName);
                $resize->resizeImage(150, 130, 'exact');
                $resize->saveImage($dir . $fileName, 100);
                $product->image = $fileName;
            }
            if (Input::get('remove') == 1) {
                File::delete('/images/products/' . $product->image);
                $product->image = null;
            }
            $product->save();
            Session::put('msg_status', true);
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get'))
            return view('product.form');
        else {
            $validator = Validator::make(Input::all(), [
                "name" => "required|unique:products",
                "unitprice" => "required|numeric"
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $product = new Product();
            $product->name = Input::get('name');
            $product->product_category_id = Input::get('product_category_id');
            $product->product_type_id = Input::get('product_type_id');
            $product->unitprice = Input::get('unitprice');
            $product->user_id = Auth::user()->id;
            if (Input::hasFile('image')) {
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $dir = 'images/products/';
                $fileName = str_random() . '.' . $extension; // renameing image
                Input::file('image')->move($dir, $fileName);
                $resize = new ResizeImageFile($dir . $fileName);
                $resize->resizeImage(150, 130, 'exact');
                $resize->saveImage($dir . $fileName, 100);
                $product->image = $fileName;
            }
            if (Input::get('remove') == 1) {
                File::delete('/images/products/' . $product->image);
                $product->image = null;
            }
            $product->save();
            Session::put('msg_status', true);
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);
        File::delete('/images/products/' . $product->image);
        $product->delete();
        return redirect('product');
    }
}