<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Service / Edit') }}
        </h2>
        <a href="{{route('service.index')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Back</a>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('service.update',$service->id)}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Complaint ID</label>
                            <div  class="my-3">
                                <input placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="complain_id" value="{{old('complain_id',$service->complain_id)}}" readonly>
                                @error('complain_id')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Service Charge</label>
                            <div  class="my-3">
                                <input placeholder="Enter charge" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="serviceCharge" oninput="calculateFinalAmountD()" type="number" name="service_charge" value="{{old('service_charge',$service->service_charge)}}">
                                @error('service_charge')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Discount</label>
                            <div  class="my-3">
                                <input placeholder="Enter Discount" type="number" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="discount" oninput="calculateFinalAmountD()" name="discount" value="{{old('discount',$service->discount)}}">
                                @error('discount')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Final Billing</label>
                            <div  class="my-3">
                                <input placeholder="Enter Contact" type="number" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="finalAmt" readonly name="final_amt" value="{{old('final_amt',$service->final_amt)}}">
                                @error('final_amt')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                            </div>
                            <label for="" class="text-lg font-medium">Service by</label>
                            <div  class="my-3">
                                <textarea placeholder="Enter Complaint" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" id="" name="service_by" >{{old('service_by',$service->service_by)}}</textarea>
                                @error('service_by')
                                    <p class="text-red-400 font-medium">{{$message}}</p>
                                @enderror
                        </div>
                        <label for="payment">Payment Mode</label>
                        <div class="my-3">
                                            <select id="status" name="payment" class="w-1/2">
                                                <option value="">Select status</option>
                                                    <option value="online" @if($service->payment == 'online') selected @endif>Online</option>
                                                    <option value="cash" @if($service->payment == 'cash') selected @endif>Cash</option>
                                            </select>
                                            @error('payment')
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
