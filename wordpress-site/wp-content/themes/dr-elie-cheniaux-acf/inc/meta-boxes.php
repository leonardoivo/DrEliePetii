<?php
/**
 * In the ACF theme every custom field is handled by ACF (see inc/acf-fields.php).
 *
 * The only thing left here is the Entrevista "Tipo" (jornal / tv / podcast) and
 * "Filtro" taxonomy box — kept as plain WP so the archive queries keep working
 * exactly as before.
 */

if (!defined('ABSPATH')) {
    exit;
}

function dec_add_meta_boxes() {
    add_meta_box('dec_entrevista_tax', 'Classificação da Entrevista', 'dec_render_entrevista_tax_box', 'entrevista', 'side', 'default');
}
add_action('add_meta_boxes', 'dec_add_meta_boxes');

function dec_render_entrevista_tax_box($post) {
    wp_nonce_field('dec_save_meta', 'dec_meta_nonce');

    $options = array('jornais' => 'Jornal', 'tv' => 'TV', 'podcast' => 'Podcast');
    $current = wp_get_post_terms($post->ID, 'entrevista_tipo', array('fields' => 'slugs'));
    $current = !is_wp_error($current) && !empty($current) ? $current[0] : '';

    echo '<p><strong>Tipo</strong><br>';
    foreach ($options as $slug => $label) {
        printf(
            '<label style="display:block;margin:4px 0;"><input type="radio" name="entrevista_tipo" value="%s" %s /> %s</label>',
            esc_attr($slug),
            checked($current, $slug, false),
            esc_html($label)
        );
    }
    echo '</p>';

    $terms = wp_get_post_terms($post->ID, 'entrevista_filtro', array('fields' => 'names'));
    $val = !is_wp_error($terms) && !empty($terms) ? $terms[0] : '';
    echo '<p><label for="entrevista_filtro_input"><strong>Filtro</strong> (categoria do botão de filtro, ex: aberta, cultura, 2024)</label><br>';
    echo '<input type="text" id="entrevista_filtro_input" name="entrevista_filtro_input" value="' . esc_attr($val) . '" style="width:100%;" /></p>';
}

function dec_save_meta_boxes($post_id) {
    if (!isset($_POST['dec_meta_nonce']) || !wp_verify_nonce($_POST['dec_meta_nonce'], 'dec_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id) || get_post_type($post_id) !== 'entrevista') {
        return;
    }
    if (isset($_POST['entrevista_tipo'])) {
        wp_set_post_terms($post_id, array(sanitize_text_field(wp_unslash($_POST['entrevista_tipo']))), 'entrevista_tipo', false);
    }
    if (isset($_POST['entrevista_filtro_input']) && $_POST['entrevista_filtro_input'] !== '') {
        wp_set_post_terms($post_id, array(sanitize_text_field(wp_unslash($_POST['entrevista_filtro_input']))), 'entrevista_filtro', false);
    }
}
add_action('save_post', 'dec_save_meta_boxes');
