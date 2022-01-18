<?php
	function write_file($string)
	{
		$fp = fopen('./logs/file_log.txt', 'a');
		fwrite($fp, "$string\n");    
		fclose($fp);  
	}
?>