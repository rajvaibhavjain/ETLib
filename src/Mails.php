<?php

namespace ETLAB;

use PHPMailer\PHPMailer\PHPMailer;


    
class Mails
{
    public static function DoEmail($userName,$userEmail,$mailSubject,$mailBody)
	{    
        $fromName=$GLOBALS['AppConfig']['SenderName'];
        $fromEmail=$GLOBALS['AppConfig']['SenderEmail'];

		$objPhpMailer = new PHPMailer();
		$objPhpMailer->IsSMTP();                           	            // telling the class to use SMTP
		$objPhpMailer->SMTPAuth   = true;                  			    // enable SMTP authentication
		//$objPhpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // sets the prefix to the servier
		$objPhpMailer->SMTPSecure = "tls";           	                // sets the prefix to the servier ssl tls
		
		// $objPhpMailer->SMTPOptions = array(
		// 'ssl' => array(
		// 	'verify_peer' => false,
		// 	'verify_peer_name' => false,
		// 	'allow_self_signed' => true
		// 	)
		// );
		
		$objPhpMailer->Host       = $GLOBALS['AppConfig']['SMTPHost'];		    // sets the SMTP server
		$objPhpMailer->Port       = $GLOBALS['AppConfig']['SMTPPort'];			// set the SMTP port 465 587
		$objPhpMailer->Username   = $GLOBALS['AppConfig']['SMTPUsername'];		// username
		$objPhpMailer->Password   = $GLOBALS['AppConfig']['SMTPPassword'];		// password
    
        
		$objPhpMailer->SetFrom($fromEmail, $fromName);
	    $objPhpMailer->AddReplyTo($fromEmail, $fromName);
		$objPhpMailer->AddAddress($userEmail, $userName);
		$objPhpMailer->Subject = $mailSubject;
	    $objPhpMailer->MsgHTML($mailBody);		
	
		if(!$objPhpMailer->Send()) 
		{
            //echo "Mailer Error: " . $objPhpMailer->ErrorInfo;
			$objPhpMailer->ClearAllRecipients();
			return false;
		} 
		else 
		{
			//echo "Message sent!";
			$objPhpMailer->ClearAllRecipients();
			return true;
		}
	}

	public static function DoPhpEmail($to="rajvaibhavjain@gmail.com",$from="info@etechmy.com",$fromName="ETECHMY",$subject="Tech Rockes.",$message="<h3>Tech Rockes</h3>"){
		$from = 'rvj1@atthah.com';
		$fromName = $_REQUEST['name'];
		$subject = $_REQUEST['subject'];
		$content=$_REQUEST['message'];
		$htmlContent = '<h3>Dear Sir/ Ma’am,</h3>
			<p>'.$content.'</p>			
			<p>Hope this gives an insight into the State’s investor friendly approach.</P>
			<p>We look forward to a long and fruitful association.</P>
			<p>Thanking you</P>';
		$headers = "From: $fromName"." <".$from.">";
		$semi_rand = md5(time()); 
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
		$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";  
		$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
		$message .= "--{$mime_boundary}--";
		$returnpath = "-f" . $from;
		$mail = @mail($to, $subject, $message, $headers, $returnpath); 
		echo $mail?"<h1>Mail sent.</h1>":"<h1>Mail sending failed.</h1>";
	}

	public static function DoCMSEmail($emailid,$params,$userName,$userEmail){
		$x=DB::ExecuteScalarRow("select subject,body from email where emailid='$emailid'");
		if(is_array($params)){
			foreach($params as $k=>$v){
				$x['body']=str_replace("{".$k."}",$v,$x['body']);
			}
		}
		Mails::DoEmail($userName,$userEmail,$x['subject'],$x['body']);
		return $x;
	}

	
}
