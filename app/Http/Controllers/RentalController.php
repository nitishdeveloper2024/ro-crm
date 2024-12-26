<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;
use App\Mail\RentalMail;
use PDF;

class RentalController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view rentals', only:['index']),
            new Middleware('permission:edit rentals', only:['edit']),
            new Middleware('permission:create rentals', only:['create']),
            new Middleware('permission:delete rentals', only:['destroy']),
        ];
    }
    public function index()
    {
        $rental=Rental::orderBy('created_at','DESC')->paginate(10);
        return view('rentals.index',[
            'rental'=>$rental
        ]);
    }

    public function create()
    {
        return view('rentals.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required',
            'contact' => 'required|digits:10',
            'alt_contact' => 'required|digits:10',
            'address' => 'required',
            'deposit' => 'required',
            'subscription' => 'required',
            'model' => 'required',
            'status' => 'required'
        ]);
        if($validator->passes()){
            $rental = new Rental();
                // Get current timestamp (in seconds)
                $timestamp = time();

                // Generate a random number between 1000 and 9999 (4-digit random number)
                $randomNum = rand(1000, 9999);

                // Combine timestamp and random number to create a unique Rental ID
                $rentalId = "RID-" . $timestamp . "-" . $randomNum;

            $rental->name=$request->name;
            $rental->email =$request->email;
            $rental->rental_id=$rentalId;
            $rental->contact= $request->contact;
            $rental->alt_contact= $request->alt_contact;
            $rental->address= $request->address;
            $rental->deposit= $request->deposit;
            $rental->subscription= $request->subscription;
            $rental->model= $request->model;
            $rental->status= $request->status;
            $rental->save();
    
                    // Generate PDF
            $pdf = PDF::loadView('rentals.pdf', ['rental' => $rental]);

            // Send Email with PDF attachment
            Mail::to($rental->email)->send(new RentalMail($rental, $pdf));

            return redirect()->route('rental.index')->with('success','Rental Added Successfully');
        }else{
            return redirect()->route('rental.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $rental = Rental::findorfail($id);
        return view('rentals.edit',[
            'rental' => $rental
        ]);
    }

    public function update(Request $request ,$id)
    {
        $rental = Rental::findorfail($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required',
            'contact' => 'required|digits:10',
            'alt_contact' => 'required|digits:10',
            'address' => 'required',
            'deposit' => 'required',
            'subscription' => 'required',
            'model' => 'required',
            'status' => 'required'
        ]);
        if($validator->passes()){
            $rental->name=$request->name;
            $rental->email =$request->email;
            $rental->contact= $request->contact;
            $rental->alt_contact= $request->alt_contact;
            $rental->address= $request->address;
            $rental->status= $request->status;
            $rental->rental_id=$request->rental_id;
            $rental->deposit= $request->deposit;
            $rental->subscription= $request->subscription;
            $rental->model= $request->model;
            $rental->save();
    
                    // Generate PDF
            $pdf = PDF::loadView('rentals.pdf', ['rental' => $rental]);

            // Send Email with PDF attachment
            Mail::to($rental->email)->send(new RentalMail($rental, $pdf));

            return redirect()->route('rental.index')->with('success','Rental Updated Successfully');
        }else{
            return redirect()->route('rental.edit')->withInput()->withErrors($validator);
        }
    }

    public function destroy(Request $request)
    {
        $id=$request->id;
        $rental=Rental::find($id);
        if($rental ==null){
            session()->flash('error','Rental not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $rental->delete();
        session()->flash('success','Rental deleted found');
        return response()->json([
            'status'=>true
        ]);
    }


}
