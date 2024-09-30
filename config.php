<?php

$server = "localhost";
$user = "root";
$password = "bela123";
$nama_database = "biblioteca";

$db = mysqli_connect($server, $user, $password, $nama_database);

if (!$db)
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
