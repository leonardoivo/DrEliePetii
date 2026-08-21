<?php
/**
 * Teste standalone de SMTP (Titan Email) - sem dependencias externas.
 * Rode este arquivo no SEU servidor (onde o site fica hospedado), via CLI:
 *   php teste_smtp_titan.php
 * ou colocando-o na raiz do site e acessando pela URL uma unica vez
 * (depois APAGUE o arquivo do servidor, pois ele contem a senha em texto puro).
 */

define('DEC_SMTP_HOST', 'smtp.titan.email');
define('DEC_SMTP_PORT', 465);
define('DEC_SMTP_SECURE', 'tls');
define('DEC_SMTP_USER', 'contato@eliecheniaux.com');
define('DEC_SMTP_PASS', 'ElieCheniaux2026!');
define('DEC_SMTP_FROM', 'contato@eliecheniaux.com');
define('DEC_SMTP_FROM_NAME', 'Site Elie Cheniaux');

// Para onde enviar o e-mail de teste (por padrao, para a propria caixa)
$destinatario = DEC_SMTP_FROM;

function log_linha($msg) {
    echo '[' . date('H:i:s') . "] $msg\n";
}

function ler_resposta($conn) {
    $resposta = '';
    while ($linha = fgets($conn, 515)) {
        $resposta .= $linha;
        if (isset($linha[3]) && $linha[3] === ' ') break;
    }
    return $resposta;
}

function checar($conn, $esperado, $etapa) {
    $resp = ler_resposta($conn);
    log_linha("$etapa -> " . trim($resp));
    if (substr($resp, 0, 3) !== $esperado) {
        throw new Exception("Falha em '$etapa'. Esperado $esperado, recebido: $resp");
    }
    return $resp;
}

try {
    log_linha("Conectando via SSL em " . DEC_SMTP_HOST . ':' . DEC_SMTP_PORT . ' ...');

    $contexto = stream_context_create();
    $conn = @stream_socket_client(
        'ssl://' . DEC_SMTP_HOST . ':' . DEC_SMTP_PORT,
        $errno,
        $errstr,
        15,
        STREAM_CLIENT_CONNECT,
        $contexto
    );

    if (!$conn) {
        throw new Exception("Nao foi possivel conectar: [$errno] $errstr");
    }
    log_linha('Conexao SSL estabelecida com sucesso.');

    checar($conn, '220', 'Saudacao do servidor');

    fwrite($conn, "EHLO " . DEC_SMTP_HOST . "\r\n");
    checar($conn, '250', 'EHLO');

    fwrite($conn, "AUTH LOGIN\r\n");
    checar($conn, '334', 'AUTH LOGIN');

    fwrite($conn, base64_encode(DEC_SMTP_USER) . "\r\n");
    checar($conn, '334', 'Usuario');

    fwrite($conn, base64_encode(DEC_SMTP_PASS) . "\r\n");
    checar($conn, '235', 'Senha (autenticacao)');

    log_linha('AUTENTICACAO OK! As credenciais estao corretas.');

    fwrite($conn, "MAIL FROM:<" . DEC_SMTP_FROM . ">\r\n");
    checar($conn, '250', 'MAIL FROM');

    fwrite($conn, "RCPT TO:<" . $destinatario . ">\r\n");
    checar($conn, '250', 'RCPT TO');

    fwrite($conn, "DATA\r\n");
    checar($conn, '354', 'DATA');

    $corpo = "Subject: Teste SMTP - Titan Email\r\n"
        . "From: " . DEC_SMTP_FROM_NAME . " <" . DEC_SMTP_FROM . ">\r\n"
        . "To: <$destinatario>\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: text/plain; charset=UTF-8\r\n"
        . "\r\n"
        . "Este e um e-mail de teste para validar as configuracoes SMTP.\r\n"
        . "Enviado em " . date('Y-m-d H:i:s') . "\r\n"
        . ".\r\n";

    fwrite($conn, $corpo);
    checar($conn, '250', 'Envio do e-mail');

    log_linha("E-MAIL ENVIADO COM SUCESSO para $destinatario!");

    fwrite($conn, "QUIT\r\n");
    fclose($conn);

    log_linha('TUDO OK - configuracao validada com envio real.');

} catch (Exception $e) {
    log_linha('ERRO: ' . $e->getMessage());
    if (isset($conn) && is_resource($conn)) {
        fclose($conn);
    }
}
