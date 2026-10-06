<?php
/**
 * Custom Post Types: livro, artigo, entrevista, palestra.
 */

if (!defined('ABSPATH')) {
    exit;
}

function dec_register_post_types() {

    register_post_type('livro', array(
        'labels' => array(
            'name' => __('Livros', 'dr-elie-cheniaux'),
            'singular_name' => __('Livro', 'dr-elie-cheniaux'),
            'add_new_item' => __('Adicionar novo livro', 'dr-elie-cheniaux'),
            'edit_item' => __('Editar livro', 'dr-elie-cheniaux'),
            'all_items' => __('Livros', 'dr-elie-cheniaux'),
            'search_items' => __('Buscar livros', 'dr-elie-cheniaux'),
            'not_found' => __('Nenhum livro encontrado', 'dr-elie-cheniaux'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'livros'),
        'menu_icon' => 'dashicons-book-alt',
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'show_in_rest' => true,
    ));

    register_post_type('artigo', array(
        'labels' => array(
            'name' => __('Artigos Científicos', 'dr-elie-cheniaux'),
            'singular_name' => __('Artigo', 'dr-elie-cheniaux'),
            'add_new_item' => __('Adicionar novo artigo', 'dr-elie-cheniaux'),
            'edit_item' => __('Editar artigo', 'dr-elie-cheniaux'),
            'all_items' => __('Artigos Científicos', 'dr-elie-cheniaux'),
            'search_items' => __('Buscar artigos', 'dr-elie-cheniaux'),
            'not_found' => __('Nenhum artigo encontrado', 'dr-elie-cheniaux'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'artigos-cientificos'),
        'menu_icon' => 'dashicons-media-document',
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'show_in_rest' => true,
    ));

    register_post_type('entrevista', array(
        'labels' => array(
            'name' => __('Entrevistas', 'dr-elie-cheniaux'),
            'singular_name' => __('Entrevista', 'dr-elie-cheniaux'),
            'add_new_item' => __('Adicionar nova entrevista', 'dr-elie-cheniaux'),
            'edit_item' => __('Editar entrevista', 'dr-elie-cheniaux'),
            'all_items' => __('Entrevistas', 'dr-elie-cheniaux'),
            'search_items' => __('Buscar entrevistas', 'dr-elie-cheniaux'),
            'not_found' => __('Nenhuma entrevista encontrada', 'dr-elie-cheniaux'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'entrevistas'),
        'menu_icon' => 'dashicons-microphone',
        'supports' => array('title', 'excerpt', 'thumbnail', 'revisions'),
        'show_in_rest' => true,
    ));

    register_post_type('palestra', array(
        'labels' => array(
            'name' => __('Palestras', 'dr-elie-cheniaux'),
            'singular_name' => __('Palestra', 'dr-elie-cheniaux'),
            'add_new_item' => __('Adicionar nova palestra', 'dr-elie-cheniaux'),
            'edit_item' => __('Editar palestra', 'dr-elie-cheniaux'),
            'all_items' => __('Palestras', 'dr-elie-cheniaux'),
            'search_items' => __('Buscar palestras', 'dr-elie-cheniaux'),
            'not_found' => __('Nenhuma palestra encontrada', 'dr-elie-cheniaux'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'palestras'),
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'excerpt', 'thumbnail', 'revisions'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'dec_register_post_types');

/**
 * "tipo" taxonomy for entrevista (jornal / tv / podcast) and "categoria" for
 * the filter pills (ex: TV Aberta, Cultura, 2024...).
 */
function dec_register_taxonomies() {
    register_taxonomy('entrevista_tipo', 'entrevista', array(
        'labels' => array(
            'name' => __('Tipo', 'dr-elie-cheniaux'),
            'singular_name' => __('Tipo', 'dr-elie-cheniaux'),
        ),
        'public' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'entrevistas'),
    ));

    register_taxonomy('entrevista_filtro', 'entrevista', array(
        'labels' => array(
            'name' => __('Filtro', 'dr-elie-cheniaux'),
            'singular_name' => __('Filtro', 'dr-elie-cheniaux'),
        ),
        'public' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
    ));
}
add_action('init', 'dec_register_taxonomies');

/**
 * Flush rewrite rules once after the CPTs are registered (theme activation).
 */
function dec_flush_rewrites() {
    dec_register_post_types();
    dec_register_taxonomies();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'dec_flush_rewrites');
