<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product / Edit') }}
        </h2>
        <a href="{{route('product.index')}}" class="bg-slate-700 text-sm rounded-md px-3 py-3 text-white">Back</a>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('sale.update',$sale->id)}}" method="post">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input class="form-control" id="c_name" type="text" name="c_name" value="{{old('c_name',$sale->c_name)}}">
                                        @error('c_name')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                      </div>
                                      <div class="form-group">
                                        <label for="name">Invoice Number</label>
                                        <input class="form-control" name="invoicenumber" readonly value="{{old('invoicenumber',$sale->invoicenumber)}}">
                                        @error('invoicenumber')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                      </div>


                                      <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control" id="c_email" value="{{old('c_email',$sale->c_email)}}" type="email" name="c_email">
                                        @error('c_email')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="email">Contact</label>
                                        <input class="form-control" id="c_mobile" type="number" name="c_mobile" value="{{old('c_mobile',$sale->c_mobile)}}">
                                        @error('c_mobile')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      <div class="form-group">
                                        <label for="email">Alt.Contact</label>
                                        <input class="form-control" id="c_alt_mobile" type="number" name="c_alt_mobile" value="{{old('c_alt_mobile',$sale->c_alt_mobile)}}">
                                        @error('c_alt_mobile')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="email">Address</label>
                                        <input class="form-control" id="c_address" type="text" name="c_address" value="{{old('c_address',$sale->c_address)}}">
                                        @error('c_address')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="email">Pincode</label>
                                        <input class="form-control" id="c_pin_code" type="number" name="c_pin_code" value="{{old('c_pin_Code',$sale->c_pin_code)}}">
                                        @error('c_pin_code')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="email">Installed By Technician</label>
                                        <input class="form-control" id="email" type="text" name="installed_by" value="{{old('installed_by',$sale->installed_by)}}">
                                        @error('installed_by')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror  
                                    </div>
                                      
                                      <div class="form-group">
                                        <label for="email">Status</label>
                                        <input class="form-control" id="email" type="text" name="status" value="{{old('status',$sale->status)}}">
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
                                            <select id="product" name="product_id" class="form-control">
                                                <option value="">Select a Product</option>
                                                @foreach($products as $product)
                                                    {{-- <option value="{{ $product->id }}">{{ $product->name }}</option> --}}
                                                    <option value="{{ $product->id }}" 
                                                        @if($product->id == $sale->product_id) selected @endif>
                                                        {{ $product->name }}
                                    
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Mrp</label>
                                            <input class="form-control" type="number" name="mrp" value="{{old('mrp',$sale->mrp)}}">
                                            @error('mrp')
                                            <p class="text-red-400 font-medium">{{$message}}</p>
                                            @enderror
                                        </div>
                                          <div class="form-group">
                                            <label for="email">Sale Price</label>
                                            <input class="form-control" type="number" name="price" value="{{old('price',$sale->price)}}">
                                            @error('price')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                          </div>  
                                          <div class="form-group">
                                            <label for="email">Quantity</label>
                                            <input class="form-control" type="number" name="qty" value="{{old('qty',$sale->qty)}}">
                                            @error('qty')
                                            <p class="text-red-400 font-medium">{{$message}}</p>
                                            @enderror
                                        </div>
                                          <div class="form-group">
                                            <label for="email">Discount</label>
                                            <input class="form-control" type="number" name="discount" value="{{old('discount',$sale->discount)}}">
                                            @error('discount')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                          </div>
                                          <div class="form-group">
                                            <label for="email">Final Billed Amount</label>
                                            <input class="form-control"  type="number" name="final_amt" readonly value="{{old('final_amt',$sale->final_amt)}}">
                                            @error('final_amt')
                                            <p class="text-red-400 font-medium">{{$message}}</p>
                                            @enderror  
                                        </div>
                                        <div class="form-group">
                                            <label for="payment">Payment Method</label>
                                            <select id="payment" name="payment" class="form-control">
                                                <option value="">Select a Product</option>
                                                    {{-- <option value="online">Online</option>
                                                    <option value="cash">Cash</option> --}}
                                                    <option value="online" @if($sale->payment == 'online') selected @endif>Online</option>

                                                    <!-- Option for 'cash' -->
                                                    <option value="cash" @if($sale->payment== 'cash') selected @endif>Cash</option>
                                        
                                    
                                            </select>
                                            @error('payment')
                                        <p class="text-red-400 font-medium">{{$message}}</p>
                                        @enderror
                                        <input type="hidden" name="image" value="{{old('image',$sale->image)}}">
                                        <input type="hidden" name="billed_date" value="{{old('billed_date',$sale->billed_date)}}">

                                        </div>
                                    </div>
                                </div>
                            
                                </div>
                            
                            
                    
                            
                            <button type="submit" class="bg-slate-700 text-center text-sm my-3 rounded-md mx-2 px-3 py-2 text-white">Update</button>
                        </div>                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
