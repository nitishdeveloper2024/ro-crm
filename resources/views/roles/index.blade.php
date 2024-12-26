<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Roles
        </h2>
        <a href="{{route('role.create')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Create</a>
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
                        <th class="px-6 py-5 text-left">Permissions</th>
                        <th class="px-6 py-5 text-left">Created</th>
                        <th class="px-6 py-5 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if($permissions->isNotEmpty())
                    @foreach($permissions as $list)
                    <tr class="border-b">
                        <td class="px-6 py-5 text-left">{{$list->id}}</td>
                        <td class="px-6 py-5 text-left">{{$list->name}}</td>
                        <td class="px-6 py-5 text-left">{{$list->permissions->pluck('name')->implode(', ')}}</td>
                        <td class="px-6 py-5 text-left w-5">{{\Carbon\Carbon::parse($list->created_at)->format('d M, Y')}}</td>
                        <td class="px-6 py-5 text-center flex space-x-1">
                            <a href="{{route('role.edit',$list->id)}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Edit</a>
                            <a href="javascript:void(0)" onclick="deleteRole({{$list->id}})" class="bg-red-500 text-sm rounded-md px-3 py-3 text-white">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="my-3">
            {{$permissions->links()}}
        </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteRole(id){
                if(confirm('Are you want to delete')){
                    $.ajax({
                        url:'{{route("role.destroy")}}',
                        type:'delete',
                        data:{id:id},
                        dataType:'json',
                        headers:{
                            'x-csrf-token':'{{csrf_token()}}'
                        },
                        success: function(response){
                            window.location.href ='{{route("role.index")}}'
                        }
                    });
                }

            }
        </script>
    </x-slot>
</x-app-layout>
