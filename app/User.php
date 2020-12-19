<?php

namespace App;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getpermissionsGroups()
    {
        $permission_groups = DB::table('permissions')->select('group_name as name')->groupBy('group_name')->get();

        return $permission_groups;
    } //end of the getpermissionsGroup method

    public static function getpermissionsByGroupName($group_name)
    {
        $permissions = DB::table('permissions')->select('name', 'id')->where('group_name', $group_name)->get();

        return $permissions;
    } //end of the getpermissionsByGroupName method

} //end of the User class