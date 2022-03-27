<?php 

try{

	$db=new PDO("mysql:host=localhost;dbname=telefonrehberi;charset=utf8",'root','');
	//echo "Veritabanı bağlantısı başarılı";
}

catch(PDOException $e){
	echo $e -> getMessage();
}

?>