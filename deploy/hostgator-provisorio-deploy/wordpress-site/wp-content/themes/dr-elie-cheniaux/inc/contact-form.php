<?php
/**
 * Contact form handler (Envie uma mensagem / Contato section).
 *
 * Submits via admin-post.php (the standard WordPress pattern for handling
 * front-end form posts) and sends through wp_mail(), which is WordPress's
 * built-in mailer. By default wp_mail() uses PHP's mail() function, which
 * many hosts block or mark as spam — to send through a real SMTP account,
 * define these constants in wp-config.php (all optional; SMTP is only used
 * if DEC_SMTP_HOST is defined):
 *
 *   define('DEC_SMTP_HOST', 'smtp.seuprovedor.com');
 *   define('DEC_SMTP_PORT', 587);                 // 587 (TLS) ou 465 (SSL)
 *   define('DEC_SMTP_SECURE', 'tls');              // 'tls' ou 'ssl'
 *   define('DEC_SMTP_USER', 'contato@seudominio.com');
 *   define('DEC_SMTP_PASS', 'sua-senha-ou-senha-de-app');
 *   define('DEC_SMTP_FROM', 'contato@seudominio.com');
 *   define('DEC_SMTP_FROM_NAME', 'Site Elie Cheniaux');
 *
 * The message is sent to echeniaux@gmail.com. To change the recipient
 * without editing this file, hook the 'dec_contact_form_recipient' filter
 * from functions.php or a small must-use plugin.
 */

if (!defined('ABSPATH')) {
    exit;
}

function dec_configure_smtp($phpmailer) {
    if (!defined('DEC_SMTP_HOST') || !DEC_SMTP_HOST) {
        return;
    }
    $phpmailer->isSMTP();
    $phpmailer->Host = DEC_SMTP_HOST;
    $phpmailer->Port = defined('DEC_SMTP_PORT') ? DEC_SMTP_PORT : 587;
    $phpmailer->SMTPSecure = defined('DEC_SMTP_SECURE') ? DEC_SMTP_SECURE : 'tls';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Username = defined('DEC_SMTP_USER') ? DEC_SMTP_USER : '';
    $phpmailer->Password = defined('DEC_SMTP_PASS') ? DEC_SMTP_PASS : '';
    if (defined('DEC_SMTP_FROM') && DEC_SMTP_FROM) {
        $phpmailer->setFrom(DEC_SMTP_FROM, defined('DEC_SMTP_FROM_NAME') ? DEC_SMTP_FROM_NAME : get_bloginfo('name'));
    }
}
add_action('phpmailer_init', 'dec_configure_smtp');

function dec_handle_contact_form() {
    $redirect = wp_get_referer() ?: home_url('/');
    $redirect = remove_query_arg('contato', $redirect) . '#contato';

    if (!isset($_POST['dec_contact_nonce']) || !wp_verify_nonce($_POST['dec_contact_nonce'], 'dec_contact_form')) {
        wp_safe_redirect(add_query_arg('contato', 'erro', $redirect));
        exit;
    }

    // Honeypot: real visitors never fill this hidden field.
    if (!empty($_POST['dec_contact_website'])) {
        wp_safe_redirect(add_query_arg('contato', 'sucesso', $redirect));
        exit;
    }

    $nome = isset($_POST['dec_nome']) ? sanitize_text_field(wp_unslash($_POST['dec_nome'])) : '';
    $email = isset($_POST['dec_email']) ? sanitize_email(wp_unslash($_POST['dec_email'])) : '';
    $mensagem = isset($_POST['dec_mensagem']) ? sanitize_textarea_field(wp_unslash($_POST['dec_mensagem'])) : '';

    if ($nome === '' || $mensagem === '' || !is_email($email)) {
        wp_safe_redirect(add_query_arg('contato', 'invalido', $redirect));
        exit;
    }

    $destinatario = apply_filters('dec_contact_form_recipient', 'echeniaux@gmail.com');
    $assunto = sprintf('[%s] Nova mensagem de contato de %s', get_bloginfo('name'), $nome);
    $corpo = "Você recebeu uma nova mensagem pelo formulário de contato do site.\n\n"
        . "Nome: {$nome}\n"
        . "E-mail: {$email}\n\n"
        . "Mensagem:\n{$mensagem}\n";
    $headers = array('Content-Type: text/plain; charset=UTF-8', "Reply-To: {$nome} <{$email}>");

    $enviado = wp_mail($destinatario, $assunto, $corpo, $headers);

    wp_safe_redirect(add_query_arg('contato', $enviado ? 'sucesso' : 'erro', $redirect));
    exit;
}
add_action('admin_post_dec_contact_form', 'dec_handle_contact_form');
add_action('admin_post_nopriv_dec_contact_form', 'dec_handle_contact_form');
