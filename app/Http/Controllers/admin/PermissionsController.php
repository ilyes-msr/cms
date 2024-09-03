<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function index()
    {
        $permissions = $this->permission->all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        Role::find($request->role_id)->permissions()->sync($request->permission);
        return back()->with('success', 'تم حفظ الصلاحيات الجديدة');
    }
}
