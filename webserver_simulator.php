<?php
$host = '127.0.0.1'; // Endereço IP do servidor
$port = 8080;        // Porta para escutar

// Cria um socket TCP
$server = stream_socket_server("tcp://$host:$port", $errno, $errstr);

if (!$server) {
    die("Erro ao criar o servidor: $errstr ($errno)");
}

echo "Servidor HTTP rodando em http://$host:$port\n";

while ($conn = stream_socket_accept($server)) {
    // Lê a requisição
    $request = fread($conn, 1024);
    
    $content = "Olá, Mundo!";

    // Prepara a resposta
    $response = "HTTP/1.1 200 OK\r\n";
    $response .= "Content-Type: text/plain\r\n";
    $response .= "Content-Length: " . strlen($content) . "\r\n";
    $response .= "Connection: close\r\n\r\n";
    $response .= $content;

    // Envia a resposta
    fwrite($conn, $response);
    fclose($conn);
}

fclose($server);
