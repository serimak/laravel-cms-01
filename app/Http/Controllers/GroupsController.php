<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class GroupsController extends Controller
{
  private $_data = [];

  private function flash_messages($request, $status, $messages)
  {
    $request->session()->flash('flash_messages', ['status' => $status, 'messages' => $messages]);
  }

  private function _validator(array $data)
  {
    return Validator::make($data, [
      'role_name' => 'required|string',
      'cms_level' => 'required|integer',
      'sa_level'  => 'integer'
    ]);
  }

  private function _listMenu($roleId=null)
  {
    $role   = Role::find($roleId);
    $array  = [];

    if($role) {

        $permissions = $role->permissions;

        foreach ($permissions as $key => $value) {

            if($value['cms_ref_type']=="mmu") {

                $array['main'][$value['cms_ref_id']]     = $value;

            } else {

                $array['submenu'][$value['cms_ref_id']]  = $value;
            }
        }

        $menu = Menu::with('submenu')->orderBy('menu_seq', 'asc')->get();

        foreach ($menu as $key => $value) {
            
            if(@$array['main'][$value->id]['cms_ref_id']==$value->id) {

                $menu[$key]['checked']       = "checked=''";
                $menu[$key]['permission_r']  = ( $array['main'][$value->id]['permission_r'] ? "checked=''" : "" );
                $menu[$key]['permission_w']  = ( $array['main'][$value->id]['permission_w'] ? "checked=''" : "" );
                $menu[$key]['permission_d']  = ( $array['main'][$value->id]['permission_d'] ? "checked=''" : "" );
                $menu[$key]['permission_s']  = ( $array['main'][$value->id]['permission_s'] ? "1" : "" );
            } else {

                $menu[$key]['checked']       = "";
                $menu[$key]['permission_r']  = "";
                $menu[$key]['permission_w']  = "";
                $menu[$key]['permission_d']  = "";
                $menu[$key]['permission_s']  = "";
            }

            if(!empty($value->submenu)) {

                foreach ($value->submenu as $k => $v) {

                    if($v->menu_id==$value->id) {

                        if(@$array['submenu'][$v->id]['cms_ref_id']==$v->id) {

                            $value->submenu[$k]['checked']       = "checked=''";
                            $value->submenu[$k]['permission_r']  = ( $array['submenu'][$v->id]['permission_r'] ? "checked=''" : "" );
                            $value->submenu[$k]['permission_w']  = ( $array['submenu'][$v->id]['permission_w'] ? "checked=''" : "" );
                            $value->submenu[$k]['permission_d']  = ( $array['submenu'][$v->id]['permission_d'] ? "checked=''" : "" );
                            $value->submenu[$k]['permission_s']  = ( $array['submenu'][$v->id]['permission_'] ? "1" : "" );
                        } else {

                            $value->submenu[$k]['checked']       = "";
                            $value->submenu[$k]['permission_r']  = "";
                            $value->submenu[$k]['permission_w']  = "";
                            $value->submenu[$k]['permission_d']  = "";
                            $value->submenu[$k]['permission_s']  = "";
                        }

                    }
                }
            }
        }

        return $menu;
    } else {

        $menu = Menu::with('submenu')->orderBy('menu_seq', 'asc')->get();
    }

    return $menu;
  }

  public function index()
  {
    $this->_data['result'] = Role::all();
    return view('Group.list')->with($this->_data);
  }

  public function create(Request $request)
  {
    if($request->isMethod('post')) {

      $validator = $this->_validator($request->all());
      if ($validator->fails()) {
          return redirect()
                      ->route('group.add')
                      ->withErrors($validator)
                      ->withInput();
      }

      $role = new Role;
      $role->role_name  = $request->role_name;
      $role->cms_level  = ($request->cms_level ? "1" : "0" );
      $role->sa_level   = ($request->sa_level ? "1" : "0" );
      $role->save();

      if(!empty($request->menu)) {

        foreach ($request->menu as $key => $value) {

          foreach ($value as $k => $v) {

            $permission                 = new Permission;
            $permission->role_id        = $role->id;
            $permission->cms_ref_type   = $key;
            $permission->cms_ref_id     = $k;
            $permission->permission_r   = $request->permission_r[$key][$k];
            $permission->permission_w   = $request->permission_w[$key][$k];
            $permission->permission_d   = $request->permission_d[$key][$k];

            if($request->permission_s=="y") {

              $permission->permission_d = "1";
            } else {

              $permission->permission_d = "0";
            }

            $permission->save();
          }
        }
      }

      return redirect()->route('group');
    } else {

      $this->_data['all_menu'] = $this->_listMenu();

      return view('Group.add')->with($this->_data);
    }
  }

  public function edit(Request $request, $id)
  {
    $role = Role::find($id);
    if($role) {

      if($request->isMethod('post')) {

        $validator        = $this->_validator($request->all());
        if ($validator->fails()) {
            return redirect()
                        ->route('group.edit', [$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $role->role_name  = $request->role_name;
        $role->cms_level  = ($request->cms_level ? "1" : "0" );
        $role->sa_level   = ($request->sa_level ? "1" : "0" );
        $role->save();

        $permissions = $role->permissions;
        if(!empty($request->menu)) {

          $i = 0;
          $select = [];
          foreach ($request->menu as $key => $value) {

            foreach ($value as $k => $v) {

                  $permission   = Permission::where('role_id', $id)->where('cms_ref_type', $key)->where('cms_ref_id', $k)->get();

                  if(count($permission)) {

                      $permission   = $permission[0];
                      $select[$i]   = $permission['id'];

                      $permission['permission_r']   = (@$request->permission_r[$key][$k] ? $request->permission_r[$key][$k]:"0");
                      $permission['permission_w']   = (@$request->permission_w[$key][$k] ? $request->permission_w[$key][$k]:"0");
                      $permission['permission_d']   = (@$request->permission_d[$key][$k] ? $request->permission_d[$key][$k]:"0");

                      if($request->permission_s=="y") {

                        $permission['permission_s'] = "1";
                      } else {

                        $permission['permission_s'] = "0";
                      }

                      $permission->save();
                  } else {

                      $permissionNew                 = new Permission;
                      $permissionNew->role_id        = $id;
                      $permissionNew->cms_ref_type   = $key;
                      $permissionNew->cms_ref_id     = $k;
                      $permissionNew->permission_r   = (@$request->permission_r[$key][$k] ? $request->permission_r[$key][$k]:"0");
                      $permissionNew->permission_w   = (@$request->permission_w[$key][$k] ? $request->permission_w[$key][$k]:"0");
                      $permissionNew->permission_d   = (@$request->permission_d[$key][$k] ? $request->permission_d[$key][$k]:"0");

                      if($request->permission_s=="y") {

                        $permissionNew->permission_s = "1";
                      } else {

                        $permissionNew->permission_s = "0";
                      }

                      $permissionNew->save();
                      $select[$i]   = $permissionNew->id;
                  }
                  $i++;

            }
          }

          if($select) {
            Permission::where('role_id', $role->id)->whereNotIn('id', $select)->delete();
          }

          return redirect()->route('group');
        }

      } else {

        $this->_data['result']    = $role;

        $permission = $role->permissions;
        $this->_data['permission_s']  = ( @$permission[0]['permission_s'] ? "y" : "n" );

        $this->_data['all_menu']  = $this->_listMenu($role->id);

        return view('Group.edit')->with($this->_data);
      }
    } else {

      return redirect()->route('group');
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
                    ->route('group')
                    ->withErrors($validator)
                    ->withInput();
    }

    switch ($request->action) {
      case 'delete':
        $role = Role::find($request->id);
        Permission::where('role_id', $role->id)->delete();
        $role->delete();

        $this->flash_messages($request, 'success', 'Success!');
        break;

      case 'delete_all':
        $id_array = json_decode($request->id);
        Permission::whereIn('role_id', $id_array)->delete();
        Role::destroy($id_array);

        $this->flash_messages($request, 'success', 'Success!');
        break;

      default:
        $this->flash_messages($request, 'danger', 'Error!');
        break;
    }

    return redirect()->route('group');
  }
}
