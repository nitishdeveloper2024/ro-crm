<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Users / Create
        </h2>
        <a href="{{route('user.index')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Back</a>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('user.store')}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div  class="my-3">
                                <input placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="name" value="{{old('name')}}">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            
                            <label for="" class="text-lg font-medium">Email</label>
                            <div  class="my-3">
                                <input placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="email" value="{{old('email')}}">
                                @error('email')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Password</label>
                            <div  class="my-3">
                                <input placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="password" value="{{old('password')}}">
                                @error('password')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Confirm Password</label>
                            <div  class="my-3">
                                <input placeholder="Enter Name" type="password" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="confirm_password" value="{{old('confirm_password')}}">
                                @error('confirm_password')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-4 mb-2">
                                @if($roles->isNotEmpty())
                                @foreach($roles as $role)
                                <div class="mt-3">
                                    {{-- {{$hasRoles->contains($role->id) ? 'checked' : ''}} --}}
                                    <input   type="checkbox" name="role[]" id="role-{{$role->id}}" class="rounded" value="{{$role->name}}">
                                    <label for="role-{{$role->id}}">{{$role->name}}</label>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <button type="submit" class="hover:bg-slate-200 bg-slate-700 text-sm rounded-md px-5 py-3 text-white">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
