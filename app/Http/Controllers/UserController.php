<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        Session::put('user_search', Input::has('ok') ? Input::get('search') : (Session::has('user_search') ? Session::get('user_search') : ''));
        Session::put('user_field', Input::has('field') ? Input::get('field') : (Session::has('user_field') ? Session::get('user_field') : 'username'));
        Session::put('user_role', Input::has('role') ? Input::get('role') : (Session::has('user_role') ? Session::get('user_role') : -1));
        Session::put('user_sort', Input::has('sort') ? Input::get('sort') : (Session::has('user_sort') ? Session::get('user_sort') : 'asc'));
        $users = new User();
        if (Session::get('user_role') != -1)
            $users = $users->where('role', Session::get('user_role'));
        $users = $users->where('username', 'like', '%' . Session::get('user_search') . '%')
            ->where('role', '!=', 'SuperAdmin')
            ->orderBy(Session::get('user_field'), Session::get('user_sort'))->paginate(20);
        return view('user.index', ['users' => $users]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('get'))
            return view('user.form', ['user' => User::find($id)]);
        else {
            $user = User::find($id);
            $rules = [];
            if (strtolower($user->username) != strtolower(Input::get('username')))
                $rules += ['username' => 'required|alpha_dash|unique:users'];
            if (Input::get('password') != '')
                $rules += ['password' => 'confirmed'];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $user->username = Input::get('username');
            $user->role = Input::get('role');
            if (Input::get('password') != '')
                $user->password = bcrypt(Input::get('password'));
            $user->active = Input::get('active') ? 1 : 0;
            $user->save();
            Session::put('msg_status', true);
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get'))
            return view('user.form');
        else {
            $validator = Validator::make(Input::all(), [
                "username" => "required|alpha_dash|unique:users",
                'password' => 'required|confirmed'
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $user = new User();
            $user->username = Input::get('username');
            $user->role = Input::get('role');
            $user->password = bcrypt(Input::get('password'));
            $user->active = Input::get('active') ? 1 : 0;
            $user->save();
            Session::put('msg_status', true);
        }
    }

    public function delete($id)
    {
        User::destroy($id);
        return redirect('user');
    }

    public function changePassword(Request $request)
    {
        if ($request->isMethod('get'))
            return view("user.change_password", ['user' => Auth::user()]);
        else {
            $validator = Validator::make(Input::all(), [
                'old_password' => 'required',
                'password' => 'required|confirmed'
            ]);
            if ($validator->fails()) {
                return array(
                    'fail' => true,
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
            $user = Auth::user();
            if (Hash::check(Input::get('old_password'), $user->password)) {
                $user->password = Hash::make(Input::get('password'));
                $user->save();
                Session::put('change_password', true);
                return Redirect::back();
            } else
                return array(
                    'fail' => true,
                    'errors' => ["old_password" => "Old Password is incorrect. Please try again!"]
                );
        }
    }
}