<?php
// socket_server.php
$clients = [];
$clientInfo = [];

$host = '0.0.0.0';
$port = 9000;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($sock, $host, $port);
socket_listen($sock);
socket_set_nonblock($sock);

echo "Socket server started on {$host}:{$port}\n";

while (true) {
    $read = array_merge([$sock], $clients);
    $write = $except = null;
    
    if (socket_select($read, $write, $except, 1) < 1) continue;

    if (in_array($sock, $read)) {
        $client = socket_accept($sock);
        if ($client) {
            socket_set_nonblock($client);
            $clients[] = $client;
        }
        unset($read[array_search($sock, $read)]);
    }

    foreach ($read as $client) {
        $data = socket_read($client, 4096, PHP_NORMAL_READ);
        if ($data === false || $data === '') {
            $id = array_search($client, $clientInfo);
            if ($id !== false) unset($clientInfo[$id]);
            $key = array_search($client, $clients);
            if ($key !== false) unset($clients[$key]);
            socket_close($client);
            continue;
        }

        $data = trim($data);
        echo $data;
        echo "\n";
        $json = json_decode($data, true);
        if (!$json) continue;

        if (isset($json['type']) && $json['type'] === 'register') {
            $clientInfo[$json['uniq_id']] = $client;
            echo "Client registered: {$json['uniq_id']}\n";
        }

        if (isset($json['type']) && $json['type'] === 'print') {
            $target = $json['uniq_id'];
            // $printData = $json['print_string'];
            $printData = "PRINT:print.txt";

            if (isset($clientInfo[$target])) {
                $targetSocket = $clientInfo[$target];
                socket_write($targetSocket, $printData . "\n");
                echo "Sent print data to {$target}\n";
            } else {
                echo "Client with uniq_id {$target} not found\n";
            }
        }
    }
}

socket_close($sock);
