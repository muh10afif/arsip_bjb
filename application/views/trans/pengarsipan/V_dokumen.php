
<?php 

$nama = "./file/$nama_dok" ;

$filename = $nama; 

// Header content type 
header("Content-type: application/pdf"); 

header("Content-Length: " . filesize($filename)); 

// Send the file to the browser. 
readfile($filename); 
?> 
