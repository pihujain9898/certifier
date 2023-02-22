<?php

namespace App\Http\Controllers;
use App\Models\Projects;
use App\Models\Mails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\MailJob;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
    public function getMailCred($id){
        $project_user = DB::table('projects')->select('user')->where('id', '=', $id)->get();
        $project_user = $project_user[0]->user;
        if ($project_user == session()->get('u_id')) {
            $mail = DB::table('mails')->where('id', '=', $id)->get();
            $arr = compact(['id','mail']);
            return view('users.mail')->with($arr);           
        } 
        else
            echo "You are not logged in with the project associated account.";
    }

    public function setMailCred($id, Request $req){
        $req->validate(
            [
                'name' => 'required|min:2|max:255',
                'email' => 'required|email|min:6|max:255',
                'password' => 'required|min:8|max:255',
                'subject' => 'required|max:255',
                'body' => 'required|max:16777215',
            ]
        );
        $project_user = DB::table('projects')->select('user')->where('id', '=', $id)->get();
        $project_user = $project_user[0]->user;
        if ($project_user == session()->get('u_id')) {
            $data = DB::table('mails')->updateOrInsert(
                ['id'=>$id],
                ['email'=>$req['email'], 'name'=>$req['name'],'password'=>$req['password'], 'subject'=>$req['subject'],'body'=>$req['body'] ],                
            );
            return redirect('/mail-certificate'.'/'.$id);
        } else
            echo "You are not logged in with the project associated account.";
    }

    public function sendMail($id){
        $data = DB::table('projects')
        ->join('data', 'projects.id', '=', 'data.id')->join('mails', 'projects.id', '=', 'mails.id')
        ->select(['projects.template', 'projects.templateSize', 'projects.textAttribs',
         'data.datasrc', 'data.dataFileAttribs',
         'mails.email','mails.password','mails.name','mails.subject','mails.body'])
        ->where('projects.user', '=', session()->get('u_id'))->where('projects.id', '=', $id)->get();
        $data = $data[0];

        if(!isset($data->dataFileAttribs) || !in_array("email", array_values(json_decode($data->dataFileAttribs, true))))
            return redirect('/show-data'.'/'.$id)->withErrors(['parameterError'=>'Email attribute must be setted on a column.']);

        $imgName = $data->template;
        $imgSize = json_decode($data->templateSize);
        $size = getimagesize('uploads/certificates/'.$imgName);
        $orignal_width=$size[0];
        $orignal_height=$size[1];
        $display_width=$imgSize->imgWidth;
        $display_height=$imgSize->imgHeight;
        $width_ratio = $orignal_width / $display_width;
        $height_ratio = $orignal_height / $display_height;
        $font_ratio = (($display_width/$orignal_width)+($display_height/$orignal_height))/2;
    
        $ext = pathinfo($imgName, PATHINFO_EXTENSION);
        if($ext == "png"){
            header('Content-type: image/png');
        }
        else{
            header('Content-type: image/jpeg');
        }
        $querries=json_decode($data->textAttribs);

        $mail_col=$data->dataFileAttribs;
        $mail_col=(int)array_search ('email', (array)json_decode($mail_col));

        for($i=0; $i<sizeof(json_decode($data->datasrc)); $i++){
            $mail_arr[] = (array)json_decode($data->datasrc)[$i][$mail_col]; 
        }

        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';             
        $mail->SMTPAuth = true;
        $mail->Username = $data->email;  
        $mail->Password = $data->password;       
        $mail->SMTPSecure = 'tls';               
        $mail->Port = 587;                          
        $mail->setFrom($data->email, $data->name);
        // $mail->isHTML(true);             
        $mail->Subject = $data->subject;
        $mail->Body    = $data->body;
        
        $count=0;
        foreach ($mail_arr as $value) {
            MailJob::dispatch($mail, $value, $ext, $imgName, $querries, $width_ratio, $height_ratio, $data, $count, $font_ratio);
            $count++;
        }

        return view("users.status");
    }
}
