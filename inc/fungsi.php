<?php
include 'koneksi.php';

function getprofilweb($tax)
{
    global $connect;
    $hasil = mysqli_query($connect,"SELECT * FROM konfigurasi WHERE Tax='$tax' ORDER BY ID DESC LIMIT 1");
    while($r = mysqli_fetch_array($hasil))
    {
        return $r['Isi'];
    }
}