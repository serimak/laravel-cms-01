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
use Illuminate\Support\Facades\Auth;
use App\Roles\CurrentPassword;

class ProfileController extends Controller
{
  private $_data = [];

  private function flash_messages($request, $status, $messages)
  {
    $request->session()->flash('flash_messages', ['status' => $status, 'messages' => $messages]);
  }

  private function _validator(array $data)
  {
    return Validator::make($data, [
      // 'username' => 'required|string|max:30',
      'password' => 'confirmed',
      'gender'  => 'required|in:Male,Female,Other',
      'title_id'  => 'required',
      'firstname_th'  => 'required|max:150',
      'firstname_en'  => 'required|max:150',
      'middlename_th'  => 'max:150',
      'middlename_en'  => 'max:150',
      'lastname_th'  => 'required|max:150',
      'lastname_en'  => 'required|max:150',
      'citizen_id'  => 'required|max:13',
      'passport_id'  => 'required|max:20',
      'birth_date'  => 'required|date_format:"Y-m-d"',
      'nationallity_id'  => 'required',
      'library_code'  => 'max:20'
      // 'group_id'  => 'required',
      // 'role_id'  => 'required',
      // 'active'  => 'required'
    ]);
  }

  private function _validatorPassword(array $data)
  {
    return Validator::make($data, [
      'current_password' => ['required', new CurrentPassword()],
      'password' => 'min:8|max:16|regex:/^.*(?=.{4,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X\*])[A-Za-z0-9_~\-$@#\$%\^&\*]+$/|confirmed'
    ]);
  }

  public function index(Request $request)
  {
    $id   = Auth::user()->id;
    $user = User::find($id);
    if($user) {

      if($request->isMethod('post')) {

        $validator        = $this->_validator($request->all());
        if ($validator->fails()) {

            $this->flash_messages($request, 'danger', 'Error! Please check your input.');

            return redirect()
                        ->route('profile')
                        ->withErrors($validator)
                        ->withInput();
        }

        // $user->username  = $request->username;
        $user->password  = bcrypt($request->password);
        $user->gender   = $request->gender;
        $user->title_id   = $request->title_id;
        $user->firstname_th   = $request->firstname_th;
        $user->firstname_en   = $request->firstname_en;
        $user->middlename_th   = $request->middlename_th;
        $user->middlename_en   = $request->middlename_en;
        $user->lastname_th   = $request->lastname_th;
        $user->lastname_en   = $request->lastname_en;
        $user->citizen_id   = $request->citizen_id;
        $user->passport_id   = $request->passport_id;
        $user->birth_date   = $request->birth_date;
        $user->nationallity_id   = $request->nationallity_id;
        $user->library_code   = $request->library_code;
        // $user->group_id   = $request->group_id;
        // $user->role_id   = $request->role_id;
        // $user->active   = $request->active;
        $user->save();

        if($request->password) {

          $validator->errors()->add('change_password', 'การเปลี่ยนรหัสผ่านของคุณ สำเร็จ!');

          $this->request->session()->flush();
          return redirect()
                      ->route('login')
                      ->withErrors($validator)
                      ->withInput();
        }

        $this->flash_messages($request, 'success', 'Success!');

        return redirect()->route('profile');
      } else {

        $this->_data['result']    = $user;

        $this->_data['nationalities'] = Nationality::all();
        $this->_data['titles']        = Title::all();
        $this->_data['groups']        = Group::all();
        $this->_data['roles']         = Role::all();

        return view('profile')->with($this->_data);
      }
    } else {

      return redirect()->route('profile');
    }
  }

  public function change_password(Request $request)
  {
    $id   = Auth::user()->id;
    $user = User::find($id);
    if($user) {

      if($request->isMethod('post')) {

        $validator = $this->_validatorPassword($request->all());
        
        if ($validator->fails()) {

            return redirect()
                        ->route('change_password')
                        ->withErrors($validator)
                        ->withInput();
        }

        if($request->password) {
          $user->password  = bcrypt($request->password);
        }

        $user->save();

        if($request->password) {

          $validator->errors()->add('change_password', 'การเปลี่ยนรหัสผ่านของคุณ สำเร็จ!');

          $this->request->session()->flush();
          return redirect()
                      ->route('login')
                      ->withErrors($validator)
                      ->withInput();
        }

        $this->flash_messages($request, 'success', 'Success!');

        return redirect()->route('profile');
      } else {

        $this->_data['result'] = $user;

        $this->_data['nationalities'] = Nationality::all();
        $this->_data['titles']        = Title::all();
        $this->_data['groups']        = Group::all();
        $this->_data['roles']         = Role::all();

        return view('change_password')->with($this->_data);
      }
    } else {

      return redirect()->route('change_password');
    }
  }

}
