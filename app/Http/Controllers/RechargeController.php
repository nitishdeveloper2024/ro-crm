<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Recharge;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\RechargeMail;
use PDF;

class RechargeController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view recharges', only:['index']),
            new Middleware('permission:edit recharges', only:['edit']),
            new Middleware('permission:create recharges', only:['create']),
            new Middleware('permission:delete recharges', only:['destroy']),
        ];
    }
    public function index(Request $request)
    {
        // $rental=Rental::all();
        $recharge=DB::table('recharges')
            ->leftjoin('rentals','rentals.rental_id','=','recharges.rentalid')    
            ->get();
            // echo'<pre>';
            // print_r($recharge);
            // die();
        return view('recharges.index',[
            'recharge'=>$recharge,
            // 'rental'=>$rental
        ]);
    }

    public function create()
    {
        return view('recharges.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'days' => 'required|min:2',
            'amount' => 'required',
            'payment' => 'required'
            
        ]);
        if($validator->passes()){
            $rental = new Recharge();

            $recharge = Rental::where('rental_id', $request->rentalid)->first();

            if ($rental) {
                // If complaint exists, generate the PDF and send the email
                $rental->rentalid=$request->rentalid;
                $rental->days =$request->days;
                $rental->amount=$request->amount;
                $rental->payment= $request->payment;
                $rental->save();
    
                $pdf = PDF::loadView('recharges.pdf', compact('rental','recharge')); // Generate PDF
    
                // Send email with PDF attachment
                Mail::to($recharge->email)->send(new RechargeMail($rental, $pdf, $recharge));
    
                    
            return redirect()->route('recharge.index')->with('success','Recharge Added Successfully');
        }}else{
            return redirect()->route('recharge.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $rental = Recharge::findorfail($id);
        return view('recharges.edit',[
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
        $rental=Recharge::find($id);
        if($rental ==null){
            session()->flash('error','Recharge not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $rental->delete();
        session()->flash('success','Recharge deleted successfully');
        return response()->json([
            'status'=>true
        ]);
    }
}
