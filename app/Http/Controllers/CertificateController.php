<?php

namespace App\Http\Controllers;
use App\Models\Projects;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function uploadCertificate(){
        return view('users.getCertificate');
    }
    public function storeCertificate(Request $request){  
        $project=new Projects; 
        $file = $request->file('fileUrl');
        if($request->file()){  
            $file = $request->file('fileUrl');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move('uploads/certificates',$fileName);  
            
            $project->template = $fileName;
            $project->user = "1";
            $project->save();  
            session(['template' => $fileName, 'user' => "1"]);
            return redirect("/set-texts");
        } else 
            return "Something went wrong";
    }  

    public function uploadDataTable(){
        return view('users.getDataTable');
    }
    public function storeDataTable(Request $request){
        echo "<pre>";
        print_r($request->except('_token'));
    }

    public function showCertificate(){
        if (Session()->has('fileName'))
            return view('users.cPreview');
    }
    public function setAttributes(Request $request){
        echo "<pre>";
        print_r($request->except('_token'));
    }
}
