<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('backend.pages.users.index', compact('users'));
    } //end of the index method

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        //dd($permission_groups);
        return view('backend.pages.users.create', compact('roles'));
    } //end of the create method

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //data validation
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        //Create New User
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);

        }

        session()->flash('success', 'User has been created !!');
        return redirect()->route('admin.users.index');

    } //end of the store method

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findById($id);

        $roles = Role::all();

//dd($permission_groups);
        return view('backend.pages.users.edit', compact('user', 'roles'));

    } //end of the edit method

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //data validation
        $request->validate([
            'name' => 'required|max:100|unique:users,name,' . $id,
        ], [
            'name.required' => 'Please give a user name',
        ]);

        $users = User::findById($id);

        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $users->name = $request->name;
            $users->save();
            $users->syncPermissions($permissions);
        }

        session()->flash('success', 'User has been updated !!');
        return back();

    } //end of the update method

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::findById($id);

        if (!is_null($user)) {
            $user->delete();
        }

        session()->flash('success', 'User has been deleted !!');
        return back();

    } //end of the destroy method

} //end of the RolesController class