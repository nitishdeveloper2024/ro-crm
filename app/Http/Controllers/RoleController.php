<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only:['index']),
            new Middleware('permission:edit roles', only:['edit']),
            new Middleware('permission:create roles', only:['create']),
            new Middleware('permission:delete roles', only:['destroy']),
        ];
    }
    public function index(){

        $permissions=Role::orderBy('created_at','DESC')->paginate(10);
        return view('roles.index',[
            'permissions'=>$permissions
            ]);
    }

    public function create(){

        $permissions=Permission::orderBy('created_at','DESC')->paginate(10);
        return view('roles.create',['permissions'=>$permissions]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles|min:3'
        ]);
        if($validator->passes()){
            $role=Role::create(['name' => $request->name]);
            if(!empty($request->permission)){
                // dd($request->permission);
                foreach($request->permission as $name){
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('role.index')->with('success','Role Added Successfully');
        }else{
            return redirect()->route('role.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id){
        $role = Role::findorfail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions=Permission::orderBy('created_at','ASC')->get();

        return view('roles.edit',[
            'hasPermissions' =>$hasPermissions,
            'permissions' =>$permissions,
            'role'=>$role
        ]);
    }
    public function update($id, Request $request){
        $role = Role::findorfail($id);
        
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles,name,'.$id.',id'
        ]);
        if($validator->passes()){

            $role->name=$request->name;
            $role->save();
            
            if(!empty($request->permission)){
                // dd($request->permission);
                $role->syncPermissions($request->permission);
            }else{
                $role->syncPermissions([]);
            }
            return redirect()->route('role.index')->with('success','Role Updated Successfully');
        }else{
            return redirect()->route('role.edit',$id)->withInput()->withErrors($validator);
        }
    }
    public function destroy(Request $request){
        $id=$request->id;
        $role=Role::find($id);
        if($role ==null){
            session()->flash('error','Role not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $role->delete();
        session()->flash('success','Role deleted Success');
        return response()->json([
            'status'=>true
        ]);
    }
}
