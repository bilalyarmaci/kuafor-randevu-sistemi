<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'kuafor_vt';

$connection = mysqli_connect($hostname,$username,$password,$db);

// Bağlantı hatası olması durumunda
if(!$connection){
    die('MySQL sunucu ile baglanti kurulamadi! <br>HATA: ' . mysqli_connect_error());
}
