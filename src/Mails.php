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
