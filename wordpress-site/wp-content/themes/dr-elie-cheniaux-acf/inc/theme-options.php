<?php
/**
 * "Mídia do Site" — the screen that edits every image / PDF that is NOT tied to
 * a single Livro / Artigo / Entrevista / Palestra.
 *
 * Two ways to render it, chosen automatically:
 *   • ACF PRO present  -> a real ACF options page (Aparência → Mídia do Site).
 *   • ACF free only     -> a private Page "Mídia do Site" that carries the same
 *                          ACF field group; a shortcut is added under Aparência.
 *
 * Either way the values are read with dec_opt('chave').  The field group itself
 * is declared in inc/acf-fields.php.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('DEC_MEDIA_PAGE_SLUG')) {
    define('DEC_MEDIA_PAGE_SLUG', 'dec-midia-do-site');
}

/**
 * @param string $key
 * @param mixed  $default
 * @return mixed
 */
function dec_opt($key, $default = '') {
    if (!function_exists('get_field')) {
        return $default;
    }
    // ACF PRO options page
    if (function_exists('acf_add_options_page')) {
        $val = get_field($key, 'option');
        if ($val !== null && $val !== '' && $val !== false && $val !== array()) {
            return $val;
        }
    }
    // ACF free: value stored on the "Mídia do Site" page
    $page = get_page_by_path(DEC_MEDIA_PAGE_SLUG);
    if ($page) {
        $val = get_field($key, $page->ID);
        if ($val !== null && $val !== '' && $val !== false && $val !== array()) {
            return $val;
        }
    }
    return $default;
}

/* -------------------------------------------------------------------------
 * ACF PRO path — real options page
 * ---------------------------------------------------------------------- */
function dec_acf_options_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title'  => 'Mídia do Site',
            'menu_title'  => 'Mídia do Site',
            'menu_slug'   => 'dec-site-media',
            'parent_slug' => 'themes.php',
            'capability'  => 'edit_theme_options',
            'redirect'    => false,
        ));
    }
}
add_action('acf/init', 'dec_acf_options_page');

/* -------------------------------------------------------------------------
 * ACF free path — a private Page that holds the fields
 * ---------------------------------------------------------------------- */
function dec_ensure_media_page() {
    if (function_exists('acf_add_options_page')) {
        return; // PRO handles it
    }
    if (get_option('dec_media_page_id') && get_post(get_option('dec_media_page_id'))) {
        return;
    }
    $existing = get_page_by_path(DEC_MEDIA_PAGE_SLUG);
    if ($existing) {
        update_option('dec_media_page_id', $existing->ID);
        return;
    }
    $id = wp_insert_post(array(
        'post_title'   => 'Mídia do Site',
        'post_name'    => DEC_MEDIA_PAGE_SLUG,
        'post_status'  => 'private',
        'post_type'    => 'page',
        'post_content' => 'Troque aqui as imagens e PDFs gerais do site. Esta página não aparece no menu nem no site público.',
    ));
    if ($id && !is_wp_error($id)) {
        update_option('dec_media_page_id', $id);
    }
}
// priority 1 so the Page exists before ACF fires `acf/init` (init, priority 5).
add_action('init', 'dec_ensure_media_page', 1);
add_action('after_switch_theme', 'dec_ensure_media_page');

/**
 * Aparência → "Mídia do Site" shortcut straight to the page editor (ACF-free path).
 */
function dec_media_page_menu_link() {
    if (function_exists('acf_add_options_page')) {
        return;
    }
    $page = get_page_by_path(DEC_MEDIA_PAGE_SLUG);
    if (!$page) {
        return;
    }
    add_theme_page(
        'Mídia do Site',
        'Mídia do Site',
        'edit_theme_options',
        'post.php?post=' . $page->ID . '&action=edit'
    );
}
add_action('admin_menu', 'dec_media_page_menu_link');
