<?php
namespace App\Http\Controllers;

use App\Item;
use App\Product;
use App\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    public function index()
    {
        Session::put('recipe_category', Input::has('category') ? Input::get('category') : (Session::has('recipe_category') ? Session::get('recipe_category') : -1));
        Session::put('recipe_type', Input::has('type') ? Input::get('type') : (Session::has('recipe_type') ? Session::get('recipe_type') : -1));
        Session::put('recipe_product_id', Input::has('product_id') ? Input::get('product_id') : (Session::has('recipe_product_id') ? Session::get('recipe_product_id') : -1));

        if (Session::get('recipe_category') == -1 and Session::get('recipe_type') == -1)
            $products = [];
        else {
            $products = new Product();
            if (Session::get('recipe_category') != -1)
                $products = $products->where('product_category_id', Session::get('recipe_category'));
            if (Session::get('recipe_type') != -1)
                $products = $products->where('product_type_id', Session::get('recipe_type'));
            $products = $products->orderBy('name')->pluck('name', 'id')->toArray();
        }
        return view('recipe.index', ['products' => ['-1' => ''] + $products, 'product' => Product::find(Session::get('recipe_product_id'))]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get'))
            return view('recipe.form', ['recipe' => Recipe::find($id)]);
        else {
            $validator = Validator::make(Input::all(), [
                "quantity" => "required|numeric"
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $recipe = Recipe::find($id);
            $recipe->product_id = Session::get('recipe_product_id');
            $recipe->item_id = Input::get('item_id');
            $recipe->quantity = Input::get('quantity');
            $recipe->user_id = Auth::user()->id;
            $recipe->save();
            Session::put('msg_status', true);
        }
    }


    public function create(Request $request)
    {
        if ($request->isMethod('get'))
            return view('recipe.form');
        else {
            $validator = Validator::make(Input::all(), [
                "quantity" => "required|numeric"
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $recipe = new Recipe();
            $recipe->product_id = Session::get('recipe_product_id');
            $recipe->item_id = Input::get('item_id');
            $recipe->quantity = Input::get('quantity');
            $recipe->user_id = Auth::user()->id;
            $recipe->save();
            Session::put('msg_status', true);
        }
    }

    public function delete($id)
    {
        Recipe::destroy($id);
        return redirect('recipe');
    }

}