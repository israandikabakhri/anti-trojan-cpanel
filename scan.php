<?php

include 'init.php';

function exception($value){

	if(
	
		$value != ".git" &&     // file yang di kecualikan
		$value != "data_upload" // file yang di kecualikan

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

$scan = getDirContents('../');


$output = array_merge(array_diff($scan, $init), array_diff($init, $scan));

if(count($output) > 0){
    echo "<center><h1 style='color:red;'>Terdeteksi Ada ".count($output)." File Mencurigakan!</h1>";
    echo "<br><br>";
    echo "<table style='width:60%;border-collapse:collapse;background-color:black;color:white;' border='1'>";
    echo "<tr><th>No</th><th>Path</th></tr>";
    $no=1;
    foreach ($output as $a) {
	    echo "<tr>";
	    echo "<td><center>".$no."</td>";
	    echo "<td style='padding-left:10px'>".$a."</td>";
	    echo "</tr>";
	    $no++;	
    }
    echo "</table>";
}else{
	echo "<h1 style='color:green;'>Tidak Terdeteksi</h1>";
}

?>