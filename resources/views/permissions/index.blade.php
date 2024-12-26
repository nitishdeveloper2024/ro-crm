<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permissions') }}
        </h2>
        @can('create permissions')
        <a href="{{route('permission.create')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Create</a>
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
                        <th class="px-6 py-5 text-left">Created</th>
                        <th class="px-6 py-5 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if($permission->isNotEmpty())
                    @foreach($permission as $list)
                    <tr class="border-b">
                        <td class="px-6 py-5 text-left">{{$list->id}}</td>
                        <td class="px-6 py-5 text-left">{{$list->name}}</td>
                        <td class="px-6 py-5 text-left">{{\Carbon\Carbon::parse($list->created_at)->format('d M, Y')}}</td>
                        <td class="px-6 py-5 text-center">
                            @can('edit permissions')
                            <a href="{{route('permission.edit',$list->id)}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Edit</a>
                            @endcan
                            @can('delete permissions')
                            <a href="javascript:void(0)" onclick="deletePermission({{$list->id}})" class="bg-red-500 text-sm rounded-md px-3 py-3 text-white">Delete</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="my-3">
            {{$permission->links()}}
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
