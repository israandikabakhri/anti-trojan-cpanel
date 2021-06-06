<?php

include 'init.php';
include 'send-report.php';

function exception($value){

	if(
	
		$value != ".git" &&      // file yang di kecualikan
		$value != "data_upload"  // file yang di kecualikan

	  ){ 
		return true; 
	  } else {
	  	return false;
	  }


}

function strip_special_chars($v)
{

    $one = str_replace('../\\','',$v);
    $two = str_replace('\\','/',$one);
    
    return $two;

}

function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);

	    foreach ($files as $key => $value) {
	        $path = $dir . DIRECTORY_SEPARATOR . $value;
	        if(exception($value)){
		        if (!is_dir($path)) {
		            $results[] = $path;
		        } else if ($value != "." && $value != "..") {
		            getDirContents($path, $results);
		            $results[] = $path;
		        }
		    }
	    }
	    

    return array_map('strip_special_chars',$results);
}

function equal_array($arr)
{

   $ArrayObject = new ArrayObject($arr);
  
   return $ArrayObject->getArrayCopy();  

}


$scan = getDirContents('../');

$output = array_merge(array_diff($scan, $init), array_diff($init, $scan));

$arr = equal_array($output);

if(count($output))
{

	foreach ($output as $a) {
		
		unlink("../".$a);
		rmdir('../'.$a);

	}

}

send_report($arr);

?>