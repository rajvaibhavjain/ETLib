<?php 
    namespace ETLAB;

    class Document {
        public static function Upload($sourcePath,$targetPath){
            if(move_uploaded_file($sourcePath,$targetPath)){
                return true;
            }else{
                return false;
            }
        }


        public static function DocumentUpload($file){
            $sourcePath = $file['image']['tmp_name'];
            $extension = explode("/", $file['image']["type"]);
            $name = $file['name'].".".$extension[1]; 
            $targetPath = $file['targetpath'].$name; 
            $dbpath = $file['dbpath'].$name;
            if(Document::Upload($sourcePath,$targetPath)){
                return [
                            'doumentname'=>$name,
                            'dbpath'=>$dbpath,
                            'targetpath'=>$targetPath,
                        ];
            }else{
                return false;
            }
        }

        public static function DeleteFile($path){
            if(file_exists($path)){
                unlink($path);
            }
        }


        public static function CompressImage($source, $destination, $quality) {
            $info = getimagesize($source);
            if ($info['mime'] == 'image/jpeg') 
                $image = imagecreatefromjpeg($source);
            elseif ($info['mime'] == 'image/gif') 
                $image = imagecreatefromgif($source);
            elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($source);
            if(imagejpeg($image, $destination, $quality)){
                return true;
            }else{
                return false;
            };
        }

    }


?>