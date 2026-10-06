<?php
/**
 * Dr. Elie Cheniaux theme functions.
 */

if (!defined('ABSPATH')) {
    exit;
}

define('DEC_VERSION', '1.0.0');

require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/media-resolver.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/theme-options.php';
require_once get_template_directory() . '/inc/meta-boxes.php';
require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/seed-content.php';
require_once get_template_directory() . '/inc/contact-form.php';

/**
 * This theme needs the Advanced Custom Fields plugin (free is enough; the
 * "Mídia do Site" screen is nicer with ACF PRO but works without it).
 */
function dec_require_acf_notice() {
    if (function_exists('acf') || !current_user_can('activate_plugins')) {
        return;
    }
    echo '<div class="notice notice-error"><p><strong>Tema Dr. Elie Cheniaux (ACF):</strong> instale e ative o plugin '
        . '<a href="' . esc_url(admin_url('plugin-install.php?s=advanced+custom+fields&tab=search&type=term')) . '">Advanced Custom Fields</a> '
        . 'para editar imagens, PDFs e os campos de Livros/Artigos/Entrevistas/Palestras.</p></div>';
}
add_action('admin_notices', 'dec_require_acf_notice');

/**
 * Theme setup.
 */
function dec_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('custom-logo');

    register_nav_menus(array(
        'primary' => __('Menu principal', 'dr-elie-cheniaux'),
        'outros_textos' => __('Outros Textos (submenu)', 'dr-elie-cheniaux'),
    ));
}
add_action('after_setup_theme', 'dec_setup');

/**
 * Assets.
 *
 * css/style.css (base) and js/script.js (base) load on every page, mirroring
 * the original static site. Each template additionally enqueues only the
 * stylesheet/script it actually needs.
 */
function dec_enqueue_assets() {
    wp_enqueue_style('dec-tailwind', get_template_directory_uri() . '/css/tailwind-build.css', array(), DEC_VERSION);
    wp_enqueue_style('dec-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap', array(), null);

    wp_enqueue_style('dec-base', get_template_directory_uri() . '/css/style.css', array(), DEC_VERSION);
    wp_enqueue_script('dec-base', get_template_directory_uri() . '/js/script.js', array(), DEC_VERSION, true);

    if (is_front_page()) {
        wp_enqueue_style('dec-index', get_template_directory_uri() . '/css/index.css', array('dec-base'), DEC_VERSION);
        wp_enqueue_script('dec-index-js', get_template_directory_uri() . '/js/index.js', array('dec-base'), DEC_VERSION, true);
    } elseif (is_singular('livro') || is_post_type_archive('livro')) {
        wp_enqueue_style('dec-livro', get_template_directory_uri() . '/css/livro-template.css', array('dec-base'), DEC_VERSION);
        if (is_singular('livro')) {
            wp_enqueue_script('dec-livro-js', get_template_directory_uri() . '/js/livro-template.js', array('dec-base'), DEC_VERSION, true);
        }
    } elseif (is_singular('entrevista') || is_post_type_archive('entrevista')) {
        wp_enqueue_style('dec-entrevista', get_template_directory_uri() . '/css/entrevista-template.css', array('dec-base'), DEC_VERSION);
    } elseif (is_post_type_archive('palestra') || is_singular('palestra')) {
        wp_enqueue_style('dec-palestras', get_template_directory_uri() . '/css/palestras.css', array('dec-base'), DEC_VERSION);
    } elseif (is_page_template('page-biografia.php')) {
        wp_enqueue_style('dec-biografia', get_template_directory_uri() . '/css/quem-sou-eu-biografia.css', array('dec-base'), DEC_VERSION);
    } elseif (is_page_template('page-curriculo.php')) {
        wp_enqueue_style('dec-curriculo', get_template_directory_uri() . '/css/quem-sou-eu-curriculo.css', array('dec-base'), DEC_VERSION);
        wp_enqueue_script('dec-curriculo-js', get_template_directory_uri() . '/js/quem-sou-eu-curriculo.js', array('dec-base'), DEC_VERSION, true);
    } elseif (is_page_template('page-discurso.php')) {
        wp_enqueue_style('dec-discurso', get_template_directory_uri() . '/css/quem-sou-eu-discurso.css', array('dec-base'), DEC_VERSION);
    } elseif (is_page_template('page-memorial.php')) {
        wp_enqueue_style('dec-memorial', get_template_directory_uri() . '/css/quem-sou-eu-memorial.css', array('dec-base'), DEC_VERSION);
        wp_enqueue_script('dec-memorial-js', get_template_directory_uri() . '/js/quem-sou-eu-memorial.js', array('dec-base'), DEC_VERSION, true);
    } elseif (is_page_template('page-bipolab.php')) {
        wp_enqueue_style('dec-bipolab', get_template_directory_uri() . '/css/BiPoLaB.css', array('dec-base'), DEC_VERSION);
        wp_enqueue_script('dec-bipolab-js', get_template_directory_uri() . '/js/BiPoLaB.js', array('dec-base'), DEC_VERSION, true);
    } elseif (is_page_template('page-encontros.php')) {
        wp_enqueue_style('dec-encontros', get_template_directory_uri() . '/css/Encontros.css', array('dec-base'), DEC_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'dec_enqueue_assets');

/**
 * Site icon fallback (favicon) using the existing logo asset.
 */
function dec_favicon() {
    if (has_site_icon()) {
        return;
    }
    $ico = get_template_directory_uri() . '/img/DrElieLogo.ico';
    echo '<link rel="shortcut icon" href="' . esc_url($ico) . '" />' . "\n";
}
add_action('wp_head', 'dec_favicon');

/**
 * Excerpt length / more string tweaks (used in card grids).
 */
function dec_excerpt_length($length) {
    return 24;
}
add_filter('excerpt_length', 'dec_excerpt_length');

function dec_excerpt_more($more) {
    return '…';
}
add_filter('excerpt_more', 'dec_excerpt_more');
