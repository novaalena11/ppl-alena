<?php
require_once("config/koneksi.php");

//mencari data ID tertentu
if(isset($_GET['id'])) {
	$id=$_GET['id'];
	$query="SELECT * FROM pengurus WHERE id='$id'";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($result);

	$data=array(
		'id'=>$row['id'],
		'nama'=>$row['nama'],
		'alamat'=>$row['alamat'],
		'gender'=>$row['gender'],
		'gaji'=>$row['gaji']
	);

	$hasil=array(
		'pengurus' => $data
	);

	http_response_code(200);
	echo json_encode($hasil);

} else {

	//menampilkan semua data
	$query="SELECT * FROM pengurus";
	$result=mysqli_query($con,$query);
	$row=mysqli_fetch_assoc($result);

	do {
		$hasil[]=$row;
	} while($row=mysqli_fetch_assoc($result));

	$hasil=array(
		'pengurus' => $hasil
	);
	http_response_code(200);
	echo json_encode($hasil);	
}

?>