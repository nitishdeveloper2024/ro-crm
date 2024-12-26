<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sales / Create') }}
        </h2>
        <a href="{{route('partsale.index')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Back</a>
    </div>
    </x-slot>
<style>
    input{
        border: 1px solid #d1cece !important;
    }
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('partsale.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input class="form-control" id="c_name" type="text" name="c_name" value="{{old('c_name')}}">
                                        @error('c_name')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                      </div>
                                      <div class="form-group">
                                        <label for="name">Invoice Number</label>
                                        <input class="form-control" id="invoiceNumber" name="invoicenumber" readonly value="{{old('invoicenumber')}}">
                                        @error('invoicenumber')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                      </div>


                                      <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control" id="c_email" type="email" name="c_email">
                                        @error('c_email')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="email">Contact</label>
                                        <input class="form-control" id="c_mobile" type="number" name="c_mobile">
                                        @error('c_mobile')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      <div class="form-group">
                                        <label for="email">Alt.Contact</label>
                                        <input class="form-control" id="c_alt_mobile" type="number" name="c_alt_mobile">
                                        @error('c_alt_mobile')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="email">Address</label>
                                        <input class="form-control" id="c_address" type="text" name="c_address">
                                        @error('c_address')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="email">Pincode</label>
                                        <input class="form-control" id="c_pin_code" type="number" name="c_pin_code">
                                        @error('c_pin_code')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="email">Installed By Technician</label>
                                        <input class="form-control" id="email" type="text" name="installed_by">
                                        @error('installed_by')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="email">Status</label>
                                        <input class="form-control" id="email" type="text" name="status">
                                        @error('status')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                      </div>
                                    {{-- <label for="" class="text-lg font-medium">Name</label>
                                <input placeholder="Enter Name" type="text" class="border-gray-300 w-1/3 shadow-sm" id="" > --}}
                                </div>
                            {{-- </div> --}}
                                {{-- <div class="row"> --}}
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="product">Product</label>
                                            <select id="part" name="product_id" class="form-control">
                                                <option value="">Select a Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Mrp</label>
                                            <input class="form-control" id="mrp" type="number" name="mrp">
                                            @error('mrp')
                                            <p class="text-red-400 font-medium">{{$message}}</p>
                                            @enderror
                                        </div>
                                          <div class="form-group">
                                            <label for="email">Sale Price</label>
                                            <input class="form-control" id="price" type="number" name="price">
                                            @error('price')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                          </div>  
                                          <div class="form-group">
                                            <label for="email">Quantity</label>
                                            <input class="form-control" id="qty" type="number" name="qty">
                                            @error('qty')
                                            <p class="text-red-400 font-medium">{{$message}}</p>
                                            @enderror
                                        </div>
                                          <div class="form-group">
                                            <label for="email">Discount</label>
                                            <input class="form-control" id="discount" type="number" name="discount">
                                            @error('discount')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                          </div>
                                          <div class="form-group">
                                            <label for="email">Final Billed Amount</label>
                                            <input class="form-control" id="final_amt" type="number" name="final_amt" readonly>
                                            @error('final_amt')
                                            <p class="text-red-400 font-medium">{{$message}}</p>
                                            @enderror  
                                        </div>
                                        <div class="form-group">
                                            <label for="payment">Payment Method</label>
                                            <select id="payment" name="payment" class="form-control">
                                                <option value="">Select a Product</option>
                                                    <option value="online">Online</option>
                                                    <option value="cash">Cash</option>
                                            </select>
                                            @error('payment')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                        </div>
                                    </div>
                                </div>
                            
                                </div>
                            
                            
                    
                            
                            <button type="submit" class="bg-slate-700 text-center text-sm my-3 rounded-md mx-2 px-3 py-2 text-white">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
