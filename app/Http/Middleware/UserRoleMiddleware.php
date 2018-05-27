<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Models\User;
use App\Models\Campus;
use App\Models\Faculty;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

use Illuminate\Support\Facades\Session;

class UserRoleMiddleware extends Middleware
{

  private function initPermissionSession($request)
  {
    if(@env('APP_CHECK_DUP_SESSION')) {
      if(Auth::check()) {

          if(Auth::user()->remember_token != Session::getId() && !empty(Auth::user()->remember_token)) {

              Session::getHandler()->destroy(Auth::user()->remember_token);
              User::find(Auth::id())->update(['remember_token'=>Session::getId()]);
          } else {
            
              User::find(Auth::id())->update(['remember_token'=>Session::getId()]);
          }
      }
    }

    $auth     = Auth::user();
    $userId   = $auth->id;
    $roleId   = $auth->role_id;
    $user     = User::find($userId);
    $roles    = $user->role;

    $roleId   = 0;
    if (!$roles || !$roles->count()) {

      $permissionTable = null;
    } else {

      if($roles[0]->cms_level || $roles[0]->sa_level) {

        $roleId                 = $roles[0]->id;
        $validPermissionIdsMain = [];
        $validPermissionIdsSub  = [];
        $permissionRoleMain     = [];
        $permissionRoleSub      = [];
        $rolePermissions        = $roles[0]->permissions;

        foreach ($rolePermissions as $rolePermission) {

          if($rolePermission->cms_ref_type=="mmu") {

              $validPermissionIdsMain[]                         = $rolePermission->cms_ref_id;
              $permissionRoleMain[$rolePermission->cms_ref_id]  = [
                                                                    "read"      => $rolePermission->permission_r,
                                                                    "write"     => $rolePermission->permission_w,
                                                                    "delete"    => $rolePermission->permission_d,
                                                                    "super"     => $rolePermission->permission_s
                                                                  ];
          } else {

              $validPermissionIdsSub[]                          = $rolePermission->cms_ref_id;
              $permissionRoleSub[$rolePermission->cms_ref_id]   = [
                                                                    "read"      => $rolePermission->permission_r,
                                                                    "write"     => $rolePermission->permission_w,
                                                                    "delete"    => $rolePermission->permission_d,
                                                                    "super"     => $rolePermission->permission_s
                                                                  ];
          }
        }

        $menus            = Menu::all();
        $pageActions      = [];
        $permissionTable  = [];

        foreach ($menus as $menu) {

          if(!empty($permissionRoleMain[$menu->id])) {

            list($page, $action)    = $menu->menu_link;
            if (!array_key_exists($page, $pageActions)) {
              $pageActions[$page]   = [];
            }
            $pageActions[$page] []  = $action;

            $permissionTable[$menu->menu_link]['main'] = [
                                                    "mainAccept"    => in_array($menu->id, $validPermissionIdsMain),
                                                    'menu_name'     => $menu->menu_name,
                                                    'menu_key'      => $menu->menu_key,
                                                    'menu_seq'      => $menu->menu_seq,
                                                    'menu_link'     => $menu->menu_link,
                                                    'menu_icon'     => $menu->icon,
                                                    "menu_read"     => $permissionRoleMain[$menu->id]['read'],
                                                    "menu_write"    => $permissionRoleMain[$menu->id]['write'],
                                                    "menu_delete"   => $permissionRoleMain[$menu->id]['delete'],
                                                    "menu_super"    => $permissionRoleMain[$menu->id]['super'],
                                                ];

            if($menu->submenu) {

              foreach ($menu->submenu as $submenu) {

                if(in_array($submenu->id, $validPermissionIdsSub)) {

                    $permissionTable[$menu->menu_link]['sub'][$submenu->submenu_link] = [
                                                          "subAccept"           => in_array($submenu->id, $validPermissionIdsSub),
                                                          "submenu_name"        => $submenu->submenu_name,
                                                          'submenu_key'         => $submenu->submenu_key,
                                                          'submenu_seq'         => $submenu->submenu_seq,
                                                          'submenu_link'        => $submenu->submenu_link,
                                                          'submenu_icon'        => $submenu->icon,
                                                          "submenu_read"        => $permissionRoleSub[$submenu->id]['read'],
                                                          "submenu_write"       => $permissionRoleSub[$submenu->id]['write'],
                                                          "submenu_delete"      => $permissionRoleSub[$submenu->id]['delete'],
                                                          "submenu_super"       => $permissionRoleSub[$submenu->id]['super'],
                                                        ];
                }
              }
            }
          }
        }
        
      } else {

        $permissionTable = null;
      }
    }

    $request->session()->put('permissionTable', $permissionTable);
    return $permissionTable;
  }

  private function initUserInfo()
  {
    $auth     = Auth::user();
    $userId   = $auth->id;
    $user     = User::find($userId);
    $userInfo = [];

    // University
        switch ($user->group_id) {
          case '1':
            $student = $user->student;
            if(count($student)) {
              $student = $student[0];

              $userInfo['university']['campus_id']        = $student['campus_id'];
              $userInfo['university']['faculty_id']       = $student['faculty_id'];
              $userInfo['university']['department_id']    = $student['department_id'];
              $userInfo['university']['major_id']         = $student['major_id'];
            } else {
              $userInfo['university']['campus_id']        = null;
              $userInfo['university']['faculty_id']       = null;
              $userInfo['university']['department_id']    = null;
              $userInfo['university']['major_id']         = null;
            }
            break;
          case '2':
            $professere = $user->professeres;
            if(count($professere)) {
              $professere = $professere[0];

              $userInfo['university']['campus_id']        = $professere['campus_id'];
              $userInfo['university']['faculty_id']       = $professere['faculty_id'];
              $userInfo['university']['department_id']    = $professere['department_id'];
              $userInfo['university']['major_id']         = $professere['major_id'];
            } else {
              $userInfo['university']['campus_id']        = null;
              $userInfo['university']['faculty_id']       = null;
              $userInfo['university']['department_id']    = null;
              $userInfo['university']['major_id']         = null;
            }
            break;
          case '3':
            $professere = $user->staff;

            $campus = Campus::orderBy('created_by', 'desc')->get();
            $campus = $campus[0];

            $faculty = Faculty::where('campus_id', $campus->id)->orderBy('created_by', 'desc')->get();
            if(count($faculty)) {
              $faculty = $faculty[0];
              $userInfo['university']['campus_id']        = $campus->id;
              $userInfo['university']['faculty_id']       = $faculty->id;
              $userInfo['university']['department_id']    = null;
              $userInfo['university']['major_id']         = null;
            } else {
              $userInfo['university']['campus_id']        = null;
              $userInfo['university']['faculty_id']       = null;
              $userInfo['university']['department_id']    = null;
              $userInfo['university']['major_id']         = null;
            }
            break;
          case '4':
            $campus = Campus::orderBy('created_by', 'desc')->get();
            $campus = $campus[0];

            $faculty = Faculty::where('campus_id', $campus->id)->orderBy('created_by', 'desc')->get();
            if(count($faculty)) {
              $faculty = $faculty[0];
              $userInfo['university']['campus_id']        = $campus->id;
              $userInfo['university']['faculty_id']       = $faculty->id;
              $userInfo['university']['department_id']    = null;
              $userInfo['university']['major_id']         = null;
            } else {
              $userInfo['university']['campus_id']        = null;
              $userInfo['university']['faculty_id']       = null;
              $userInfo['university']['department_id']    = null;
              $userInfo['university']['major_id']         = null;
            }
            break;
          default:
            $userInfo['university']['campus_id']        = null;
            $userInfo['university']['faculty_id']       = null;
            $userInfo['university']['department_id']    = null;
            $userInfo['university']['major_id']         = null;
            break;
        }
    // Personal
      // $userInfo['personal'];
        $userInfo['personal']['imgProfile'] = $user->imgProfile;

    return $userInfo;
  }

  public function handle($request, Closure $next, $guard = null)
  {
    if(Auth::user()) {

      if (!$request->session()->has('permissionTable')) {
        $permissionTable = $this->initPermissionSession($request);
      } else {
        $permissionTable = $request->session()->get('permissionTable');
      }

      if(isset($permissionTable)) {
        $request->attributes->add(['permissions' => $permissionTable]);
        $request->attributes->add(['userinfo' => $this->initUserInfo()]);
        return $next($request);
      } else {

        return redirect()->route('login');
      }

    } else {
      return redirect()->route('login');
    }
  }

}