<?php
/**
 * All custom fields, registered in code via ACF's local field groups.
 *
 * Nothing to click in the ACF UI — activate the plugin and the groups appear
 * on the right post types (and on Aparência → Mídia do Site for the globals).
 *
 * Field NAMES are kept identical to the meta keys the templates already read
 * with get_post_meta() / dec_opt(), and image/file/gallery fields return the
 * attachment ID, so the template files are byte-for-byte the same as the
 * plugin-free theme.
 */

if (!defined('ABSPATH')) {
    exit;
}

/** Slug of the private Page that carries the global media fields (ACF-free path). */
if (!defined('DEC_MEDIA_PAGE_SLUG')) {
    define('DEC_MEDIA_PAGE_SLUG', 'dec-midia-do-site');
}

/**
 * One ACF field definition from a short spec.
 *
 * @param string $name  Field name = meta key.
 * @param string $label Admin label.
 * @param string $type  text|textarea|url|color|image|file|select|number|gallery
 * @param array  $extra Extra ACF keys (choices, default_value, instructions, ...).
 */
function dec_acf_f($name, $label, $type = 'text', $extra = array()) {
    $map = array(
        'text'     => array('type' => 'text'),
        'textarea' => array('type' => 'textarea', 'rows' => 4),
        'url'      => array('type' => 'url'),
        'color'    => array('type' => 'color_picker'),
        'number'   => array('type' => 'number'),
        'image'    => array('type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all'),
        'file'     => array('type' => 'file', 'return_format' => 'id', 'library' => 'all', 'mime_types' => 'pdf'),
        'gallery'  => array('type' => 'gallery', 'return_format' => 'id', 'insert' => 'append'),
        'select'   => array('type' => 'select', 'ui' => 1),
    );
    $base = isset($map[$type]) ? $map[$type] : $map['text'];
    return array_merge(array(
        'key'   => 'field_dec_' . $name,
        'label' => $label,
        'name'  => $name,
    ), $base, $extra);
}

/**
 * post_type => list of dec_acf_f() specs.  Mirrors dec_meta_fields() from the
 * plugin-free theme so the two stay in sync.
 */
function dec_acf_post_field_map() {
    $toolbar_choices = array('sim' => 'Mostrar', 'nao' => 'Ocultar');
    $pos_choices     = array('depois' => 'Depois do texto', 'antes' => 'Antes do texto');

    return array(
        'livro' => array(
            dec_acf_f('livro_autor', 'Autor(es)'),
            dec_acf_f('livro_subtitulo', 'Subtítulo (opcional, aparece abaixo do título)'),
            dec_acf_f('livro_tagline', 'Frase de efeito (subtítulo do herói)', 'textarea'),
            dec_acf_f('livro_ano', 'Ano'),
            dec_acf_f('livro_paginas', 'Páginas'),
            dec_acf_f('livro_editora', 'Editora'),
            dec_acf_f('livro_idioma', 'Idioma'),
            dec_acf_f('livro_formato', 'Formato'),
            dec_acf_f('livro_genero', 'Gênero (separado por vírgula)'),
            dec_acf_f('livro_accent', 'Cor de destaque', 'color'),
            dec_acf_f('livro_accent_light', 'Cor de destaque (clara)', 'color'),
            dec_acf_f('livro_accent_dark', 'Cor de destaque (escura)', 'color'),
            dec_acf_f('livro_capa_alt', 'Capa alternativa (barra lateral da sinopse)', 'image'),
            dec_acf_f('livro_capa_home', 'Capa para as listagens. Se vazio, usa a Imagem destacada.', 'image'),
            dec_acf_f('livro_capa_hero', 'Capa grande no topo da página do livro. Se vazio, usa a das listagens.', 'image'),
            dec_acf_f('livro_endorsement', 'Selo/endosso curto (ex: "Prefácio de Fulano")'),
            dec_acf_f('livro_tema_titulo', 'Título da lista de temas/filmes (opcional)'),
            dec_acf_f('livro_tema_lista', 'Temas/filmes (separado por vírgula)', 'textarea'),
            dec_acf_f('livro_pull_quote', 'Citação de destaque', 'textarea'),
            dec_acf_f('livro_pull_attr', 'Atribuição da citação'),
            dec_acf_f('livro_prefacio_nome', 'Prefácio — nome do prefaciador'),
            dec_acf_f('livro_prefacio_cargo', 'Prefácio — cargo/ocupação'),
            dec_acf_f('livro_prefacio_extra', 'Prefácio — linha extra (obras, etc.)'),
            dec_acf_f('livro_prefacio_texto', 'Prefácio — texto completo', 'textarea'),
            dec_acf_f('livro_prefacio2_nome', 'Segundo Prefácio (opcional) — nome'),
            dec_acf_f('livro_prefacio2_cargo', 'Segundo Prefácio — cargo/ocupação'),
            dec_acf_f('livro_prefacio2_extra', 'Segundo Prefácio — linha extra'),
            dec_acf_f('livro_prefacio2_texto', 'Segundo Prefácio — texto completo', 'textarea'),
            dec_acf_f('livro_prefacio3_nome', 'Terceiro Prefácio (opcional) — nome'),
            dec_acf_f('livro_prefacio3_cargo', 'Terceiro Prefácio — cargo/ocupação'),
            dec_acf_f('livro_prefacio3_extra', 'Terceiro Prefácio — linha extra'),
            dec_acf_f('livro_prefacio3_texto', 'Terceiro Prefácio — texto completo', 'textarea'),
            dec_acf_f('livro_resenha_texto', 'Resenha — texto completo', 'textarea'),
            dec_acf_f('livro_resenha_autores', 'Resenha — autores, um por linha: Nome | Bio', 'textarea'),
            dec_acf_f('livro_compradores', 'Onde comprar — por linha: Nome | URL | Cor | Selo | Descrição', 'textarea'),
            dec_acf_f('livro_ctas', 'Banners de chamada — por linha: Título | Texto | Texto botão | URL', 'textarea'),
        ),
        'artigo' => array(
            dec_acf_f('artigo_pdf', 'Arquivo PDF do artigo', 'file'),
            dec_acf_f('artigo_pdf_altura', 'Altura do visualizador de PDF (px, padrão 700)', 'number', array('default_value' => 700, 'min' => 200, 'max' => 2000, 'step' => 10)),
            dec_acf_f('artigo_pdf_toolbar', 'Barra de ferramentas do PDF', 'select', array('choices' => $toolbar_choices, 'default_value' => 'sim')),
            dec_acf_f('artigo_pdf_posicao', 'Posição do PDF em relação ao texto', 'select', array('choices' => $pos_choices, 'default_value' => 'depois')),
        ),
        'entrevista' => array(
            dec_acf_f('entrevista_veiculo', 'Veículo (ex: TV Globo, Folha de S.Paulo)'),
            dec_acf_f('entrevista_link', 'Link externo', 'url'),
            dec_acf_f('entrevista_data', 'Data/Ano'),
        ),
        'palestra' => array(
            dec_acf_f('palestra_link', 'Link do vídeo (YouTube, Vimeo…). Em branco = foto no topo.', 'url'),
        ),
    );
}

/**
 * The site-wide media (everything that used to be a hard-coded filename).
 * Grouped with ACF tabs so the "Mídia do Site" screen stays readable.
 */
function dec_acf_site_media_fields() {
    $toolbar_choices = array('sim' => 'Mostrar', 'nao' => 'Ocultar');
    $pos_choices     = array('depois' => 'Depois do texto', 'antes' => 'Antes do texto');

    return array(
        array('key' => 'field_dec_tab_geral', 'label' => 'Início e Biografia', 'type' => 'tab'),
        dec_acf_f('foto_principal', 'Foto principal (topo da Página inicial e da Biografia)', 'image'),

        array('key' => 'field_dec_tab_qse', 'label' => 'Cartões "Quem sou eu"', 'type' => 'tab'),
        dec_acf_f('qse_biografia', 'Cartão "Biografia"', 'image'),
        dec_acf_f('qse_bipolab', 'Cartão "BiPoLaB"', 'image'),
        dec_acf_f('qse_curriculo', 'Cartão "Currículo Lattes"', 'image'),
        dec_acf_f('qse_discurso', 'Cartão "Discurso de Posse na AMRJ"', 'image'),
        dec_acf_f('qse_memorial', 'Cartão "Memorial"', 'image'),

        array('key' => 'field_dec_tab_discurso', 'label' => 'Página Discurso', 'type' => 'tab'),
        dec_acf_f('foto_discurso', 'Foto do topo da página Discurso', 'image'),

        array('key' => 'field_dec_tab_memorial', 'label' => 'Página Memorial', 'type' => 'tab'),
        dec_acf_f('foto_memorial', 'Foto do topo da página Memorial', 'image'),
        dec_acf_f('pdf_memorial', 'PDF exibido na página Memorial', 'file'),
        dec_acf_f('pdf_memorial_altura', 'Altura do visualizador de PDF (px)', 'number', array('default_value' => 700, 'min' => 200, 'max' => 2000, 'step' => 10)),
        dec_acf_f('pdf_memorial_toolbar', 'Barra de ferramentas do PDF', 'select', array('choices' => $toolbar_choices, 'default_value' => 'sim')),
        dec_acf_f('pdf_memorial_posicao', 'Posição do PDF em relação ao texto', 'select', array('choices' => $pos_choices, 'default_value' => 'depois')),

        array('key' => 'field_dec_tab_entrevistas', 'label' => 'Cartões de Entrevistas', 'type' => 'tab'),
        dec_acf_f('entrevistas_jornais', 'Cartão "Jornais"', 'image'),
        dec_acf_f('entrevistas_tv', 'Cartão "TV"', 'image'),
        dec_acf_f('entrevistas_podcast', 'Cartão "Podcast"', 'image'),

        array('key' => 'field_dec_tab_outras', 'label' => 'Outras páginas', 'type' => 'tab'),
        dec_acf_f('foto_bipolab', 'Foto do topo da página BiPoLaB', 'image'),
        dec_acf_f('foto_palestras', 'Foto do topo da listagem de Palestras', 'image'),

        array('key' => 'field_dec_tab_encontros', 'label' => 'Galeria Encontros', 'type' => 'tab'),
        dec_acf_f('encontros_galeria', 'Fotos da galeria "Encontros Especiais" (as 4 primeiras vão para a Página inicial)', 'gallery'),
    );
}

/**
 * Register everything.
 */
function dec_acf_register_groups() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $titles = array(
        'livro'      => 'Detalhes do Livro',
        'artigo'     => 'Arquivo do Artigo',
        'entrevista' => 'Detalhes da Entrevista',
        'palestra'   => 'Detalhes da Palestra',
    );

    foreach (dec_acf_post_field_map() as $post_type => $fields) {
        acf_add_local_field_group(array(
            'key'      => 'group_dec_' . $post_type,
            'title'    => $titles[$post_type],
            'fields'   => $fields,
            'location' => array(array(array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => $post_type,
            ))),
            'position' => 'normal',
            'style'    => 'default',
        ));
    }

    // Site-wide media. On ACF PRO it lives on the options page; on ACF free it
    // lives on the private "Mídia do Site" Page (created in theme-options.php on
    // `init` priority 1, before ACF fires `acf/init`).
    $location = null;
    if (function_exists('acf_add_options_page')) {
        $location = array(array(array(
            'param' => 'options_page', 'operator' => '==', 'value' => 'dec-site-media',
        )));
    } else {
        $page = get_page_by_path(DEC_MEDIA_PAGE_SLUG);
        if ($page) {
            $location = array(array(array(
                'param' => 'page', 'operator' => '==', 'value' => (string) $page->ID,
            )));
        }
    }
    if ($location) {
        acf_add_local_field_group(array(
            'key'            => 'group_dec_site_media',
            'title'          => 'Mídia do Site',
            'fields'         => dec_acf_site_media_fields(),
            'location'       => $location,
            'hide_on_screen' => array('the_content', 'discussion', 'comments', 'author', 'format', 'featured_image'),
        ));
    }

    // Gallery box shown right on the "Encontros Especiais" page.
    acf_add_local_field_group(array(
        'key'      => 'group_dec_encontros',
        'title'    => 'Galeria de fotos — Encontros Especiais',
        'fields'   => array(
            dec_acf_f(
                'dec_encontros_galeria',
                'Fotos (aparecem abaixo do cabeçalho verde; as 4 primeiras vão também para a Página inicial). A legenda é o título do anexo.',
                'gallery'
            ),
        ),
        'location' => array(array(array(
            'param'    => 'page_template',
            'operator' => '==',
            'value'    => 'page-encontros.php',
        ))),
        'position' => 'normal',
    ));
}
add_action('acf/init', 'dec_acf_register_groups');
