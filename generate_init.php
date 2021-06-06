<?php

function exception($value){

	if(
	
		$value != ".git" && 
		$value != "data_upload"

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

?>

<h3>Masukkan Username Dan Password</h3>
<form method="post">
	<input type="text" name="usr" placeholder="Username"><br>
	<input type="password" name="pdd" placeholder="Password"><br>
	<input type="submit" name="Submit" value="SUBMIT">
</form>
<?php

if(isset($_POST['Submit'])){

	if($_POST['usr'] == "admin" && $_POST['pdd'] == "palaguna_cpanel_33"){


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

		$myfile   = fopen("init.php", "r") or die("Unable to open file!");
		$old_init = fread($myfile,filesize("init.php"));
		fclose($myfile);

		$file1=fopen("backup_init/init.php", "a+") or die("File tidak ada");     
		fwrite($file1,$old_init);
		fclose($file1);


		$file2=fopen("init.php", "w+") or die("File tidak ada");     
		fwrite($file2,$isi);
		fclose($file2);

		echo 'Generate Init Success!!';

	}else{

		echo 'Username atau Password anda salah';
	
	}

}else{

	echo 'Tekan Submit';
}

?>