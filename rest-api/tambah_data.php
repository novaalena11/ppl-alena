<?php
require_once("config/koneksi.php");

$id     = $_POST['id']     ?? '';
$nama   = $_POST['nama']   ?? '';
$alamat = $_POST['alamat'] ?? '';
$gender = $_POST['gender'] ?? '';
$gaji   = $_POST['gaji']   ?? '';


$query="INSERT INTO pengurus (id, nama, alamat, gender, gaji) VALUES ('$id', '$nama', '$alamat', '$gender', '$gaji')";
$result=mysqli_query($con,$query);

$respon=array( //digunakan untuk pesan
	'response' => 200,
	'pesan' => 'Data berhasil Masuk'
);

http_response_code(200);

echo json_encode($respon);


?>