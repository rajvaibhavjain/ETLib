<?php 
    namespace ETLAB;

    class Firebase {


        public static function PushNotificationSingle($token="",$title="No Title",$body="No Body",$imageurl="https://etechmy.com/images/logo.png"){
                if($token==""){
                    //Etechmy Raj Note 11 token.
                    $token="es4DCJVaRRexyFn3XjRlMC:APA91bE-oh-W8vICIb3kAoPJWAIPG7CAGSwaZY9O8jX02KgYlu3XJENb6kKSNFmMJbfZKfKU9yR6k00EPEd5g76S25NxBqvt3nPEFNRdyn0IurzWdHzDDVzvfdnO7u1kHoQNgm6mFUbY";
                }
                
				$path_to_fcm="https://fcm.googleapis.com/fcm/send";
				$server_key="AAAAywl6XlU:APA91bEQ7J2c5PrBH5kqVDQRzASTAqU_YR8M3KN2b30nr3LntKlj7WZOi5Fpx7FTs-rUDTXCgDx6ZFUyD4M3teWVi6qrkVR9vFfdUdwWG1FInGysTHE76eQOx7gnmGqUgdKOm3kmBhUd";
				
				$headers=array(
				'Authorization:key='.$server_key,
				'Content-Type:application/json'
				);
				
				$fields=array('to'=>$token,'notification'=>array('title'=>$title,'body'=>$body,"image"=>$imageurl));
				$payload=json_encode($fields);
				$curl_session=curl_init();
				curl_setopt($curl_session,CURLOPT_URL,$path_to_fcm);
				curl_setopt($curl_session,CURLOPT_POST,true);
				curl_setopt($curl_session,CURLOPT_HTTPHEADER,$headers);
				curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER,false);
				curl_setopt($curl_session,CURLOPT_IPRESOLVE,CURL_IPRESOLVE_V4);
				curl_setopt($curl_session,CURLOPT_POSTFIELDS,$payload);
				$result=curl_exec($curl_session);
				curl_close($curl_session);
				print_r($result);
        }

        public static function PushNotificationAll($token="",$title="No Title",$body="No Body",$imageurl="https://etechmy.com/images/logo.png"){
            if($token==""){
                //Etechmy Raj Note 11 token.
                $token="es4DCJVaRRexyFn3XjRlMC:APA91bE-oh-W8vICIb3kAoPJWAIPG7CAGSwaZY9O8jX02KgYlu3XJENb6kKSNFmMJbfZKfKU9yR6k00EPEd5g76S25NxBqvt3nPEFNRdyn0IurzWdHzDDVzvfdnO7u1kHoQNgm6mFUbY";
            }
            
            $path_to_fcm="https://fcm.googleapis.com/fcm/send";
            $server_key="AAAAywl6XlU:APA91bEQ7J2c5PrBH5kqVDQRzASTAqU_YR8M3KN2b30nr3LntKlj7WZOi5Fpx7FTs-rUDTXCgDx6ZFUyD4M3teWVi6qrkVR9vFfdUdwWG1FInGysTHE76eQOx7gnmGqUgdKOm3kmBhUd";
            
            $headers=array(
            'Authorization:key='.$server_key,
            'Content-Type:application/json'
            );
            
            $fields=array('to'=>$token,'notification'=>array('title'=>$title,'body'=>$body,"image"=>$imageurl));
            $payload=json_encode($fields);
            $curl_session=curl_init();
            curl_setopt($curl_session,CURLOPT_URL,$path_to_fcm);
            curl_setopt($curl_session,CURLOPT_POST,true);
            curl_setopt($curl_session,CURLOPT_HTTPHEADER,$headers);
            curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($curl_session,CURLOPT_IPRESOLVE,CURL_IPRESOLVE_V4);
            curl_setopt($curl_session,CURLOPT_POSTFIELDS,$payload);
            $result=curl_exec($curl_session);
            curl_close($curl_session);
            print_r($result);
    }

    }


?>