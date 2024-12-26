<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceMail;
use PDF;
use App\Models\Complaint;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view services', only:['index']),
            new Middleware('permission:edit services', only:['edit']),
            new Middleware('permission:create services', only:['create']),
            new Middleware('permission:delete services', only:['destroy']),
        ];
    }
    public function index()
    {
        // $service = DB::table('services')->get();

        // Alternatively, if you're using Eloquent models, you could do:
        $complaint = DB::table('services')
                    ->leftjoin('complaints','complaints.complaint_id','=','services.complain_id')
                    ->select('services.complain_id', 'complaints.name', 'services.service_charge', 'services.service_by','services.payment','complaints.email','complaints.contact','services.final_amt','services.created_at','services.updated_at','services.id')
                    ->get();
        
        // echo'<pre>';
        // print_r($complaint);
        // die();
        return view('services.index',[
            // 'complaint'=>$complaint,
            'complaint'=>$complaint
        ]);
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'complain_id' => 'required|min:3',
            'service_charge' => 'required',
            'discount' => 'required',
            'final_amt' => 'required',
            'service_by' => 'required',
            'payment' => 'required'
        ]);
        if($validator->passes()){
            $service = new Service();
                
            
        // Check if the complaint exists in the database
        $complaint = Complaint::where('complaint_id', $request->complain_id)->first();

        if ($complaint) {
            // If complaint exists, generate the PDF and send the email
            $service->complain_id=$request->complain_id;
            $service->service_charge =$request->service_charge;
            $service->discount=$request->discount;
            $service->final_amt= $request->final_amt;
            $service->service_by= $request->service_by;
            $service->payment= $request->payment;
            $service->save();

            $pdf = PDF::loadView('services.pdf', compact('complaint','service')); // Generate PDF

            // Send email with PDF attachment
            Mail::to($complaint->email)->send(new ServiceMail($complaint, $pdf, $service));

            return redirect()->route('service.index')->with('success','Service Added Successfully');
        }}else{
            return redirect()->route('service.create')->withInput()->withErrors($validator);
        }
    }
    
    public function edit($id)
    {
        $service = Service::findorfail($id);
        return view('services.edit',[
            'service' => $service
        ]);
    }

    public function update(Request $request ,$id)
    {
        $service = Service::findorfail($id);
        $validator = Validator::make($request->all(),[
            'complain_id' => 'required|min:3',
            'service_charge' => 'required',
            'discount' => 'required',
            'final_amt' => 'required',
            'service_by' => 'required',
            'payment' => 'required'
        ]);
        if($validator->passes()){
            $complaint = Complaint::where('complaint_id', $request->complain_id)->first();

            if ($complaint) {
                // If complaint exists, generate the PDF and send the email
                $service->complain_id=$request->complain_id;
                $service->service_charge =$request->service_charge;
                $service->discount=$request->discount;
                $service->final_amt= $request->final_amt;
                $service->service_by= $request->service_by;
                $service->payment= $request->payment;
                $service->save();
    
                $pdf = PDF::loadView('services.pdf', compact('complaint','service')); // Generate PDF
    
                // Send email with PDF attachment
                Mail::to($complaint->email)->send(new ServiceMail($complaint, $pdf, $service));
    
            return redirect()->route('complaint.index')->with('success','Service Updated Successfully');
       } }else{
            return redirect()->route('complaint.edit')->withInput()->withErrors($validator);
        }
    }

    public function destroy(Request $request)
    {
        $id=$request->id;
        $article=Service::find($id);
        if($article ==null){
            session()->flash('error','Service not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $article->delete();
        session()->flash('success','Service deleted found');
        return response()->json([
            'status'=>true
        ]);
    }
}
