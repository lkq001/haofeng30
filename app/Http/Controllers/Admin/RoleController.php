<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permission;
use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Zizaco\Entrust\Entrust;

class RoleController extends AdminController
{

    public function index()
    {
        $user = User::find(1);

//        dump($user->hasRole('owner')); // false
//        dump($user->hasRole('admin')); // true
//        dump($user->can('edit-user')); // true
//        dump($user->can('create-post')); // true
//
//        dump($user->hasRole(['owner', 'admin'])); // true
//        dump($user->can(['edit-user', 'create-post'])); // true
//
//        dump($user->hasRole(['owner', 'admin'])); // true
//        dump($user->hasRole(['owner', 'admin'], true)); // false
//        dump($user->can(['edit-user', 'create-post'])); // true
//        dump($user->can(['edit-user', 'create-post'], true)); // false

        dd(Entrust::hasRole('role-name'));
        dd(Entrust::can('permission-name'));


    }
}
