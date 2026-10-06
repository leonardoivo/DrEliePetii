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
        'supports' => array('title', 'thumbnail', 'revisions'),
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

    register_post_type('encontro', array(
        'labels' => array(
            'name' => __('Encontros Especiais', 'dr-elie-cheniaux'),
            'singular_name' => __('Foto de Encontro', 'dr-elie-cheniaux'),
            'add_new_item' => __('Adicionar nova foto', 'dr-elie-cheniaux'),
            'edit_item' => __('Editar foto', 'dr-elie-cheniaux'),
            'all_items' => __('Encontros Especiais', 'dr-elie-cheniaux'),
            'search_items' => __('Buscar fotos', 'dr-elie-cheniaux'),
            'not_found' => __('Nenhuma foto encontrada', 'dr-elie-cheniaux'),
        ),
        // Not a standalone public post type: no single page/archive of its
        // own. It only feeds the "Encontros Especiais" gallery on the home
        // page and on page-encontros.php, but is fully manageable from the
        // admin menu ("Encontros Especiais" > Adicionar nova foto). The
        // post title becomes the photo caption; the featured image is the
        // photo itself.
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-camera',
        'supports' => array('title', 'thumbnail', 'page-attributes'),
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

/**
 * One-time migration: turns the old hardcoded "Encontros Especiais" photo
 * list (theme_mod 'dec_encontros_preview', or the fallback list bundled in
 * inc/seed-content.php if that theme_mod was never set) into real
 * "encontro" posts, so photos become addable/removable/reorderable from
 * the admin ("Encontros Especiais" in the sidebar) instead of requiring a
 * code change. Runs once; safe to leave in place after that.
 */
function dec_migrate_encontros_to_cpt() {
    if (get_option('dec_encontros_migrated')) {
        return;
    }

    $already = get_posts(array(
        'post_type' => 'encontro',
        'post_status' => 'any',
        'posts_per_page' => 1,
        'fields' => 'ids',
    ));
    if (!empty($already)) {
        update_option('dec_encontros_migrated', 1);
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $imgs = get_theme_mod('dec_encontros_preview', array());
    if (empty($imgs) && function_exists('dec_default_encontros_data')) {
        $imgs = dec_default_encontros_data();
    }

    $order = 0;
    foreach ($imgs as $img) {
        if (empty($img['src'])) {
            continue;
        }
        $caption = pathinfo($img['src'], PATHINFO_FILENAME);
        $attach_id = dec_import_theme_image($img['src'], $caption);
        if (!$attach_id) {
            continue;
        }
        $post_id = wp_insert_post(array(
            'post_type' => 'encontro',
            'post_title' => $caption,
            'post_status' => 'publish',
            'menu_order' => $order++,
        ));
        if ($post_id && !is_wp_error($post_id)) {
            set_post_thumbnail($post_id, $attach_id);
        }
    }

    update_option('dec_encontros_migrated', 1);
}
add_action('init', 'dec_migrate_encontros_to_cpt', 20);

/**
 * One-time setup: creates an editable "Menu Principal" nav menu pre-filled
 * with the site's current navigation and assigns it to the "primary"
 * location, so an editor can go to Aparência → Menus and change it,
 * instead of the menu being fixed in code. Skipped if a menu is already
 * assigned to "primary" (e.g. an editor already set one up).
 */
function dec_create_default_primary_menu() {
    if (get_option('dec_primary_menu_created')) {
        return;
    }

    $locations = get_nav_menu_locations();
    if (!empty($locations['primary'])) {
        update_option('dec_primary_menu_created', 1);
        return;
    }

    if (!function_exists('dec_page_url')) {
        return; // template-tags.php not loaded yet; try again next request.
    }

    $menu_id = wp_create_nav_menu('Menu Principal');
    if (is_wp_error($menu_id)) {
        return;
    }

    $items = array(
        array('label' => 'Quem sou eu', 'url' => dec_page_url('biografia'), 'children' => array(
            array('label' => 'Biografia', 'url' => dec_page_url('biografia')),
            array('label' => 'BiPoLaB', 'url' => dec_page_url('bipolab')),
            array('label' => 'Currículo Lattes', 'url' => dec_page_url('curriculo')),
            array('label' => 'Discurso de posse na AMRJ', 'url' => dec_page_url('discurso')),
            array('label' => 'Memorial', 'url' => dec_page_url('memorial')),
        )),
        array('label' => 'Livros', 'url' => (string) get_post_type_archive_link('livro'), 'children' => array()),
        array('label' => 'Artigos científicos', 'url' => (string) get_post_type_archive_link('artigo'), 'children' => array()),
        array('label' => 'Entrevistas', 'url' => (string) get_post_type_archive_link('entrevista'), 'children' => array(
            array('label' => 'Jornais', 'url' => add_query_arg('tipo', 'jornais', get_post_type_archive_link('entrevista'))),
            array('label' => 'TV', 'url' => add_query_arg('tipo', 'tv', get_post_type_archive_link('entrevista'))),
            array('label' => 'Podcast', 'url' => add_query_arg('tipo', 'podcast', get_post_type_archive_link('entrevista'))),
        )),
        array('label' => 'Palestras', 'url' => (string) get_post_type_archive_link('palestra'), 'children' => array()),
        array('label' => 'Encontros especiais', 'url' => dec_page_url('encontros'), 'children' => array(
            array('label' => 'Fotos', 'url' => dec_page_url('encontros')),
        )),
        array('label' => 'Redes Sociais', 'url' => '#', 'children' => array(
            array('label' => 'Facebook', 'url' => 'https://www.facebook.com/elie.cheniaux'),
            array('label' => 'Instagram', 'url' => 'https://www.instagram.com/eliecheniaux'),
            array('label' => 'X', 'url' => 'https://x.com/CheniauxElie'),
            array('label' => 'YouTube', 'url' => 'https://www.youtube.com/@echeniaux'),
        )),
        array('label' => 'Blog', 'url' => 'https://eliecheniaux.blogspot.com/', 'children' => array()),
        array('label' => 'Outros textos', 'url' => '#', 'children' => array(
            array('label' => 'críticos.com', 'url' => 'https://criticos.com.br/?p=12181&cat=4'),
        )),
    );

    $position = 1;
    foreach ($items as $item) {
        $parent_id = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $item['label'],
            'menu-item-url' => $item['url'],
            'menu-item-status' => 'publish',
            'menu-item-position' => $position++,
        ));
        foreach ($item['children'] as $child) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => $child['label'],
                'menu-item-url' => $child['url'],
                'menu-item-status' => 'publish',
                'menu-item-parent-id' => $parent_id,
                'menu-item-position' => $position++,
            ));
        }
    }

    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);

    update_option('dec_primary_menu_created', 1);
}
add_action('init', 'dec_create_default_primary_menu', 20);

/**
 * One-time migration: existing "artigo" posts store their PDF as a plain
 * filename (meta 'artigo_pdf'), expected to already sit in the theme's
 * /pdf/ folder — which meant adding a new article's PDF required FTP
 * access. This imports each existing PDF into the Media Library and
 * replaces the meta value with the resulting attachment ID, matching the
 * new upload button in the admin editor (inc/meta-boxes.php).
 */
function dec_migrate_artigo_pdfs_to_media() {
    if (get_option('dec_artigo_pdfs_migrated')) {
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $artigos = get_posts(array(
        'post_type' => 'artigo',
        'post_status' => 'any',
        'posts_per_page' => -1,
        'fields' => 'ids',
    ));

    foreach ($artigos as $artigo_id) {
        $pdf_meta = get_post_meta($artigo_id, 'artigo_pdf', true);
        if (empty($pdf_meta) || ctype_digit((string) $pdf_meta)) {
            continue; // already empty or already an attachment ID.
        }
        if (!function_exists('dec_import_theme_file')) {
            continue; // seed-content.php not loaded yet; try again next request.
        }
        $attach_id = dec_import_theme_file($pdf_meta, 'pdf', pathinfo($pdf_meta, PATHINFO_FILENAME));
        if ($attach_id) {
            update_post_meta($artigo_id, 'artigo_pdf', $attach_id);
        }
    }

    update_option('dec_artigo_pdfs_migrated', 1);
}
add_action('init', 'dec_migrate_artigo_pdfs_to_media', 20);
