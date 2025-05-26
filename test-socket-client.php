<?php
$host = 'localhost'; // Ganti dengan IP/host server socket
$port = 9000;                    // Ganti dengan port server socket
$uniqId = 'client001';         // ID unik printer ini

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (!$socket) {
    die("Gagal membuat socket\n");
}

if (!socket_connect($socket, $host, $port)) {
    die("Gagal konek ke server\n");
}
// Kirim uniq_id untuk registrasi
socket_write($socket, '{"type":"print","uniq_id":"'.$uniqId.'"}'."\n");

socket_close($socket);
