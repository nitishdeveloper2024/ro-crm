
<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rental / Create') }}
        </h2>
        <a href="{{route('rental.index')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Back</a>
    </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('rental.store')}}" method="post">
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
                                <input placeholder="Enter Email" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" type="email" name="email" value="{{old('email')}}">
                                @error('email')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Contact</label>
                            <div  class="my-3">
                                <input placeholder="Enter Contact" type="number" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="contact" value="{{old('contact')}}">
                                @error('contact')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Alt. Contact</label>
                            <div  class="my-3">
                                <input placeholder="Enter Contact" type="number" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="alt_contact" value="{{old('alt_contact')}}">
                                @error('alt_contact')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Deposit</label>
                            <div  class="my-3">
                                <input placeholder="Enter Contact" type="number" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="deposit" value="{{old('deposit')}}">
                                @error('deposit')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Subscription</label>
                            <div  class="my-3">
                                <input placeholder="Enter Contact" type="number" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="subscription" value="{{old('subscription')}}">
                                @error('subscription')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Address</label>
                            <div  class="my-3">
                                <textarea placeholder="Enter Address" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="address" >{{old('address')}}</textarea>
                                @error('address')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                        </div>
                        <label for="payment">Model</label>
                        <div class="my-3">
                                            <select id="model" name="model" class="w-1/2">
                                                <option value="">Select Model</option>
                                                    <option value="drinktech_copper">Drinktech Copper</option>
                                                    <option value="drinktech_alkaline">Drinktech Alkaliine</option>
                                            </select>
                                            @error('model')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                    </div>
                        <label for="payment">Status</label>
                        <div class="my-3">
                                            <select id="status" name="status" class="w-1/2">
                                                <option value="">Select status</option>
                                                    <option value="active">Active</option>
                                                    <option value="expired">Expired</option>
                                            </select>
                                            @error('status')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                    </div>
                            <button type="submit" class="bg-slate-700 text-sm rounded-md px-5 py-3 text-white">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
