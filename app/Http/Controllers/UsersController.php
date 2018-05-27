<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;
use App\Models\Nationality;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
  private $_data = [];

  private function flash_messages($request, $status, $messages)
  {
    $request->session()->flash('flash_messages', ['status' => $status, 'messages' => $messages]);
  }

  private function _validator(array $data)
  {
    return Validator::make($data, [
      'username' => 'required|string|max:30',
      'password' => 'confirmed',
      'gender'  => 'required|in:Male,Female,Other',
      'title_id'  => 'required',
      'firstname_th'  => 'required|max:150',
      'firstname_en'  => 'required|max:150',
      'middlename_th'  => 'max:150',
      'middlename_en'  => 'max:150',
      'lastname_th'  => 'required|max:150',
      'lastname_en'  => 'required|max:150',
      'citizen_id'  => 'nullable|max:13',
      'passport_id'  => 'nullable|max:20',
      'birth_date'  => 'required|date_format:"Y-m-d"',
      'nationallity_id'  => 'required',
      'library_code'  => 'max:20',
      'group_id'  => 'required',
      'role_id'  => 'required',
      'active'  => 'required'
    ]);
  }

  public function index()
  {
    $groups = Group::all();
    $roles  = Role::all();
    $this->_data['result'] = User::with([
                                    'getGroup',
                                    'getRole'
                                  ])
                                  ->orderBy('username','desc')->get();

    return view('User.list')->with($this->_data);
  }

  public function create(Request $request)
  {
    if($request->isMethod('post')) {

      $validator = $this->_validator($request->all());
      if ($validator->fails()) {
          return redirect()
                      ->route('user.add')
                      ->withErrors($validator)
                      ->withInput();
      }

      $user = new User;
      $user->username = $request->username;
      $user->password = bcrypt($request->password);
      $user->user_code = $request->username;
      $user->gender = $request->gender;
      $user->title_id = $request->title_id;
      $user->firstname_th = $request->firstname_th;
      $user->firstname_en = $request->firstname_en;
      $user->middlename_th = $request->middlename_th;
      $user->middlename_en = $request->middlename_en;
      $user->lastname_th = $request->lastname_th;
      $user->lastname_en = $request->lastname_en;
      $user->citizen_id = $request->citizen_id;
      $user->passport_id = $request->passport_id;
      $user->birth_date = $request->birth_date;
      $user->nationallity_id = $request->nationallity_id;
      $user->library_code = $request->library_code;
      $user->group_id = $request->group_id;
      $user->role_id = $request->role_id;
      $user->auth_type = "local";
      $user->active = $request->active;
      $user->save();

      return redirect()->route('user');
    } else {

      $this->_data['nationalities'] = Nationality::all();
      $this->_data['titles']        = Title::all();
      $this->_data['groups']        = Group::all();
      $this->_data['roles']         = Role::all();

      return view('User.add')->with($this->_data);
    }
  }

  public function edit(Request $request, $id)
  {
    $user = User::find($id);
    if($user) {

      if($request->isMethod('post')) {

        $validator = $this->_validator($request->all());
        if ($validator->fails()) {
            return redirect()->route('user.edit', [$id])
                             ->withErrors($validator)
                             ->withInput();
        }
        //dd($request);
        $user->username = $request->username;
        if($request->password != null){
          $user->password = bcrypt($request->password);
        }
        $user->user_code = $request->username;
        $user->gender = $request->gender;
        $user->title_id = $request->title_id;
        $user->firstname_th = $request->firstname_th;
        $user->firstname_en = $request->firstname_en;
        $user->middlename_th = $request->middlename_th;
        $user->middlename_en = $request->middlename_en;
        $user->lastname_th = $request->lastname_th;
        $user->lastname_en = $request->lastname_en;
        $user->citizen_id = $request->citizen_id;
        $user->passport_id = $request->passport_id;
        $user->birth_date = $request->birth_date;
        $user->nationallity_id = $request->nationallity_id;
        $user->library_code = $request->library_code;
        $user->group_id = $request->group_id;
        $user->role_id = $request->role_id;
        $user->auth_type = "local";
        $user->active = $request->active;
        $user->save();

        return redirect()->route('user');
      } else {

        $this->_data['result']    = $user;

        $this->_data['nationalities'] = Nationality::all();
        $this->_data['titles']        = Title::all();
        $this->_data['groups']        = Group::all();
        $this->_data['roles']         = Role::all();

        return view('User.edit')->with($this->_data);
      }
    } else {

      return redirect()->route('user');
    }
  }

  public function update(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'id' => 'required',
      'action' => 'required|string'
    ]);

    if ($validator->fails()) {
        return redirect()
                    ->route('user')
                    ->withErrors($validator)
                    ->withInput();
    }

    switch ($request->action) {
      case 'delete':
        $role = User::find($request->id);
        $role->delete();

        $this->flash_messages($request, 'success', 'Success!');
        break;

      case 'delete_all':
        $id_array = json_decode($request->id);
        User::destroy($id_array);

        $this->flash_messages($request, 'success', 'Success!');
        break;

      case 'active':
        $id_array = json_decode($request->id);
        User::whereIn('id',$id_array)->update(['active' => '1']);

        $this->flash_messages($request, 'success', 'Success!');
        break;

      case 'unactive':
        $id_array = json_decode($request->id);
        User::whereIn('id',$id_array)->update(['active' => '0']);

        $this->flash_messages($request, 'success', 'Success!');
        break;

      default:
        $this->flash_messages($request, 'danger', 'Error!');
        break;
    }

    return redirect()->route('user');
  }
}
