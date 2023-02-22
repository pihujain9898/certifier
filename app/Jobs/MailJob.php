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
    
    public $mail, $value, $ext, $imgName, $querries, $width_ratio, $height_ratio, $data, $count, $font_ratio;

    public function __construct($mail, $value, $ext, $imgName, $querries, $width_ratio, $height_ratio, $data, $count, $font_ratio)
    {
        $this->mail = $mail;
        $this->value = $value;
        $this->ext = $ext;
        $this->imgName = $imgName;
        $this->querries = $querries;
        $this->width_ratio = $width_ratio;
        $this->height_ratio = $height_ratio;
        $this->data = $data;
        $this->count = $count;
        $this->font_ratio = $font_ratio;
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
        $count = $this->count;
        $font_ratio = $this->font_ratio;

        $mail->clearAllRecipients();
        $mail->addAddress($value[0]);

        if($ext == "png"){
            $created_img = imagecreatefrompng(public_path('uploads/certificates/'.$imgName));
        }
        else{
            $created_img = imagecreatefromjpeg(public_path('uploads/certificates/'.$imgName));
        }
        $color = imagecolorallocate($created_img, 0, 0, 0);
        
        foreach ($querries as $querryName => $querry) {
            $x_pos_given=(float)json_decode($querry)->xPosition;
            $y_pos_given=(float)json_decode($querry)->yPosition;
            $font_size = ((float)json_decode($querry)->fontSize)*$font_ratio*16;
            $angle=0;
            $font_path = public_path('SegoeUI.ttf');
            if (json_decode($querry)->attribType == 'static')
                $text = json_decode($querry)->attribSample;
            else{
                $colAttribs = json_decode($data->dataFileAttribs,true);
                $column_no = array_search(json_decode($querry)->attribName,$colAttribs,true);                
                $text = json_decode($data->datasrc, true)[$count][$column_no]; 
            }
            list($left, $bottom, $right, , , $top) = imageftbbox($font_size, $angle, $font_path, $text);
            $left_offset = ($right - $left) / 2;
            $top_offset = ($bottom - $top) / 2;
            $x_pos_taken = $x_pos_given * $width_ratio - $left_offset;
            $y_pos_taken = $y_pos_given * $height_ratio + $top_offset;
            imagettftext($created_img, $font_size, $angle, $x_pos_taken, $y_pos_taken, $color, $font_path, $text);            
        }
        if($ext == "png")
            imagepng($created_img, public_path('Certificate.'.$ext));
        else
            imagejpeg($created_img, public_path('Certificate.'.$ext));
        imagedestroy($created_img);
        
        $attachment = public_path('Certificate.'.$ext);
        $mail->AddAttachment($attachment , 'Certificate.'.$ext);
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
