<?php

namespace App\Http\Controllers;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $project = new Projects;
        $project->project_name = $req->projectName;
        $project->user = $req->session()->get('u_id');
        $project->save();
        return redirect('/upload-certificate'.'/'.$project->id);
    }
    public function uploadCertificate($id){
        $arr = compact('id');
        return view('users.getCertificate')->with($arr);
    }
    public function storeCertificate($id, Request $req){          
        $file = $req->file('fileUrl');
        if($req->file()){  
            $file = $req->file('fileUrl');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move('uploads/certificates',$fileName);  
            DB::table('projects')->where('user', session()->get('u_id'))->where('id', $id)->update([
                'template' => $fileName,
            ]);    
            return redirect("/savedCertificate"."/".$id);
        }
        else
            return view('error');
    }  
    public function savedCert($id){
        $img_name = DB::table('projects')->select('template')->where('user', '=', session()->get('u_id'))->where('id', '=', $id)->get();
        $arr = compact('img_name');
        if(is_null($img_name[0]->template)){
            // echo "<script>alert('First upload the certificate image!');</script>";
            return redirect('/upload-certificate'.'/'.$id);
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
        return redirect('/upload-data-table'.'/'.$id);
    }
    public function uploadDataTable($id){
        $arr = compact('id');
        return view('users.getDataTable')->with($arr);
    }
    public function storeDataTable($id, Request $request){
        $file = $request->file('fileUrl');
        if($request->file()){  
            $file = $request->file('fileUrl');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move('uploads/excels',$fileName);  
            DB::table('projects')->where('user', '=', session()->get('u_id'))->where('id', $id)->update(['datasrc' => $fileName]);
            return redirect('/show-data-table'.'/'.$id);
        }
        else
            return view('error');
    }   
    public function showDataTable($id){
        $fileName=DB::table('projects')->select('datasrc')->where('user', '=', session()->get('u_id'))->where('id', '=', $id)->get();
        $fileName=$fileName[0]->datasrc;
        if(is_null($fileName)){
            // echo "<script>alert('First upload the data file!');</script>";
            return redirect('/upload-data-table'.'/'.$id);
        }
        else{
            $attribs=DB::table('projects')->select('textAttribs')->where('id', '=', $id)->get();
            $attribArray = array();
            foreach(json_decode($attribs[0]->textAttribs) as $text){
                if(json_decode($text)->attribType=="dynamic"){
                    $attribArray[] = json_decode($text)->attribName;
                }
            }
            $dataFileAttribs=DB::table('projects')->select('dataFileAttribs')->where('id', '=', $id)->get();
            if (($open = fopen('uploads/excels/'.$fileName, "r")) !== FALSE) 
            {
              while (($data = fgetcsv($open, 0, ",")) !== FALSE) 
              {        
                $array[] = $data; 
              }
              fclose($open);
            }
            $data_to_send = compact(['array','attribArray', 'id', 'dataFileAttribs']);
            return view('users.showDataTable')->with($data_to_send);
        }
    }
    public function getDataAttribs($id, Request $req){
        $data=$req->except('_token');
        DB::table('projects')->where('user', '=', session()->get('u_id'))->where('id', $id)->update(['dataFileAttribs' => $data]);

        echo "<pre>";
        print_r($req->except('_token'));
        echo "</pre>";
    }
}