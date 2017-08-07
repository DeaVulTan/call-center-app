<?php

class FileHelper extends CFileHelper {
    /**
    * @param string $dir path to dir to remove
    */
   public static function removeDirRecursive($dir) {
       try {
       $files = glob($dir.DIRECTORY_SEPARATOR.'{,.}*', GLOB_MARK | GLOB_BRACE);

       foreach ($files as $file) {
	   if(basename($file) == '.' || basename($file) == '..'){
	       continue;
	   }

	   if (substr($file, - 1) == DIRECTORY_SEPARATOR){
	       self::removeDirRecursive($file);
	   }
	   else {
	       unlink($file);
	   }
       }

       if (is_dir($dir)) {
	   rmdir($dir);
       }
   }
   catch(Exception $e) {
       throw new Exception('Не удалось удалить каталог');
   }
   }
}

?>
