<?php 
include 'baglan.php';

if ($_GET['sil']=="ok") {

	$sil=$db->prepare("DELETE FROM rehber WHERE tel_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['tel_id']
	));

	if ($kontrol) {

		Header("Location:index.php?durum=ok");
		exit;

	} else {

		Header("Location:index.php?durum=no");
		exit;
	}

}

?>
