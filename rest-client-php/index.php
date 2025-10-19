<?php
//load config.php
include("config/config.php");
 
//url api 
$endpoint="https://equran.id/api/v2/surat/1";
 
//menyimpan hasil dalam variabel
$data=http_request_get($endpoint);
 
//konversi data json ke array
$hasil=json_decode($data,true);

// var_dump($hasil['data']['ayat']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Rest Client dengan PHP</title>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar bg-success navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">QuranAPI</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    <a class="nav-link" href="#">Surah</a>
                    <a class="nav-link" href="#">About</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar  -->
    <div class="container mt-4">
        <h1>Quran Digital</h1>

        <div class="row">
            <!-- looping hasil data di array  -->
            <div class="list-group">
                <?php foreach ($hasil['data']['ayat'] as $row) { ?>
                    <a href="#" class="list-group-item list-group-item-action">
                        <p class="text-end fs-3 fw-bold"><?= $row['teksArab'] ?></p>
                        <p class="text-start"><?= $row['teksIndonesia'] ?></p>
                        <p class="text-start">
                        <audio src="<?= $row['audio']['05']; ?>" controls></audio>
                        </p>
                    </a>
                <?php } ?>
            </div>
            <!-- looping hasil data di array  -->
            
        </div>
    </div>
    
  
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>