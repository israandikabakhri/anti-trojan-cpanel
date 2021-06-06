<?php

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

$scan  = getDirContents('../');

$total = count($scan);

$isi   = '<?php $init = array(';

$no = 1;
foreach ($scan as $a) {

	if($total==$no){
	   $isi .= '"'.$a.'"';
	}else{
	   $isi .= '"'.$a.'", ';
    }
	$no++;
}

$isi .= '); ?>';

$file=fopen("init.php", "w+") or die("File tidak ada");     
fwrite($file,$isi);
fclose($file);

?>