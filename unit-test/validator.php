<?php
// File: validator.php
function validateAge($age) {
    if (!is_numeric($age)) {
        throw new InvalidArgumentException("Umur harus berupa angka");
    }
    if ($age < 0) {
        throw new InvalidArgumentException("Umur tidak boleh negatif");
    }
    return true;
}


// File: validator.php
function validateName($name) {
    if (!is_string($name)) {
        throw new InvalidArgumentException("Nama harus berupa huruf");
    }
    if (empty(trim($name ))) {
        throw new InvalidArgumentException("Umur tidak boleh angka");
    }
    return true;
}