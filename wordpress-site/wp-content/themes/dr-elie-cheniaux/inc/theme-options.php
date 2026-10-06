<?php
/**
 * "Mídia do Site" screen (Aparência → Mídia do Site).
 *
 * One option row, `dec_site_media`, holds every image / PDF that is NOT tied to
 * a single Livro / Artigo / Entrevista / Palestra post — i.e. everything that
 * used to be a hard-coded filename in the template files.
 *
 * Read it anywhere with dec_opt('chave').
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * @param string $key
 * @param mixed  $default
 * @return mixed
 */
function dec_opt($key, $default = '') {
    $opts = get_option('dec_site_media', array());
    if (!is_array($opts) || !isset($opts[$key]) || $opts[$key] === '' || $opts[$key] === array()) {
        return $default;
    }
    return $opts[$key];
}

/* -------------------------------------------------------------------------
 * Field definition — drives both the form and the sanitizer.
 * type: image | file | number | select
 * ---------------------------------------------------------------------- */
function dec_site_media_schema() {
    return array(
        'Página inicial e Biografia' => array(
            'foto_principal' => array('Foto principal (topo da página inicial e da página Biografia)', 'image'),
        ),
        'Cartões "Quem sou eu" (página inicial)' => array(
            'qse_biografia' => array('Cartão "Biografia"', 'image'),
            'qse_bipolab'   => array('Cartão "BiPoLaB"', 'image'),
            'qse_curriculo' => array('Cartão "Currículo Lattes"', 'image'),
            'qse_discurso'  => array('Cartão "Discurso de Posse na AMRJ"', 'image'),
            'qse_memorial'  => array('Cartão "Memorial"', 'image'),
        ),
        'Página Discurso de Posse (AMRJ)' => array(
            'foto_discurso' => array('Foto do topo da página', 'image'),
        ),
        'Página Memorial' => array(
            'foto_memorial'        => array('Foto do topo da página', 'image'),
            'pdf_memorial'         => array('Arquivo PDF exibido na página', 'file'),
            'pdf_memorial_altura'  => array('Altura do visualizador de PDF, em pixels', 'number', 700),
            'pdf_memorial_toolbar' => array('Barra de ferramentas do PDF (download, zoom, navegação)', 'select', array(
                'sim' => 'Mostrar', 'nao' => 'Ocultar',
            )),
            'pdf_memorial_posicao' => array('Posição do PDF em relação ao texto da página', 'select', array(
                'depois' => 'Depois do texto', 'antes' => 'Antes do texto',
            )),
        ),
        'Cartões de Entrevistas (página inicial e páginas de listagem)' => array(
            'entrevistas_jornais' => array('Cartão "Jornais"', 'image'),
            'entrevistas_tv'      => array('Cartão "TV"', 'image'),
            'entrevistas_podcast' => array('Cartão "Podcast"', 'image'),
        ),
        'Outras páginas' => array(
            'foto_bipolab'   => array('Foto do topo da página BiPoLaB', 'image'),
            'foto_palestras' => array('Foto do topo da página de listagem de Palestras', 'image'),
        ),
        'Galeria "Encontros Especiais"' => array(
            'encontros_galeria' => array('Fotos da galeria (arraste para reordenar; as 4 primeiras aparecem na página inicial)', 'gallery'),
        ),
    );
}

function dec_site_media_menu() {
    add_theme_page(
        'Mídia do Site',
        'Mídia do Site',
        'edit_theme_options',
        'dec-site-media',
        'dec_site_media_render_page'
    );
}
add_action('admin_menu', 'dec_site_media_menu');

function dec_site_media_register() {
    register_setting('dec_site_media_group', 'dec_site_media', array(
        'type'              => 'array',
        'sanitize_callback' => 'dec_site_media_sanitize',
        'default'           => array(),
    ));
}
add_action('admin_init', 'dec_site_media_register');

function dec_site_media_sanitize($input) {
    $out = array();
    if (!is_array($input)) {
        return $out;
    }
    foreach (dec_site_media_schema() as $fields) {
        foreach ($fields as $key => $def) {
            $type = $def[1];
            $raw  = isset($input[$key]) ? $input[$key] : '';

            if ($type === 'gallery') {
                $out[$key] = array_values(array_unique(array_filter(array_map('absint', (array) $raw))));
            } elseif ($type === 'number') {
                $out[$key] = $raw === '' ? '' : (string) absint($raw);
            } elseif ($type === 'select') {
                $choices = (isset($def[2]) && is_array($def[2])) ? array_keys($def[2]) : array();
                $out[$key] = in_array($raw, $choices, true) ? $raw : (isset($choices[0]) ? $choices[0] : '');
            } else {
                // image | file — attachment ID, URL or legacy filename
                $out[$key] = sanitize_text_field(is_array($raw) ? '' : $raw);
            }
        }
    }
    return $out;
}

function dec_site_media_render_page() {
    if (!current_user_can('edit_theme_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>Mídia do Site</h1>
        <p style="max-width:820px">
            Aqui você troca as imagens e PDFs que ficam <strong>fora</strong> das páginas de Livros, Artigos,
            Entrevistas e Palestras (essas são editadas dentro de cada post). Clique em
            <em>Selecionar imagem</em>, escolha ou envie o arquivo pela Biblioteca de Mídia e clique em
            <strong>Salvar alterações</strong> no fim da página. Campos em branco continuam usando a imagem padrão do tema.
        </p>
        <form method="post" action="options.php">
            <?php settings_fields('dec_site_media_group'); ?>
            <?php foreach (dec_site_media_schema() as $section => $fields) : ?>
                <div class="dec-site-media-section">
                    <h2><?php echo esc_html($section); ?></h2>
                    <table class="form-table" role="presentation"><tbody>
                    <?php foreach ($fields as $key => $def) :
                        if (!is_array($def)) {
                            continue;
                        }
                        list($label, $type) = $def;
                        $name = 'dec_site_media[' . $key . ']';
                        if ($type === 'select') {
                            $choices  = $def[2];
                            $fallback = key($choices);
                        } elseif ($type === 'number') {
                            $fallback = isset($def[2]) ? $def[2] : '';
                        } else {
                            $fallback = '';
                        }
                        $current = dec_opt($key, $fallback);
                        ?>
                        <tr>
                            <th scope="row"><label><?php echo esc_html($label); ?></label></th>
                            <td>
                                <?php if ($type === 'image' || $type === 'file') : ?>
                                    <?php dec_media_picker_field($name, $current, $type); ?>
                                <?php elseif ($type === 'gallery') : ?>
                                    <?php dec_media_repeater_field($name, (array) dec_opt($key, array())); ?>
                                <?php elseif ($type === 'number') : ?>
                                    <input type="number" min="200" max="2000" step="10"
                                           name="<?php echo esc_attr($name); ?>"
                                           value="<?php echo esc_attr($current); ?>" class="small-text">
                                    <span class="description">px</span>
                                <?php elseif ($type === 'select') : ?>
                                    <select name="<?php echo esc_attr($name); ?>">
                                        <?php foreach ((array) $def[2] as $opt_val => $opt_label) : ?>
                                            <option value="<?php echo esc_attr($opt_val); ?>" <?php selected($current, $opt_val); ?>>
                                                <?php echo esc_html($opt_label); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody></table>
                </div>
            <?php endforeach; ?>
            <?php submit_button('Salvar alterações'); ?>
        </form>
    </div>
    <?php
}
