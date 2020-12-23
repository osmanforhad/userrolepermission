<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return view('backend.pages.roles.index', compact('roles'));
    } //end of the index method

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_permissions = Permission::all();

        $permission_groups = User::getpermissionsGroups();
        //dd($permission_groups);
        return view('backend.pages.roles.create', compact('all_permissions', 'permission_groups'));
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
            'name' => 'required|max:100|unique:roles',
        ], [
            'name.required' => 'Please give a role name',
        ]);

        //data processing
        $role = Role::create(['name' => $request->name]);

        // $role = DB::table('roles')->where('name', $request->name)->first();
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }
        session()->flash('success', 'Role has been craeted !!');
        return back();

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
        $role = Role::findById($id);

        $all_permissions = Permission::all();

        $permission_groups = User::getpermissionsGroups();
//dd($permission_groups);
        return view('backend.pages.roles.edit', compact('role', 'all_permissions', 'permission_groups'));

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
            'name' => 'required|max:100|unique:roles,name,' . $id,
        ], [
            'name.required' => 'Please give a role name',
        ]);

        $role = Role::findById($id);

        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role has been updated !!');
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

        $role = Role::findById($id);

        if (!is_null($role)) {
            $role->delete();
        }

        session()->flash('success', 'Role has been deleted !!');
        return back();

    } //end of the destroy method

} //end of the RolesController class