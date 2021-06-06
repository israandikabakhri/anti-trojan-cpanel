<?php 
    
    
    include "php-mailer/class.phpmailer.php";

    function send_report($a)
    {

      if(count($a) > 0){

        $tujuan_report = "andikaisra7@gmail.com";

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
        $mail->Username = "admin@rutanpangkajene.com"; //user email
        $mail->Password = "(mTNs3^}TleM"; //password email 
        $mail->SetFrom("admin@rutanpangkajene.com", "REPORT TROJAN/MALWARE DETECTED"); //set email pengirim
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