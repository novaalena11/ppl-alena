<?php
// memasukan file config
include("config.php");

// url untuk lihat data
$url = "http://localhost/ppl-alena/rest-api/tampil_data.php";

// menyimpan hasil dalam variabel (fungsi http_request_get ada di config.php)
$data = http_request_get($url);

// konversi data json ke array
$hasil = json_decode($data, true);

// cek error decoding JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    $err = json_last_error_msg();
    die("Gagal decode JSON dari API: $err");
}

// Normalisasi: cari array baris yang benar
$rows = [];

// 1) API mengembalikan langsung array of rows: [ {id:..., nama:...}, {...} ]
if (is_array($hasil) && isset($hasil[0]) && is_array($hasil[0])) {
    $rows = $hasil;
}
// 2) API membungkus data di key 'data' atau 'result' (contoh: { response:200, data:[...] })
elseif (is_array($hasil) && isset($hasil['data']) && is_array($hasil['data'])) {
    $rows = $hasil['data'];
}
elseif (is_array($hasil) && isset($hasil['result']) && is_array($hasil['result'])) {
    $rows = $hasil['result'];
}
// 3) API membungkus data di key 'pengurus' (sesuai response-mu)
elseif (is_array($hasil) && isset($hasil['pengurus']) && is_array($hasil['pengurus'])) {
    $rows = $hasil['pengurus'];
}
// 4) API mengembalikan single record langsung {id:..., nama:...}
elseif (is_array($hasil) && isset($hasil['id'])) {
    $rows[] = $hasil;
}
// 5) tidak ada data: biarkan $rows kosong
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tampil Data dengan cURL</title>
</head>
<body>
    <h1>Data Pengurus dengan RestAPI</h1>

    <?php if (empty($rows)) : ?>
        <p>Tidak ada data untuk ditampilkan.</p>
        <pre>Response API mentah: <?php echo htmlentities($data); ?></pre>
    <?php else: ?>
    <table border="2">
    <tr>
        <th>ID</th>
        <th>NAMA</th>
        <th>ALAMAT</th>
        <th>GENDER</th>
        <th>GAJI</th>
        <th>AKSI</th>
    </tr>
    <?php foreach($rows as $row) : 
        $id     = isset($row['id']) ? $row['id'] : '';
        $nama   = isset($row['nama']) ? $row['nama'] : '';
        $alamat = isset($row['alamat']) ? $row['alamat'] : '';
        $gender = isset($row['gender']) ? $row['gender'] : '';
        $gaji   = isset($row['gaji']) ? $row['gaji'] : '';
    ?>
    <tr>
        <td><?php echo htmlentities($id); ?></td>
        <td><?php echo htmlentities($nama); ?></td>
        <td><?php echo htmlentities($alamat); ?></td>
        <td><?php echo htmlentities($gender); ?></td>
        <td><?php echo htmlentities($gaji); ?></td>
        <td>
            <a href="edit_data.php?id=<?php echo urlencode($id); ?>">Edit</a>
            <a href="hapus_data.php?id=<?php echo $row['id']; ?>">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

    <?php endif; ?>

</body>
</html>
