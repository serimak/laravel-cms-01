<?php

namespace App\Http\Controllers\Api;

use App\Models\Knowledge;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserRoleController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $userQuery = User::orderBy('created_at', 'desc');

    $keyword = $request->q;
    if ($keyword) {
      $userQuery = $userQuery->where('first_name_th', 'LIKE', "%$keyword%")
        ->orWhere('last_name_th', 'LIKE', "%$keyword%");
    }

    $role = $request->role;
    if ($role && $role !== 'all') {
      $userQuery = User::whereHas('roles', function ($query) use ($role) {
        $query->where('id', '=', $role);
      });
    } else {
      $userQuery = $userQuery->has('roles');
    }

    $users = $userQuery->get();
    foreach ($users as $user) {
      $user->roles;
    }
    return response()->json($users);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $user = User::find($request->name);
    if (!$user) {
      return response()->json(null);
    }

    $role = Role::find($request->role);
    if (!$role) {
      return response()->json(null);
    }

    if (User::has('roles')->where('id', $request->name)->count()) {
      return response()->json(null);
    }

    $user->roles()->attach($request->role);
    $user->roles;
    return response()->json($user);
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::find($id);
    if (!$user) {
      return response()->json(null);
    }
    $user->roles;
    return response()->json($user);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $user = User::find($id);
    if (!$user) {
      return response()->json(null);
    }

    $role = Role::find($request->role);
    if (!$role) {
      return response()->json(null);
    }

    $user->roles()->sync([$request->role]);
    $user->roles;
    return response()->json($user);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::find($id);
    if (!$user) {
      return response()->json(null);
    }

    $user->roles()->sync([]);
  }
}
