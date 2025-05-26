<?php
$host = 'localhost'; // Ganti dengan IP/host server socket
$port = 9000;                    // Ganti dengan port server socket
$uniqId = 'client001';         // ID unik printer ini
$webEndpoint = 'http://localhost:8000';

$printerName = "\\\\Fauzy\RP58 Printer"; // Nama share printer di Windows

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (!$socket) {
    die("Gagal membuat socket\n");
}

if (!socket_connect($socket, $host, $port)) {
    die("Gagal konek ke server\n");
}

echo "Socket connected\n";

// Kirim uniq_id untuk registrasi
socket_write($socket, '{"type":"register","uniq_id":"'.$uniqId.'"}'."\n");

// Loop untuk mendengarkan perintah print
while (true) {
    $data = socket_read($socket, 2048, PHP_NORMAL_READ);
    if ($data === false) break;

    $data = trim($data);
    echo $data ."\n";
    if (strpos($data, 'PRINT:') === 0) {
        $content = substr($data, 6); // Ambil isi print
        echo "Mencetak struk...\n";

        // Kirim ke printer
        echo $printerName ."\n";
        $file = file_get_contents($webEndpoint . '/' . $content);
        file_put_contents('print.txt', $file);
        copy('print.txt', $printerName);
    }
}

socket_close($socket);
