<?php
//File: test_age.php
require_once "validator.php";

//Test case 1: umur valid 
try {
    $result = validateAge(25);
    echo "PASS: Umur 25 diterima\n";
}   catch (Exception $e) { 
    echo "FAIL: Umur 25 tidak diterima. Error: " .$e->getMessage() . "\n";
}

//Test case 3: umur negatif 
try { 
    $result = validateAge(-5);
    echo "FAIL: Umur -5 seharusnya ditolak\n";
}   catch (Exception $e) {
    echo "PASS: Umur -5 ditolak. Error: " . $e->getMessage() . "\n";
}


//File: test_age.php
require_once "validator.php";

//Test case 1: nama valid 
try {
    $result = validateName("Alena");
    echo "PASS: Nama Alena diterima\n";
}   catch (Exception $e) { 
    echo "FAIL: Nama Alena tidak diterima. Error: " .$e->getMessage() . "\n";
}

//Test case 3: nama invalid
try { 
    $result = validateName("Alena11");
    echo "FAIL:Nama Alena11 seharusnya ditolak\n";
}   catch (Exception $e) {
    echo "PASS: Nama Alena11 ditolak. Error: " . $e->getMessage() . "\n";
}