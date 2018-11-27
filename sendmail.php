<?php

  session_start();

  if(!isset($_SESSION['admin'])){
    header('location:admin.php');
  }

  include 'koneksi.php';
  
  require 'library/PHPMailer/PHPMailerAutoload.php';

if(isset($_REQUEST['idPemilih']) && is_array($_REQUEST['idPemilih'])):
	
	$query = "SELECT * FROM PEMILIH where id IN (" . implode(',',$_REQUEST['idPemilih']) . ")";

	$exe = mysql_query($query);
	
	$mail = new PHPMailer;

	while($array = mysql_fetch_array($exe)){

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'sekretariatmpm.polmanastra@gmail.com';                            // SMTP username
		$mail->Password = 'mpmpolmanastra';                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
		$mail->Port 	= 465;
		$mail->isHTML(true);
		$mail->SMTPAuth = true;
		$mail->SMTPDebug = 1;


		$mail->SetFrom('sekretariatmpm.polmanastra@gmail.com');
		$mail->FromName = 'Pemira';
		$mail->addAddress($array['email']);  // Add a recipient
		$mail->addReplyTo('sekretariatmpm.polmanastra@gmail.com', 'Information');

		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = '[PEMIRA] Username dan Kode Aktivasi Pemilihan Raya ONLINE';
		$mail->Body    = '
		<table border="0" cellspacing="0" cellpadding="0" width="">
		        <tbody><tr>
		          <td width="15">&nbsp;</td>
		          <td width="520">
		            <table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff">
		            <tbody><tr height="78">
		              <td width="420" valign="bottom"><a href="" target="_blank">
		              <img src="'. $_SERVER['HTTP_HOST'] .'/logo/PEMIRA.png" alt="Pemilihan Raya" title="PEMIRA" width="124" height="61" border="0" align="bottom"></a></td>
		              <td width="100" align="right" nowrap="" valign="bottom"><p style="margin:0;font:13px Helvetica,Arial,sans-serif;color:#0c4b85">PEMIRA</p></td>
		            </tr>
		            <tr height="17">
		              <td width="520" colspan="2" style="border-bottom:2px solid #0f2c55">&nbsp;</td>
		            </tr>
		            </tbody></table>
		          </td>
		          <td width="15">&nbsp;</td>
		        </tr>
		        <tr>
		          <td width="15">&nbsp;</td>
		          <td width="520">
		            <table border="0" cellspacing="0" cellpadding="0" width="">
		            <tbody><tr>
		              <td>&nbsp;</td>
		            </tr>
		            <tr>
		              <td>
		              <table border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff">
		                <tbody><tr>
		                <td width="520"><p style="padding:0;margin:0;font:14px/20px Helvetica,Arial,sans-serif">Hi <b>' . $array['nama'] . '</b>,<br>
		                  Silahkan gunakan hak pilih anda pada tanggal <b>06 Dec</b> di situs <a href="'. $_SERVER['HTTP_HOST'] .'">http://'. $_SERVER['HTTP_HOST'] .'</a></p></td>
		                  
		                </tr>
		              </tbody></table>
		              </td>
		            </tr>
		                    
		            <tr>
		            <td width="520">
		              <table border="0" cellpadding="0" cellspacing="0" width="100%">
		              <tbody><tr height="50">
		                <td>
		                  <b>Silahkan Login dengen data berikut :</b><br />
		                  
		               
		                	<b>NIM : </b>
		                  '. $array['nim'] .' <br /> 
		                  <b>Activation Code :</b>
		                   '. $array['verifyCode'] .' <br /> 
		                 
		                <br /> 
		                </td>
		                </tr>
		              </tbody></table>
		              </td>
		            </tr>
		            </tbody></table>
		          </td>
		          <td width="15">&nbsp;</td>
		        </tr>
		        <tr>
		          <td colspan="3">
		            <table width="550" bgcolor="#0f2c55" border="0" cellspacing="0" cellpadding="15">
		            <tbody><tr>
		              <td bgcolor="#0f2c55" width="510" align="center">
		              <table width="510" border="0" cellspacing="0" cellpadding="10">
		                <tbody><tr>
		                <td align="left">
		                  <p style="margin:0;padding:0;color:#ececf1;font:9px/1 Helvetica,Arial,sans-serif">&nbsp;</p>
		                </td>
		                </tr>
		              </tbody></table>
		              <table width="510" border="0" cellspacing="0" cellpadding="10">
		                <tbody><tr>
		                <td align="right" nowrap="" valign="top" style="margin:0;color:#ececf1;font:13px/1 Helvetica,Arial,sans-serif">HIMMA MI @ 2013</td>
		                </tr>
		              </tbody></table>
		              </td>
		            </tr>
		            </tbody></table>
		          </td>
		        </tr>
		      </tbody></table>';
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
		   echo 'Message could not be sent.';
		   echo 'Mailer Error: ' . $mail->ErrorInfo;
		   exit;
		}

	}

	
endif;