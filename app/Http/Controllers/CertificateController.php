<?php

namespace App\Http\Controllers;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportExcel;

class CertificateController extends Controller
{
    public function showProjects(){
        $project_names = DB::table('projects')->select(['id','project_name'])->orderBy('updated_at', 'desc')->where('user', '=', session()->get('u_id'))->get();
        $projects = compact('project_names');
        return view('users.projects')->with($projects);
        // echo "<pre>";
        // var_dump($array);
        // echo "</pre>";
    }
    public function createProject(Request $req){
        $req->validate(['projectName' => 'required|max:255',]);
        $project = new Projects;
        $project->project_name = $req->projectName;
        $project->user = $req->session()->get('u_id');
        $project->save();
        return redirect('/certificate'.'/'.$project->id);
    }
    public function uploadCertificate($id){
        $arr = compact('id');
        return view('users.getCertificate')->with($arr);
    }
    public function storeCertificate($id, Request $req){      
        $req->validate(['fileUrl' => 'file|mimes:jpg,png|between:20,2048']);    
        $file = $req->file('fileUrl');
        if($req->file()){  
            $file = $req->file('fileUrl');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move('uploads/certificates',$fileName);  
            DB::table('projects')->where('user', session()->get('u_id'))->where('id', $id)->update([
                'template' => $fileName,
            ]);    
            return redirect("/template"."/".$id);
        }
        else
            return view('error');
    }  
    public function savedCert($id){
        $img_name = DB::table('projects')->select('template')->where('user', '=', session()->get('u_id'))->where('id', '=', $id)->get();
        $arr = compact('img_name');
        if(is_null($img_name[0]->template)){
            return redirect('/certificate'.'/'.$id)->withErrors(['uploadError'=>'First upload the certificate template image here.']);
        }
        else{
            $attribs = DB::table('projects')->select(['templateSize','textAttribs'])->where('user', '=', session()->get('u_id'))->where('id', '=', $id)->get();
            $arr = compact('img_name','attribs','id');
            return view('users.setCerti')->with($arr);
        }
    }
    public function setAttributes($id, Request $request){
        $data = $request->except(['_token','imageSize']);
        DB::table('projects')->where('user', '=', session()->get('u_id'))->where('id', $id)->update(['textAttribs' => $data, 'templateSize' => $request->imageSize]);
        return redirect('/upload-data'.'/'.$id);
    }
    public function uploadDataTable($id){
        $arr = compact('id');
        return view('users.getDataTable')->with($arr);
    }
    public function storeDataTable($id, Request $req){
        $req->validate(['fileUrl' => 'file|mimes:csv,xlsx,xls|between:0.1,16384',]);  
        Excel::import(new ImportExcel($id), $req->file('fileUrl')->store('files')); 
        return redirect('/show-data'.'/'.$id);

    }   
    public function showDataTable($id){
        $querry = DB::table('projects')->join('data', 'projects.id', '=', 'data.id')
            ->select('data.datasrc', 'projects.textAttribs', 'data.dataFileAttribs')
            ->where('projects.user', '=', session()->get('u_id'))->where('projects.id', '=', $id)->get();
        $datasrc=$querry[0]->datasrc;
        if(is_null($querry[0]->textAttribs))
            return redirect('/template'.'/'.$id)->withErrors(['uploadError'=>'First set the attributes on the template.']);        
        else if(is_null($datasrc))
            return redirect('/upload-data'.'/'.$id)->withErrors(['uploadError'=>'First upload the data file.']);        
        else{
            $attribArray = array();
            foreach(json_decode($querry[0]->textAttribs) as $text){
                if(json_decode($text)->attribType=="dynamic"){
                    $attribArray[] = json_decode($text)->attribName;
                }
            }
            $dataFileAttribs=json_decode($querry[0]->dataFileAttribs, true);
            $data_to_send = compact(['datasrc','attribArray', 'id', 'dataFileAttribs']);
            return view('users.showDataTable')->with($data_to_send);
        }
    }
    public function getDataAttribs($id, Request $req){
        $data=$req->except('_token');
        foreach($data as $key => $value){
            if(count(array_keys($data, $data[$key])) != 1)
                return redirect('/show-data'.'/'.$id)->withErrors(['parameterError'=>'You selected '.$data[$key].' attribute for more than 1 column.']);
        }
        if (!in_array("email", array_values($data)))
            return redirect('/show-data'.'/'.$id)->withErrors(['parameterError'=>'Email attribute must be setted on a column.']);

        DB::table('data')->join('projects', 'projects.id', '=', 'data.id')
            ->where('projects.user', '=', session()->get('u_id'))->where('projects.id', '=', $id)
            ->update(['data.dataFileAttribs' => $data]);
        return redirect('/mail-certificate'.'/'.$id);
    }

}