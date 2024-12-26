<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use App\Models\Role;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view users', only:['index']),
            new Middleware('permission:edit users', only:['edit']),
            new Middleware('permission:create users', only:['create']),
            new Middleware('permission:delete users', only:['destroy']),
        ];
    }
    public function index()
    {
        $users=User::latest()->paginate('10');

        return view('users.index',[
            'users'=> $users
        ]);
    }

    public function create()
    {
        // $users =User::findOrFail($id);
        $roles  =Role::orderBy('name','ASC')->get();
        // $hasRoles=$users->$roles->pluck('id');
        // $hasRoles = $users->roles ? $users->roles->pluck('id') : collect();  // Return an empty collection if no roles

        return view('users.create',[
            // 'users'=>$users,
            'roles'=>$roles,
            // 'hasRoles'=>$hasRoles
        ]);
    }

    public function edit(Request $request, string $id)
    {
        $users =User::findOrFail($id);
        $roles  =Role::orderBy('name','ASC')->get();
        // $hasRoles=$users->$roles->pluck('id');
        $hasRoles = $users->roles ? $users->roles->pluck('id') : collect();  // Return an empty collection if no roles

        // dd($hasRoles);
        // die();
        return view('users.edit',[
            'users'=>$users,
            'roles'=>$roles,
            'hasRoles'=>$hasRoles
        ]);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3',
            'email'=>'required|unique:users,email',
            'password'=>'required|min:5|same:confirm_password',
            'confirm_password'=>'required'
        ]);

        if($validator->passes()){
            $user= new User();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->save();

            $user->syncRoles($request->role);
            return redirect()->route('user.index')->with('success','User Created Successfully');
        
        }else{
        
            return redirect()->route('user.create')->withInput()->withErrors($validator);
        }
    }

    public function update(Request $request, $id)
    {
        $user=User::findorfail($id);

        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3',
            'email'=>'required|unique:users,email,'.$id.',id'
        ]);

        if($validator->passes()){
            
            $user->name=$request->name;
            $user->email=$request->email;
            $user->save();

            $user->syncRoles($request->role);
            return redirect()->route('user.index')->with('success','User Updated Successfully');
        
        }else{
        
            return redirect()->route('user.edit',$id)->withInput()->withErrors($validator);
        }
        
    }
}
