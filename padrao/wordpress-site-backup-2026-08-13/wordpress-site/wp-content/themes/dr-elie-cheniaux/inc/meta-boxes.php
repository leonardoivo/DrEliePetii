<?php
/**
 * Native (no-plugin) meta boxes for the custom post types.
 */

if (!defined('ABSPATH')) {
    exit;
}

/* --------------------------------------------------------------------
 * Field maps: post_type => [ meta_key => [ label, type ] ]
 * type: text | textarea | url | color
 * ------------------------------------------------------------------ */
function dec_meta_fields($post_type) {
    $fields = array(
        'livro' => array(
            'livro_autor'          => array('Autor(es)', 'text'),
            'livro_subtitulo'      => array('Subtítulo (opcional, aparece abaixo do título)', 'text'),
            'livro_tagline'        => array('Frase de efeito (subtítulo do herói)', 'textarea'),
            'livro_ano'            => array('Ano', 'text'),
            'livro_paginas'        => array('Páginas', 'text'),
            'livro_editora'        => array('Editora', 'text'),
            'livro_idioma'         => array('Idioma', 'text'),
            'livro_formato'        => array('Formato', 'text'),
            'livro_genero'         => array('Gênero (separado por vírgula)', 'text'),
            'livro_accent'         => array('Cor de destaque', 'color'),
            'livro_accent_light'   => array('Cor de destaque (clara)', 'color'),
            'livro_accent_dark'    => array('Cor de destaque (escura)', 'color'),
            'livro_capa_alt'       => array('Capa alternativa (URL da imagem)', 'url'),
            'livro_capa_home'      => array('Capa na lista da página inicial (opcional, nome do arquivo em /img/ do tema — se vazio, usa a capa principal)', 'text'),
            'livro_endorsement'    => array('Selo/endosso curto (ex: "Prefácio de Fulano")', 'text'),
            'livro_tema_titulo'    => array('Título da lista de temas/filmes (opcional)', 'text'),
            'livro_tema_lista'     => array('Temas/filmes (separado por vírgula)', 'textarea'),
            'livro_pull_quote'     => array('Citação de destaque', 'textarea'),
            'livro_pull_attr'      => array('Atribuição da citação', 'text'),
            'livro_prefacio_nome'  => array('Prefácio — nome do prefaciador', 'text'),
            'livro_prefacio_cargo' => array('Prefácio — cargo/ocupação', 'text'),
            'livro_prefacio_extra' => array('Prefácio — linha extra (obras, etc.)', 'text'),
            'livro_prefacio_texto' => array('Prefácio — texto completo', 'textarea'),
            'livro_prefacio2_nome'  => array('Segundo Prefácio (opcional) — nome do prefaciador', 'text'),
            'livro_prefacio2_cargo' => array('Segundo Prefácio — cargo/ocupação', 'text'),
            'livro_prefacio2_extra' => array('Segundo Prefácio — linha extra (obras, etc.)', 'text'),
            'livro_prefacio2_texto' => array('Segundo Prefácio — texto completo', 'textarea'),
            'livro_prefacio3_nome'  => array('Terceiro Prefácio (opcional) — nome do prefaciador', 'text'),
            'livro_prefacio3_cargo' => array('Terceiro Prefácio — cargo/ocupação', 'text'),
            'livro_prefacio3_extra' => array('Terceiro Prefácio — linha extra (obras, etc.)', 'text'),
            'livro_prefacio3_texto' => array('Terceiro Prefácio — texto completo', 'textarea'),
            'livro_resenha_texto'   => array('Resenha — texto completo', 'textarea'),
            'livro_resenha_autores' => array('Resenha — autores da resenha, um por linha: Nome | Bio', 'textarea'),
            'livro_compradores'    => array('Onde comprar — uma loja por linha: Nome | URL | Cor (#hex) | Selo | Descrição', 'textarea'),
            'livro_ctas'           => array('Banners de chamada — um por linha: Título | Texto | Texto do botão | URL do botão', 'textarea'),
        ),
        'artigo' => array(
            'artigo_pdf' => array('Arquivo PDF (nome do arquivo dentro da pasta pdf/ do tema)', 'text'),
        ),
        'entrevista' => array(
            'entrevista_veiculo' => array('Veículo (ex: TV Globo, Folha de S.Paulo)', 'text'),
            'entrevista_link'    => array('Link externo', 'url'),
            'entrevista_data'    => array('Data/Ano', 'text'),
        ),
        'palestra' => array(
            'palestra_link' => array('Link do vídeo (YouTube, Vimeo, etc. — deixe em branco para exibir como foto no topo da página)', 'url'),
        ),
    );
    return isset($fields[$post_type]) ? $fields[$post_type] : array();
}

function dec_add_meta_boxes() {
    $titles = array(
        'livro' => 'Detalhes do Livro',
        'artigo' => 'Arquivo do Artigo',
        'entrevista' => 'Detalhes da Entrevista',
        'palestra' => 'Detalhes da Palestra',
    );
    foreach ($titles as $post_type => $title) {
        add_meta_box('dec_' . $post_type . '_meta', $title, 'dec_render_meta_box', $post_type, 'normal', 'high');
    }
}
add_action('add_meta_boxes', 'dec_add_meta_boxes');

function dec_render_meta_box($post) {
    $fields = dec_meta_fields($post->post_type);
    wp_nonce_field('dec_save_meta', 'dec_meta_nonce');
    echo '<table class="form-table"><tbody>';
    foreach ($fields as $key => $def) {
        list($label, $type) = $def;
        $value = get_post_meta($post->ID, $key, true);
        echo '<tr><th style="width:280px;"><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
        if ($type === 'textarea') {
            echo '<textarea id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" rows="4" style="width:100%;">' . esc_textarea($value) . '</textarea>';
        } elseif ($type === 'color') {
            echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" placeholder="#1a4427" style="width:140px;" />';
        } elseif ($type === 'url') {
            echo '<input type="url" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" style="width:100%;" />';
        } else {
            echo '<input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" style="width:100%;" />';
        }
        echo '</td></tr>';
    }
    echo '</tbody></table>';

    if ($post->post_type === 'entrevista') {
        dec_render_taxonomy_radio($post, 'entrevista_tipo', 'Tipo', array('jornais' => 'Jornal', 'tv' => 'TV', 'podcast' => 'Podcast'));
        echo '<p><label for="entrevista_filtro_input"><strong>Filtro (categoria do botão de filtro, ex: aberta, cultura, 2024)</strong></label><br>';
        $terms = wp_get_post_terms($post->ID, 'entrevista_filtro', array('fields' => 'names'));
        $val = !is_wp_error($terms) && !empty($terms) ? $terms[0] : '';
        echo '<input type="text" id="entrevista_filtro_input" name="entrevista_filtro_input" value="' . esc_attr($val) . '" style="width:100%;max-width:400px;" /></p>';
    }
}

function dec_render_taxonomy_radio($post, $taxonomy, $label, $options) {
    $current = wp_get_post_terms($post->ID, $taxonomy, array('fields' => 'slugs'));
    $current = !is_wp_error($current) && !empty($current) ? $current[0] : '';
    echo '<p><strong>' . esc_html($label) . '</strong><br>';
    foreach ($options as $slug => $opt_label) {
        printf(
            '<label style="margin-right:16px;"><input type="radio" name="%1$s" value="%2$s" %3$s /> %4$s</label>',
            esc_attr($taxonomy),
            esc_attr($slug),
            checked($current, $slug, false),
            esc_html($opt_label)
        );
    }
    echo '</p>';
}

function dec_save_meta_boxes($post_id) {
    if (!isset($_POST['dec_meta_nonce']) || !wp_verify_nonce($_POST['dec_meta_nonce'], 'dec_save_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    $post_type = get_post_type($post_id);
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = dec_meta_fields($post_type);
    foreach ($fields as $key => $def) {
        if (isset($_POST[$key])) {
            $type = $def[1];
            $raw = wp_unslash($_POST[$key]);
            $clean = ($type === 'textarea') ? sanitize_textarea_field($raw) : sanitize_text_field($raw);
            update_post_meta($post_id, $key, $clean);
        }
    }

    if ($post_type === 'entrevista') {
        if (isset($_POST['entrevista_tipo'])) {
            wp_set_post_terms($post_id, array(sanitize_text_field($_POST['entrevista_tipo'])), 'entrevista_tipo', false);
        }
        if (isset($_POST['entrevista_filtro_input']) && $_POST['entrevista_filtro_input'] !== '') {
            wp_set_post_terms($post_id, array(sanitize_text_field($_POST['entrevista_filtro_input'])), 'entrevista_filtro', false);
        }
    }
}
add_action('save_post', 'dec_save_meta_boxes');
