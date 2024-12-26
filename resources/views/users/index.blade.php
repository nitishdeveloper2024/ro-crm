<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
        @can('create users')
        <a href="{{route('user.create')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Create</a>
        @endcan
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-message></x-message>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-5 text-left">#</th>
                        <th class="px-6 py-5 text-left">Name</th>
                        <th class="px-6 py-5 text-left">Roles</th>
                        <th class="px-6 py-5 text-left">Email</th>
                        <th class="px-6 py-5 text-left">Created</th>
                        <th class="px-6 py-5 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if($users->isNotEmpty())
                    @foreach($users as $list)
                    <tr class="border-b">
                        <td class="px-6 py-5 text-left">{{$list->id}}</td>
                        <td class="px-6 py-5 text-left">{{$list->name}}</td>
                        <td class="px-6 py-5 text-left">{{$list->roles->pluck('name')->implode(', ')}}</td>
                        <td class="px-6 py-5 text-left">{{$list->email}}</td>
                        <td class="px-6 py-5 text-left">{{\Carbon\Carbon::parse($list->created_at)->format('d M, Y')}}</td>
                        <td class="px-6 py-5 text-center">
                            @can('edit users')
                            <a href="{{route('user.edit',$list->id)}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Edit</a>
                            @endcan
                            @can('delete users')
                            <a href="javascript:void(0)" onclick="deleteUser({{$list->id}})" class="bg-red-500 text-sm rounded-md px-3 py-3 text-white">Delete</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="my-3">
            {{$users->links()}}
        </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deletePermission(id){
                if(confirm('Are you want to delete')){
                    $.ajax({
                        url:'{{route("permission.destroy")}}',
                        type:'delete',
                        data:{id:id},
                        dataType:'json',
                        headers:{
                            'x-csrf-token':'{{csrf_token()}}'
                        },
                        success: function(response){
                            window.location.href ='{{route("permission.index")}}'
                        }
                    });
                }

            }
        </script>
    </x-slot>
</x-app-layout>
