<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
// use Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use PDF;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;


class SaleController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view sales', only:['index']),
            new Middleware('permission:edit sales', only:['edit']),
            new Middleware('permission:create sales', only:['create']),
            new Middleware('permission:delete sales', only:['destroy']),
        ];
    }
    public function index()
    {
        $product=Sale::orderBy('created_at','DESC')->paginate(10);
        return view('sales.index',[
            'product'=>$product
        ]);
    }

    public function create()
    {
        $products = Product::all();

        return view('sales.create',[
            'products'=>$products
        ]);
    }

    public function getProductPrice(Request $request)
    {
        
            $productId = $request->product_id;
            $product = Product::find($productId);
    
            if ($product) {
                return response()->json([
                    'success' => true,
                    'mrp' => $product->mrp,
                    'price' => $product->price
                ]);
            }
    
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }
    
    


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'c_name' => 'required|min:3',
            'c_mobile' => 'required|digits:10',
            'c_address' => 'required|min:10',
            'c_email' => 'required|min:5',
            'c_alt_mobile' => 'required|digits:10',
            'c_pin_code' => 'required|min:3',
            // 'image' => 'required|mimes:jpg,png,webp,jpeg',
            'mrp' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'discount' => 'required',
            'final_amt' => 'required|min:3',
            'installed_by' => 'required|min:3',
            'status' => 'required',
            'product_id' => 'required|min:1'

        ]);
        if($validator->passes()){
            
            if($request->hasfile('image'))
            {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $file->storeAs('uploads/sales/', $filename);
                $new->image = $filename;
            }
            
    

          // Get product and image
          $product = Product::findOrFail($request->product_id);

          if ($product->qty < $request->qty) {
            // If there is not enough stock
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

                // Step 4: Reduce the product quantity in stock
                $product->qty -= $request->qty;
                $product->save();
        
           
         
        $imagePath = public_path('storage/uploads/products/' . $product->image);
            
        // Generate new image path
          $newImagePath = public_path('storage/uploads/sales_images/' . time() . '.' . pathinfo($product->image, PATHINFO_EXTENSION));
        //   dd($newImagePath);
        //   Copy image to new path
          File::copy($imagePath, $newImagePath);
  
        //   Save sale with new image path
              $image = 'sales_images/' . basename($newImagePath); // Save the new image path
        //   $n->image=$image;
            
                 // Step 4: Save the PDF to storage and get the path
                 $pdfPath = storage_path('app/public/invoices/invoice_' .'.pdf');
         
                 $billedDate=Carbon::parse($request->input('billed_date'))->format('Y-m-d');
                    // Step 2: Store the sale data in the database
        $sale = Sale::create([
            'c_name' => $request->c_name,
            'c_mobile' => $request->c_mobile,
            'c_alt_mobile' => $request->c_alt_mobile,
            'c_address' => $request->c_address,
            'c_email' => $request->c_email,
            'c_pin_code' => $request->c_pin_code,
            'installed_by' => $request->installed_by,
            'mrp' => $request->mrp,
            'qty' => $request->qty,
            'price' => $request->price,
            'discount' => $request->discount,
            'final_amt' => $request->final_amt,
            'status' => $request->status,
            'product_id' => $request->product_id,
            'image' => $image,
            'pdf_path' => $pdfPath,
            'invoicenumber' => $request->invoicenumber,
            'billed_date' => $billedDate,
            'payment' => $request->payment,
        ]);

        // Step 3: Generate the PDF using the stored data
        $pdf = PDF::loadView('invoice', [
            'sale' => $sale,
        ]);
                         // Step 5: Update the sale record with the PDF path
                         $sale->pdf_path = 'invoices/invoice_' . $sale->id . '.pdf';
                         $pdf->save($pdfPath);

        $sale->save();

                // Step 6: Send email with the PDF attached
                $mailData = [
                    'title' => 'DrinkTech Invoice for Your Purchase',
                    'pdf_path' => $pdfPath,
                    'c_name' => $sale->c_name,
                    'c_email' => $sale->c_email,
                    'c_mobile' => $sale->c_mobile,
                    'c_alt_mobile' => $sale->c_alt_mobile,
                    'c_pin_code' => $sale->c_pin_Code,
                    'c_address' => $sale->c_address,
                    'product_name' => $product->name,
                    'mrp' => $sale->mrp,
                    'price' => $sale->price,
                    'qty' => $sale->qty,
                    'discount' => $sale->discount,
                    'final_amt' => $sale->final_amt,
                    'invoicenumber'=> $sale->invoicenumber,
                    'billed_date'=> $sale->billed_date,
                    'payment'=> $sale->payment,
                ];
        
                // Send the email
                Mail::to($sale->c_email)->send(new InvoiceMail($mailData));
        
        
            return redirect()->route('sale.index')->with('success','Sales Added Successfully');
        }else{
            return redirect()->route('sale.create')->withInput()->withErrors($validator);
        }
    }

            // Send email with the PDF attachment
    // private function sendInvoiceEmail(Sale $sale, $filePath)
    // {
    //     // Send the email with the PDF attachment
    //     Mail::to($sale->email)->send(new SaleInvoiceMail($sale, $filePath));
    // }

    


    public function edit($id)
    {
        $sale = Sale::findorfail($id);
        $products = Product::all();

        return view('sales.edit',[
            'sale' => $sale,
            'products'=> $products,
        ]);
    }

    // public function update(Request $request ,$id)
    // {
    //     $sale = Sale::findorfail($id);
    //     $validator = Validator::make($request->all(),[
    //         'c_name' => 'required|min:3',
    //         'c_mobile' => 'required|digits:10',
    //         'c_address' => 'required|min:10',
    //         'c_email' => 'required|min:5',
    //         'c_alt_mobile' => 'required|digits:10',
    //         'c_pin_code' => 'required|min:3',
    //         // 'image' => 'required|mimes:jpg,png,webp,jpeg',
    //         'mrp' => 'required',
    //         'price' => 'required',
    //         'qty' => 'required',
    //         'discount' => 'required',
    //         'final_amt' => 'required|min:3',
    //         'installed_by' => 'required|min:3',
    //         'status' => 'required',
    //         'product_id' => 'required|min:1'

    //     ]);
    //     if($validator->passes()){
           
    //         if($request->hasfile('image'))
    //         {
    //             $file = $request->file('image');
    //             $extenstion = $file->getClientOriginalExtension();
    //             $filename = time().'.'.$extenstion;
    //             $file->storeAs('uploads/products/', $filename);
    //             $new->image = $filename;
    //         }

    //         $product=Product::find($sale->product_id);
    //         $currentQty=$sale->qty;
    //         $newQty=$request->qty;
    //         if ($sale && $product) {
    //             // Step 2: Compare current quantity with new quantity
    //             if ($currentQty == $newQty) {
    //                 // No change in quantity
    //                 // return response()->json(['message' => 'No change in quantity']);
    //             } else {
    //                 // Step 3: Calculate the difference and ensure it's positive
    //                 $m = abs($currentQty - $newQty);  // Get the positive difference
            
    //                 // Step 4: Check if there’s enough stock to accommodate the change
    //                 if ($m <= $stock) {
    //                     // Update the stock (deduct the difference)
    //                     $product->qty -= $m;  // Deduct the difference from the product's stock
    //                     $product->save();  // Save the updated product stock
            
    //                     // Step 5: Update the sale record with the new quantity
    //                     $sale->qty = $newQty;  // Update the sale quantity
    //                     // $sale->save();  // Save the sale record
            
    //                     // return response()->json([
    //                     //     'message' => 'Quantity updated and stock deducted successfully',
    //                     //     'remaining_stock' => $product->stock
    //                     // ]);
    //                 } else {
    //                     // Not enough stock to make the change
    //                     // return response()->json(['message' => 'Not enough stock available'], 400);
    //                 }
    //             }
    //         } else {
    //             // return response()->json(['message' => 'Sale or Product not found'], 404);
    //         }
    //         // Step 4: Save the PDF to storage and get the path
    //         $pdfPath = storage_path('app/public/invoices/invoice_' .'.pdf');
         
    //         $sale = Sale::where('id',$sale)->update([
    //             'c_name' => $request->c_name,
    //             'c_mobile' => $request->c_mobile,
    //             'c_alt_mobile' => $request->c_alt_mobile,
    //             'c_address' => $request->c_address,
    //             'c_email' => $request->c_email,
    //             'c_pin_code' => $request->c_pin_code,
    //             'installed_by' => $request->installed_by,
    //             'mrp' => $request->mrp,
    //             'qty' => $newQty,
    //             'price' => $request->price,
    //             'discount' => $request->discount,
    //             'final_amt' => $request->final_amt,
    //             'status' => $request->status,
    //             'product_id' => $request->product_id,
    //             'image' => $request->image,
    //             'pdf_path' => $pdfPath,
    //             'invoicenumber' => $request->invoicenumber,
    //             'billed_date' => $request->billed_date,
    //             'payment' => $request->payment,
    //         ]);
    //         // Step 3: Generate the PDF using the stored data
    //     $pdf = PDF::loadView('invoice', [
    //         'sale' => $sale,
    //     ]);
    //                      // Step 5: Update the sale record with the PDF path
    //                      $sale->pdf_path = 'invoices/invoice_' . $sale->id . '.pdf';
    //                      $pdf->save($pdfPath);

    //                      dd($sale->c_name);

    //         $sale->save();
    //             // Step 6: Send email with the PDF attached
    //             $mailData = [
    //                 'title' => 'DrinkTech Invoice for Your Purchase',
    //                 'pdf_path' => $pdfPath,
    //                 'c_name' => $sale->c_name,
    //                 'c_email' => $sale->c_email,
    //                 'c_mobile' => $sale->c_mobile,
    //                 'c_alt_mobile' => $sale->c_alt_mobile,
    //                 'c_pin_code' => $sale->c_pin_Code,
    //                 'c_address' => $sale->c_address,
    //                 'product_name' => $product->name,
    //                 'mrp' => $sale->mrp,
    //                 'price' => $sale->price,
    //                 'qty' => $newQty,
    //                 'discount' => $sale->discount,
    //                 'final_amt' => $sale->final_amt,
    //                 'invoicenumber'=> $sale->invoicenumber,
    //                 'billed_date'=> $sale->billed_date,
    //                 'payment'=> $sale->payment,
    //             ];
        
    //             // Send the email
    //             Mail::to($sale->c_email)->send(new InvoiceMail($mailData));
            
    //         return redirect()->route('sale.index')->with('success','Product Added Successfully');
    //     }else{
    //         return redirect()->route('sale.create')->withInput()->withErrors($validator);
    //     }
    // }

    public function update(Request $request, $id)
{
    // Retrieve the sale record by ID
    $sale = Sale::findOrFail($id);

    // Validation rules
    $validator = Validator::make($request->all(), [
        'c_name' => 'required|min:3',
        'c_mobile' => 'required|digits:10',
        'c_address' => 'required|min:10',
        'c_email' => 'required|min:5',
        'c_alt_mobile' => 'required|digits:10',
        'c_pin_code' => 'required|min:3',
        'mrp' => 'required',
        'price' => 'required',
        'qty' => 'required',
        'discount' => 'required',
        'final_amt' => 'required|min:3',
        'installed_by' => 'required|min:3',
        'status' => 'required',
        'product_id' => 'required|min:1'
    ]);

    // If validation passes
    if ($validator->passes()) {

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->storeAs('uploads/products/', $filename);

            // Update the image in the sale model
            $sale->image = $filename;
        }

        // Retrieve the associated product from the sale
        $product = Product::find($sale->product_id);

        if ($product) {
            // Get the current and new quantities
            $currentQty = $sale->qty;
            $newQty = $request->qty;

            // Calculate the difference in quantities
            $m = abs($currentQty - $newQty);

            // Update the stock only if there is a difference
            if ($m > 0) {
                if ($m <= $product->qty) {  // Check if there's enough stock to accommodate the change
                    $product->qty -= $m;  // Deduct the difference from the product's stock
                    $product->save();  // Save the updated product stock
                } else {
                    return response()->json(['message' => 'Not enough stock available'], 400);
                }
            }
        }

                         // Step 4: Save the PDF to storage and get the path
                            //  $pdfPath = storage_path('app/public/invoices/invoice_' .'.pdf');
        // Save the PDF
        $pdfPath = storage_path('app/public/invoices/invoice_' .'.pdf');

        // Update the sale record with the new data and PDF path
        $sale->update([
            'c_name' => $request->c_name,
            'c_mobile' => $request->c_mobile,
            'c_alt_mobile' => $request->c_alt_mobile,
            'c_address' => $request->c_address,
            'c_email' => $request->c_email,
            'c_pin_code' => $request->c_pin_code,
            'installed_by' => $request->installed_by,
            'mrp' => $request->mrp,
            'qty' => $newQty,
            'price' => $request->price,
            'discount' => $request->discount,
            'final_amt' => $request->final_amt,
            'status' => $request->status,
            'product_id' => $request->product_id,
            // 'pdf_path' => $pdfPath,  // Save the PDF path
            'invoicenumber' => $request->invoicenumber,
            'billed_date' => $request->billed_date,
            'payment' => $request->payment,
        ]);

        // Step 3: Generate the PDF using the stored data
        $pdf = PDF::loadView('invoice', [
            'sale' => $sale,
        ]);
                         // Step 5: Update the sale record with the PDF path
                         $sale->pdf_path = 'invoices/invoice_' . $sale->id . '.pdf';
                         $pdf->save($pdfPath);

        // Send the email with the PDF attached
        $mailData = [
            'title' => 'DrinkTech Invoice for Your Purchase',
            'pdf_path' => $pdfPath,
            'c_name' => $sale->c_name,
            'c_email' => $sale->c_email,
            'c_mobile' => $sale->c_mobile,
            'c_alt_mobile' => $sale->c_alt_mobile,
            'c_pin_code' => $sale->c_pin_code,
            'c_address' => $sale->c_address,
            'product_name' => $product->name,
            'mrp' => $sale->mrp,
            'price' => $sale->price,
            'qty' => $newQty,
            'discount' => $sale->discount,
            'final_amt' => $sale->final_amt,
            'invoicenumber' => $sale->invoicenumber,
            'billed_date' => $sale->billed_date,
            'payment' => $sale->payment,
        ];

        // Send the email
        Mail::to($sale->c_email)->send(new InvoiceMail($mailData));

        // Redirect back to sale index with success message
        return redirect()->route('sale.index')->with('success', 'Product Updated Successfully');
    } else {
        // If validation fails, redirect back with errors
        return redirect()->route('sale.create')->withInput()->withErrors($validator);
    }
}


    public function destroy(Request $request)
    {
        $id=$request->id;
        $article=Sale::find($id);
        if($article ==null){
            session()->flash('error','Product not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $article->delete();
        session()->flash('success','Product deleted found');
        return response()->json([
            'status'=>true
        ]);
    }
}
