<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('PartSales') }}
        </h2>
        @can('create sales')
        <a href="{{route('partsale.create')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Create</a>
        @endcan
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-message></x-message>
            <table class="w-full" id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-3 py-3 text-center">#</th>
                        <th class="px-3 py-3 text-center">Name</th>
                        <th class="px-3 py-3 text-center">Contact</th>
                        <th class="px-3 py-3 text-center">Image</th>
                        <th class="px-3 py-3 text-center">MRP</th>
                        <th class="px-3 py-3 text-center">Sale Price</th>
                        {{-- <th class="px-3 py-3 text-center">Discount</th> --}}
                        <th class="px-3 py-3 text-center">Billed Price</th>
                        <th class="px-3 py-3 text-center">Quantity</th>
                        <th class="px-3 py-3 text-center">Created</th>
                        <th class="px-3 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if($partsale->isNotEmpty())
                    @foreach($partsale as $list)
                    <tr class="border-b">
                        <td class="px-3 py-3text-left">{{$list->id}}</td>
                        <td class="px-3 py-3 text-left">{{$list->c_name}}</td>
                        <td class="px-3 py-3 text-left">{{$list->c_mobile}}</td>
                        <td class="px-3 py-3 text-left">
                            <img src="{{url('/')}}/storage/uploads/{{$list->image}}" alt="" height="100px" width="100px"></td>
                        <td class="px-3 py-3 text-left">{{$list->mrp}}</td>
                        <td class="px-3 py-3 text-left">{{$list->price}}</td>
                        {{-- <td class="px-3 py-3 text-left">{{$list->discount}}</td> --}}
                        <td class="px-3 py-3 text-left">{{$list->final_amt}}</td>
                        <td class="px-3 py-3 text-left">{{$list->qty}}</td>
                        <td class="px-3 py-3 text-left">{{\Carbon\Carbon::parse($list->created_at)->format('d M, Y')}}</td>
                        <td class="px-3 py-3 text-center">
                            @can('edit sales')
                            <a href="{{route('partsale.edit',$list->id)}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Edit</a>
                            @endcan
                            @can('delete sales')
                            <a href="javascript:void(0)" onclick="deletePartSale({{$list->id}})" class="bg-red-500 text-sm rounded-md px-3 py-3 text-white">Delete</a>
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
            function deletePartSale(id){
                if(confirm('Are you want to delete')){
                    $.ajax({
                        url:'{{route("partsale.destroy")}}',
                        type:'delete',
                        data:{id:id},
                        dataType:'json',
                        headers:{
                            'x-csrf-token':'{{csrf_token()}}'
                        },
                        success: function(response){
                            window.location.href ='{{route("partsale.index")}}'
                        }
                    });
                }

            }
        </script>
    </x-slot>
</x-app-layout>
