<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Service') }}
        </h2>
        @can('create complaints')
        <a href="{{route('service.create')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Create</a>
        @endcan
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-message></x-message>
            <table class="w-full" id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-3 py-3 text-center">CID</th>
                        <th class="px-3 py-3 text-center">Name</th>
                        <th class="px-3 py-3 text-center">Contact</th>
                        <th class="px-3 py-3 text-center">Payment Mode</th>
                        <th class="px-3 py-3 text-center">Final Billing</th>
                        <th class="px-3 py-3 text-center">Created</th>
                        <th class="px-3 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if($complaint->isNotEmpty())
                    @foreach($complaint as $list)
                    <tr class="border-b">
                        <td class="px-3 py-3 text-center">{{$list->complain_id}}</td>
                        <td class="px-3 py-3 text-center">{{$list->name}}</td>
                        <td class="px-3 py-3 text-center">{{$list->contact}}</td>
                        <td class="px-3 py-3 text-center">{{$list->payment}}</td>
                        <td class="px-3 py-3 text-center">{{$list->final_amt}}</td>
                        <td class="px-3 py-3 text-center">{{\Carbon\Carbon::parse($list->created_at)->format('d M, Y')}}</td>
                        <td class="px-3 py-3 text-center">
                            @can('edit services')
                            <a href="{{route('service.edit',$list->id)}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Edit</a>
                            @endcan
                            @can('delete services')
                            <a href="javascript:void(0)" onclick="deleteService({{$list->id}})" class="bg-red-500 text-sm rounded-md px-3 py-3 text-white">Delete</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="my-3">
        </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteService(id){
                if(confirm('Are you want to delete')){
                    $.ajax({
                        url:'{{route("service.destroy")}}',
                        type:'delete',
                        data:{id:id},
                        dataType:'json',
                        headers:{
                            'x-csrf-token':'{{csrf_token()}}'
                        },
                        success: function(response){
                            window.location.href ='{{route("service.index")}}'
                        }
                    });
                }

            }
        </script>
    </x-slot>
</x-app-layout>
