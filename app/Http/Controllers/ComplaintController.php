<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComplaintMail;
use PDF;

class ComplaintController extends Controller implements HasMiddleware
{
    //

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view complaints', only:['index']),
            new Middleware('permission:edit complaints', only:['edit']),
            new Middleware('permission:create complaints', only:['create']),
            new Middleware('permission:delete complaints', only:['destroy']),
        ];
    }
    public function index()
    {
        $complaint=Complaint::orderBy('created_at','DESC')->paginate(10);
        return view('complaints.index',[
            'complaint'=>$complaint
        ]);
    }

    public function create()
    {
        return view('complaints.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required',
            'contact' => 'required|digits:10',
            'alt_contact' => 'required|digits:10',
            'description' => 'required',
            'status' => 'required'
        ]);
        if($validator->passes()){
            $complaint = new Complaint();
                // Get current timestamp (in seconds)
                $timestamp = time();

                // Generate a random number between 1000 and 9999 (4-digit random number)
                $randomNum = rand(1000, 9999);

                // Combine timestamp and random number to create a unique Complaint ID
                $complaintId = "CID-" . $timestamp . "-" . $randomNum;

            $complaint->name=$request->name;
            $complaint->email =$request->email;
            $complaint->complaint_id=$complaintId;
            $complaint->contact= $request->contact;
            $complaint->alt_contact= $request->alt_contact;
            $complaint->description= $request->description;
            $complaint->status= $request->status;
            $complaint->save();
    
                    // Generate PDF
            $pdf = PDF::loadView('complaints.pdf', ['complaint' => $complaint]);

            // Send Email with PDF attachment
            Mail::to($complaint->email)->send(new ComplaintMail($complaint, $pdf));

            return redirect()->route('complaint.index')->with('success','Complaint Added Successfully');
        }else{
            return redirect()->route('complaint.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id)
    {
        $complaint = Complaint::findorfail($id);
        return view('complaints.edit',[
            'complaint' => $complaint
        ]);
    }

    public function update(Request $request ,$id)
    {
        $complaint = Complaint::findorfail($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required',
            'contact' => 'required|digits:10',
            'alt_contact' => 'required|digits:10',
            'description' => 'required',
            'status' => 'required'
        ]);
        if($validator->passes()){
            $complaint->name=$request->name;
            $complaint->email =$request->email;
            $complaint->contact= $request->contact;
            $complaint->alt_contact= $request->alt_contact;
            $complaint->description= $request->description;
            $complaint->status= $request->status;
            $complaint->complaint_id=$request->complaint_id;
            $complaint->save();
    
                    // Generate PDF
            $pdf = PDF::loadView('complaints.pdf', ['complaint' => $complaint]);

            // Send Email with PDF attachment
            Mail::to($complaint->email)->send(new ComplaintMail($complaint, $pdf));

            return redirect()->route('complaint.index')->with('success','Complaint Updated Successfully');
        }else{
            return redirect()->route('complaint.edit')->withInput()->withErrors($validator);
        }
    }

    public function destroy(Request $request)
    {
        $id=$request->id;
        $article=Complaint::find($id);
        if($article ==null){
            session()->flash('error','Complaint not found');
            return response()->json([
                'status'=>false
            ]);
        }
        $article->delete();
        session()->flash('success','Complaint deleted found');
        return response()->json([
            'status'=>true
        ]);
    }


}
