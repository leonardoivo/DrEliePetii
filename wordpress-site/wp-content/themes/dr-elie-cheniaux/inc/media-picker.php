<?php
/**
 * Reusable "pick from the Media Library" field + value resolver.
 *
 * A stored media value can be one of three things, in order of preference:
 *   1. an attachment ID (what the picker saves from now on)
 *   2. a full URL (old `livro_capa_alt` values, or anything pasted by hand)
 *   3. a bare filename that still lives in the theme's /img or /pdf folder
 *      (every value that existed before this feature)
 *
 * Templates never care which one it is — they call dec_media_url() / dec_media_img().
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Resolve a stored media value to a usable URL.
 *
 * @param mixed  $value      Attachment ID, URL or legacy filename.
 * @param string $legacy_dir Theme sub-folder a legacy filename lives in ('img' or 'pdf').
 * @return string Empty string when nothing is set / the attachment is gone.
 */
function dec_media_url($value, $legacy_dir = 'img') {
    if (is_array($value)) {
        $value = reset($value);
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

/**
 * Resolve a media value to array($url, $alt) for <img> output.
 */
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

/**
 * First non-empty resolved URL from a list of candidates. Handy for
 * "custom value, else featured image, else bundled default" chains.
 */
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
 * Reads the new option first, then falls back to the old theme_mod so nothing
 * disappears before the editor opens the new screen.
 */
function dec_encontros_imgs($post_id = null) {
    $out = array();

    // 1. the "Encontros Especiais" page's own gallery (edited right on that page)
    if ($post_id === null) {
        $page = get_page_by_path('encontros');
        $post_id = $page ? $page->ID : 0;
    }
    $ids = $post_id ? get_post_meta($post_id, 'dec_encontros_galeria', true) : '';

    // 2. fall back to the global "Mídia do Site" gallery
    if (empty($ids) || !is_array($ids)) {
        $ids = dec_opt('encontros_galeria', array());
    }

    if (!empty($ids) && is_array($ids)) {
        foreach ($ids as $id) {
            $url = wp_get_attachment_url((int) $id);
            if (!$url) {
                continue;
            }
            $caption = get_the_title((int) $id);
            $out[] = array('url' => $url, 'caption' => $caption);
        }
        if ($out) {
            return $out;
        }
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

/* -------------------------------------------------------------------------
 * Admin UI
 * ---------------------------------------------------------------------- */

/**
 * Renders a single "Selecionar imagem / arquivo" control.
 *
 * @param string $name  Form field name (e.g. 'livro_capa_home' or 'dec_site_media[foto_principal]').
 * @param mixed  $value Current stored value.
 * @param string $type  'image' | 'file'
 */
function dec_media_picker_field($name, $value, $type = 'image') {
    $is_image  = ($type !== 'file');
    $legacy    = $is_image ? 'img' : 'pdf';
    $url       = dec_media_url($value, $legacy);
    $field_id  = 'dec-mp-' . preg_replace('/[^a-z0-9_-]/i', '-', $name) . '-' . wp_rand(1000, 9999);
    $btn_label = $is_image ? 'Selecionar imagem' : 'Selecionar arquivo';
    ?>
    <div class="dec-media-picker" data-type="<?php echo esc_attr($is_image ? 'image' : 'file'); ?>">
        <input type="hidden" class="dec-media-value" id="<?php echo esc_attr($field_id); ?>"
               name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr(is_array($value) ? '' : $value); ?>">
        <div class="dec-media-preview">
            <?php if ($url && $is_image) : ?>
                <img src="<?php echo esc_url($url); ?>" alt="">
            <?php elseif ($url) : ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">📄 <?php echo esc_html(basename(wp_parse_url($url, PHP_URL_PATH))); ?></a>
            <?php endif; ?>
        </div>
        <p class="dec-media-actions">
            <button type="button" class="button dec-media-select"><?php echo esc_html($btn_label); ?></button>
            <button type="button" class="button-link dec-media-remove"<?php echo $url ? '' : ' style="display:none;"'; ?>>Remover</button>
        </p>
    </div>
    <?php
}

/**
 * Repeatable image list (used by the Encontros gallery on the options page).
 *
 * @param string $name  Base form name; each image is posted as $name . '[]'.
 * @param array  $ids   Current attachment IDs.
 */
function dec_media_repeater_field($name, $ids) {
    ?>
    <div class="dec-repeater" data-name="<?php echo esc_attr($name); ?>">
        <ul class="dec-repeater-list">
            <?php foreach ((array) $ids as $id) :
                $thumb = wp_get_attachment_image_url((int) $id, 'thumbnail');
                if (!$thumb) {
                    continue;
                }
                ?>
                <li class="dec-repeater-item">
                    <img src="<?php echo esc_url($thumb); ?>" alt="">
                    <input type="hidden" name="<?php echo esc_attr($name); ?>[]" value="<?php echo esc_attr((int) $id); ?>">
                    <button type="button" class="button-link dec-repeater-remove">Remover</button>
                </li>
            <?php endforeach; ?>
        </ul>
        <p><button type="button" class="button dec-repeater-add">Adicionar fotos</button></p>
    </div>
    <?php
}

/**
 * Load wp.media + our wiring on the post editor and the "Mídia do Site" screen.
 */
function dec_admin_media_assets($hook) {
    $allowed = array('post.php', 'post-new.php', 'appearance_page_dec-site-media');
    if (!in_array($hook, $allowed, true)) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script(
        'dec-admin-media',
        get_template_directory_uri() . '/js/admin-media.js',
        array('jquery', 'jquery-ui-sortable'),
        defined('DEC_VERSION') ? DEC_VERSION : false,
        true
    );
    wp_add_inline_style('wp-admin', dec_admin_media_css());
}
add_action('admin_enqueue_scripts', 'dec_admin_media_assets');

function dec_admin_media_css() {
    return '
    .dec-media-preview img{max-width:180px;max-height:180px;display:block;border:1px solid #dcdcde;border-radius:4px}
    .dec-media-preview{margin-bottom:6px}
    .dec-media-actions{margin:4px 0 0}
    .dec-repeater-list{display:flex;flex-wrap:wrap;gap:10px;margin:0 0 10px;padding:0;list-style:none}
    .dec-repeater-item{position:relative;width:110px;text-align:center}
    .dec-repeater-item img{width:110px;height:90px;object-fit:cover;display:block;border:1px solid #dcdcde;border-radius:4px}
    .dec-repeater-item .dec-repeater-remove{color:#b32d2e;font-size:11px}
    .dec-repeater-item{cursor:move}
    .dec-site-media-section{background:#fff;border:1px solid #c3c4c7;border-radius:4px;padding:4px 20px 16px;margin:0 0 22px;max-width:820px}
    .dec-site-media-section h2{font-size:14px;margin:16px 0 4px}
    ';
}

/* -------------------------------------------------------------------------
 * "Galeria de fotos" box shown right on the Encontros Especiais page.
 * Stored in the page meta `dec_encontros_galeria` (array of attachment IDs),
 * which dec_encontros_imgs() reads before anything else.
 * ---------------------------------------------------------------------- */
function dec_encontros_gallery_box($post_type, $post) {
    if ($post_type !== 'page' || get_page_template_slug($post->ID) !== 'page-encontros.php') {
        return;
    }
    add_meta_box(
        'dec_encontros_galeria_box',
        'Galeria de fotos — Encontros Especiais',
        'dec_render_encontros_gallery_box',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'dec_encontros_gallery_box', 10, 2);

function dec_render_encontros_gallery_box($post) {
    wp_nonce_field('dec_encontros_gallery', 'dec_encontros_gallery_nonce');
    $ids = get_post_meta($post->ID, 'dec_encontros_galeria', true);
    echo '<p class="description" style="margin:4px 0 12px;">Estas fotos aparecem na página, <strong>abaixo do cabeçalho verde</strong>. As 4 primeiras aparecem também na página inicial. Adicione várias de uma vez e arraste para reordenar. A legenda de cada foto é o <em>título</em> do anexo na Biblioteca de Mídia.</p>';
    dec_media_repeater_field('dec_encontros_galeria', is_array($ids) ? $ids : array());
}

function dec_save_encontros_gallery($post_id) {
    if (!isset($_POST['dec_encontros_gallery_nonce']) || !wp_verify_nonce($_POST['dec_encontros_gallery_nonce'], 'dec_encontros_gallery')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $raw = isset($_POST['dec_encontros_galeria']) ? (array) wp_unslash($_POST['dec_encontros_galeria']) : array();
    $ids = array_values(array_unique(array_filter(array_map('absint', $raw))));
    if ($ids) {
        update_post_meta($post_id, 'dec_encontros_galeria', $ids);
    } else {
        delete_post_meta($post_id, 'dec_encontros_galeria');
    }
}
add_action('save_post', 'dec_save_encontros_gallery');
