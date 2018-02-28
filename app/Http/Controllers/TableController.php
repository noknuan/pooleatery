<?php
namespace App\Http\Controllers;

use App\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    public function index()
    {
        Session::put('table_search', Input::has('ok') ? Input::get('search') : (Session::has('table_search') ? Session::get('table_search') : ''));
        Session::put('table_field', Input::has('field') ? Input::get('field') : (Session::has('table_field') ? Session::get('table_field') : 'name'));
        Session::put('table_sort', Input::has('sort') ? Input::get('sort') : (Session::has('table_sort') ? Session::get('table_sort') : 'asc'));
        $tables = new Table();
        $tables = $tables->where('name', 'like', '%' . Session::get('table_search') . '%')->orderBy(Session::get('table_field'), Session::get('table_sort'))->paginate(20);
        return view('table.index', ['tables' => $tables]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get'))
            return view('table.form', ['table' => Table::find($id)]);
        else {
            $table = Table::find($id);
            $rules = [];
            if ($table->name != Input::get('name'))
                $rules += ['name' => 'required|unique:tables'];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $table->name = Input::get('name');
            $table->save();
            Session::put('msg_status', true);
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get'))
            return view('table.form');
        else {
            $validator = Validator::make(Input::all(), [
                "name" => "required|unique:tables"
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $table = new Table();
            $table->name = Input::get('name');
            $table->save();
            Session::put('msg_status', true);
        }
    }

    public function delete($id)
    {
        Table::destroy($id);
        return redirect('table');
    }

}