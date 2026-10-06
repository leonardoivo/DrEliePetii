<?php
/**
 * Turns a stored media value into a URL, no matter which shape it has:
 *   1. an attachment ID  (ACF image/file fields are configured to return the ID)
 *   2. a full URL
 *   3. a bare filename still sitting in the theme's /img or /pdf folder
 *      (every value from before this feature / from the seeder)
 *
 * Templates only ever call dec_media_url() / dec_media_img(), so they are
 * identical between the plugin-free theme and this ACF theme.
 */

if (!defined('ABSPATH')) {
    exit;
}

function dec_media_url($value, $legacy_dir = 'img') {
    if (is_array($value)) {
        // ACF may hand back an attachment array depending on return format
        if (isset($value['url'])) {
            return $value['url'];
        }
        if (isset($value['ID'])) {
            $value = $value['ID'];
        } else {
            $value = reset($value);
        }
    }
    $value = trim((string) $value);
    if ($value === '') {
        return '';
    }
    if (ctype_digit($value)) {
        $url = wp_get_attachment_url((int) $value);
        return $url ? $url : '';
    }
    if (preg_match('#^(https?:)?//#i', $value)) {
        return $value;
    }
    return get_template_directory_uri() . '/' . trim($legacy_dir, '/') . '/' . ltrim($value, '/');
}

function dec_media_img($value, $fallback_alt = '', $legacy_dir = 'img') {
    $url = dec_media_url($value, $legacy_dir);
    $alt = $fallback_alt;
    if (is_string($value) && ctype_digit(trim($value))) {
        $stored = get_post_meta((int) $value, '_wp_attachment_image_alt', true);
        if ($stored !== '') {
            $alt = $stored;
        }
    }
    return array($url, $alt);
}

function dec_media_url_fallback($candidates, $legacy_dir = 'img') {
    foreach ((array) $candidates as $candidate) {
        $url = dec_media_url($candidate, $legacy_dir);
        if ($url !== '') {
            return $url;
        }
    }
    return '';
}

/**
 * Normalised "Encontros Especiais" gallery: array of array('url' => , 'caption' => ).
 */
function dec_encontros_imgs($post_id = null) {
    $out = array();

    // 1. the "Encontros Especiais" page's own gallery (ACF field on that page)
    if ($post_id === null) {
        $page = get_page_by_path('encontros');
        $post_id = $page ? $page->ID : 0;
    }
    $items = $post_id ? get_post_meta($post_id, 'dec_encontros_galeria', true) : '';

    // 2. fall back to the global "Mídia do Site" gallery
    if (empty($items) || !is_array($items)) {
        $items = dec_opt('encontros_galeria', array());
    }

    foreach ((array) $items as $item) {
        if (is_array($item)) {
            $url     = isset($item['url']) ? $item['url'] : '';
            $caption = isset($item['title']) ? $item['title'] : (isset($item['alt']) ? $item['alt'] : '');
        } else {
            $url     = wp_get_attachment_url((int) $item);
            $caption = $url ? get_the_title((int) $item) : '';
        }
        if ($url) {
            $out[] = array('url' => $url, 'caption' => $caption);
        }
    }
    if ($out) {
        return $out;
    }
    foreach ((array) get_theme_mod('dec_encontros_preview', array()) as $img) {
        if (empty($img['src'])) {
            continue;
        }
        $out[] = array(
            'url'     => get_template_directory_uri() . '/img/' . $img['src'],
            'caption' => isset($img['alt']) && $img['alt'] !== '' ? $img['alt'] : pathinfo($img['src'], PATHINFO_FILENAME),
        );
    }
    return $out;
}
