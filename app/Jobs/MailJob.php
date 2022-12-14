<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;

class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $mail, $value, $ext, $imgName, $querries, $width_ratio, $height_ratio, $data, $filename, $count;

    public function __construct($mail, $value, $ext, $imgName, $querries, $width_ratio, $height_ratio, $data, $filename, $count)
    {
        $this->mail = $mail;
        $this->value = $value;
        $this->ext = $ext;
        $this->imgName = $imgName;
        $this->querries = $querries;
        $this->width_ratio = $width_ratio;
        $this->height_ratio = $height_ratio;
        $this->data = $data;
        $this->filename = $filename;
        $this->count = $count;
    }

    public function handle(){
        $mail = $this->mail;
        $value = $this->value;
        $ext = $this->ext;
        $imgName = $this->imgName;
        $querries = $this->querries;
        $width_ratio = $this->width_ratio;
        $height_ratio = $this->height_ratio;
        $data = $this->data;
        $filename = $this->filename;
        $count = $this->count;

        $mail->clearAllRecipients();
        $mail->addAddress($value);

        if($ext == "png"){
            $created_img = imagecreatefrompng(url('uploads/certificates/'.$imgName));
        }
        else{
            $created_img = imagecreatefromjpeg(url('uploads/certificates/'.$imgName));
        }
        $color = imagecolorallocate($created_img, 0, 0, 0);
        
        foreach ($querries as $querryName => $querry) {
            $x_pos_given=(float)json_decode($querry)->xPosition;
            $y_pos_given=(float)json_decode($querry)->yPosition;
            $font_size = ((float)json_decode($querry)->fontSize/1.6)*(($width_ratio+$height_ratio)/2);
            $angle=0;
            $font_path = 'public\\SegoeUI.ttf';
            if (json_decode($querry)->attribType == 'static')
                $text = json_decode($querry)->attribSample;
            else{
                $colAttribs = json_decode($data[0]->dataFileAttribs,true);
                $column_no = array_search(json_decode($querry)->attribName,$colAttribs,true);                
                $array=array();
                if (($open = fopen(url('uploads/excels/'.$filename), "r")) !== FALSE) 
                {
                  while (($dataOfCsv = fgetcsv($open, 0, ",")) !== FALSE) 
                  {        
                    $array[] = $dataOfCsv[$column_no]; 
                  }
                  fclose($open);
                }                
                $text=$array[$count];
            }
            list($left, $bottom, $right, , , $top) = imageftbbox($font_size, $angle, $font_path, $text);
            $left_offset = ($right - $left) / 2;
            $top_offset = ($bottom - $top) / 2;
            $x_pos_taken = $x_pos_given * $width_ratio - $left_offset;
            $y_pos_taken = $y_pos_given * $height_ratio + $top_offset;
            imagettftext($created_img, $font_size, $angle, $x_pos_taken, $y_pos_taken, $color, $font_path, $text);            
        }
        if($ext == "png")
            imagepng($created_img,'Certificate.'.$ext);            
        else
            imagejpeg($created_img,'Certificate.'.$ext);
        imagedestroy($created_img);
        
        $attachment = 'Certificate.'.$ext;
        $mail->AddAttachment($attachment , $attachment);
        try {
            if( !$mail->send() ) {
                return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
            }
            else {
                return back()->with("success", "Email has been sent.");
            }
        } catch (Exception $e) {
             return back()->with('error','Message could not be sent.');
        }
    }
}
