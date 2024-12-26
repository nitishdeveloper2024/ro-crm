
<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Recharge / Create') }}
        </h2>
        <a href="{{route('recharge.index')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Back</a>
    </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('recharge.store')}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Rental ID</label>
                            <div  class="my-3">
                                <input placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="rentalid" value="{{old('rentalid')}}">
                                @error('rentalid')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Days</label>
                            <div  class="my-3">
                                <input placeholder="Enter Email" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" type="text" name="days" value="{{old('days')}}">
                                @error('days')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Billed Amount</label>
                            <div  class="my-3">
                                <input placeholder="Enter Amount" type="number" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="amount" value="{{old('amount')}}">
                                @error('amount')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                                                    <label for="payment">Payment Mode</label>
                        <div class="my-3">
                                            <select id="payment" name="payment" class="w-1/2">
                                                <option value="">Select Mode</option>
                                                    <option value="online">Online</option>
                                                    <option value="cash">Cash</option>
                                            </select>
                                            @error('payment')
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
