<?php
require_once("config/koneksi.php");

$id=$_GET['id'];
$query="DELETE FROM pengurus WHERE id='$id'";
$result=mysqli_query($con,$query);

$respon=array( //digunakan untuk pesan
		'response' => 200,
		'pesan' => 'Data berhasil Dihapus'
);
http_response_code(200);

echo json_encode($respon);
?>