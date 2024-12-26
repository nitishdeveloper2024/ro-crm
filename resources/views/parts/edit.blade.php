<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Parts / Edit') }}
        </h2>
        <a href="{{route('part.index')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Back</a>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('part.update',$part->id)}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div  class="my-3">
                                <input placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="name" value="{{old('name',$part->name)}}">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Image</label>
                            <div  class="my-3">
                                <input type="file" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="image" name="image" value="{{old('image',$part->image)}}">
                                @error('image')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">MRP</label>
                            <div  class="my-3">
                                <input placeholder="Enter Mrp Price" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="mrp" value="{{old('mrp',$part->mrp)}}">
                                @error('mrp')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Sale Price</label>
                            <div  class="my-3">
                                <input placeholder="Enter Sale Price" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="price" value="{{old('price',$part->price)}}">
                                @error('price')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Quantity</label>
                            <div  class="my-3">
                                <input placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="qty" value="{{old('qty',$part->qty)}}">
                                @error('qty')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" class="bg-slate-700 text-sm rounded-md px-5 py-3 text-white">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
