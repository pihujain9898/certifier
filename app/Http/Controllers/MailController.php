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
                'name' => 'required|min:2',
                'email' => 'required|email|min:6',
                'password' => 'required|size:16',
                'subject' => 'required',
                'body' => 'required'
            ]
        );
        $project_user = DB::table('projects')->select('user')->where('id', '=', $id)->get();
        $project_user = $project_user[0]->user;
        if ($project_user == session()->get('u_id')) {
            $mailData = DB::table('mails')->updateOrInsert(
                ['id'=>$id],
                ['email'=>$req['email'], 'name'=>$req['name'],'password'=>$req['password'], 'subject'=>$req['subject'],'body'=>$req['body'] ],                
            );
            return redirect('/mail-certificate'.'/'.$id);
        } else
            echo "You are not logged in with the project associated account.";
    }

    public function sendMail($id){
        $data=DB::table('projects')->select(['template','templateSize','textAttribs','datasrc','dataFileAttribs'])->where('id', '=', $id)->get();
        if(!isset($data[0]->dataFileAttribs) || !in_array("email", array_values(json_decode($data[0]->dataFileAttribs, true))))
            return redirect('/show-data'.'/'.$id)->withErrors(['parameterError'=>'Email attribute must be setted on a column.']);

        $imgName = $data[0]->template;
        $imgSize = json_decode($data[0]->templateSize);
        $size = getimagesize('uploads/certificates/'.$imgName);
        $orignal_width=$size[0];
        $orignal_height=$size[1];
        $display_width=$imgSize->imgWidth;
        $display_height=$imgSize->imgHeight;
        $width_ratio = $orignal_width / $display_width;
        $height_ratio = $orignal_height / $display_height;
    
        $ext = pathinfo($imgName, PATHINFO_EXTENSION);
        if($ext == "png"){
            header('Content-type: image/png');
        }
        else{
            header('Content-type: image/jpeg');
        }
        $querries=json_decode($data[0]->textAttribs);

        $filename = $data[0]->datasrc;
        $mail_col=$data[0]->dataFileAttribs;
        $mail_col=(int)array_search ('email', (array)json_decode($mail_col));
        if (($open = fopen('uploads/excels/'.$filename, "r")) !== FALSE) 
        {
          while (($dataFile = fgetcsv($open, 0, ",")) !== FALSE) 
          {        
            $mail_arr[] = $dataFile[$mail_col]; 
          }
          fclose($open);
        }

        $mailData=DB::table('mails')->select(['email','password','name','subject','body'])->where('id', '=', $id)->get();        
        $mailData = $mailData[0];
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';             
        $mail->SMTPAuth = true;
        $mail->Username = $mailData->email;  
        $mail->Password = $mailData->password;       
        $mail->SMTPSecure = 'tls';               
        $mail->Port = 587;                          
        $mail->setFrom($mailData->email, $mailData->name);
        // $mail->isHTML(true);             
        $mail->Subject = $mailData->subject;
        $mail->Body    = $mailData->body;
        
        $count=0;
        foreach ($mail_arr as $value) {
            MailJob::dispatch($mail, $value, $ext, $imgName, $querries, $width_ratio, $height_ratio, $data, $filename, $count);
            $count++;
        }

        return view("users.status");
    }
}
