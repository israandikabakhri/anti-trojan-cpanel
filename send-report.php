<?php 
    
    
    include "php-mailer/class.phpmailer.php";

    function send_report($a)
    {

      if(count($a) > 0){

        $tujuan_report = "YOUR_EMAIL_REPORTED"; // tujuan report

        $message = "Pengapusan File Mencurigakan Success!!<br>
                    Daftar File Yang Mencurigakan Tersebut Adalah:<br>"; 
        $no = 1;
        foreach ($a as $v) {
          $message .= $no.'. '.$v.'<br>';
          $no++;
        }

        $message .= "<br><br><br>Salam Hormat Dari <b>Anti Trojan Cpanel</b>";

        $mail = new PHPMailer; 
        $mail->IsSMTP();
        $mail->SMTPSecure = 'tls'; 
        $mail->Host = "rutanpangkajene.com"; //host masing2 provider email
        $mail->SMTPDebug = 2;
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = "YOUR_EMAIL_USERNAME"; //user email
        $mail->Password = "YOUR_EMAIL_PASSWORD"; //password email 
        $mail->SetFrom("YOUR_EMAIL_USERNAME", "REPORT TROJAN/MALWARE DETECTED"); //set email pengirim
        $mail->Subject = "REPORT TROJAN/MALWARE DETECTED"; //subyek email
        $mail->AddAddress($tujuan_report);  //tujuan email
        $mail->MsgHTML($message);
        $mail->IsHTML(true); 
        $mail->CharSet="utf-8";


        if($mail->Send()){
          echo "Send Report Success!!";
        }else{ echo "Failed to sending message"; }

      }

    }



?>