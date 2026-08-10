<?php
/**
 * Shared helper / template-tag functions.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * "#1a4427" -> "26,68,39" (usable inside rgba(var(--accent-rgb), .5)).
 */
function dec_hex_to_rgb($hex, $fallback = '26,68,39') {
    $hex = ltrim((string) $hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
        return $fallback;
    }
    return implode(',', array(
        hexdec(substr($hex, 0, 2)),
        hexdec(substr($hex, 2, 2)),
        hexdec(substr($hex, 4, 2)),
    ));
}

/**
 * Parses a "one row per line, columns separated by |" textarea field.
 * Returns an array of arrays with the columns trimmed.
 */
function dec_parse_pipe_rows($text) {
    $rows = array();
    if (empty($text)) {
        return $rows;
    }
    foreach (preg_split('/\r\n|\r|\n/', trim($text)) as $line) {
        $line = trim($line);
        if ($line === '') {
            continue;
        }
        $cols = array_map('trim', explode('|', $line));
        $rows[] = $cols;
    }
    return $rows;
}

/**
 * Comma-separated meta value -> trimmed array.
 */
function dec_csv_to_array($text) {
    if (empty($text)) {
        return array();
    }
    return array_filter(array_map('trim', explode(',', $text)));
}

/**
 * A page created by the seeder, looked up by its slug.
 */
function dec_page_url($slug) {
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page) : home_url('/' . $slug . '/');
}

/**
 * Main site navigation, shared by header.php (desktop) and the mobile menu.
 */
function dec_get_nav_items() {
    $livros = get_posts(array(
        'post_type' => 'livro',
        'posts_per_page' => -1,
        'orderby' => 'menu_order title',
        'order' => 'ASC',
    ));

    return array(
        'quem_sou_eu' => array(
            'label' => 'Quem sou eu',
            'href' => dec_page_url('biografia'),
            'children' => array(
                array('label' => 'Biografia', 'href' => dec_page_url('biografia')),
                array('label' => 'BiPoLaB', 'href' => dec_page_url('bipolab')),
                array('label' => 'Currículo Lattes', 'href' => dec_page_url('curriculo')),
                array('label' => 'Discurso de posse na AMRJ', 'href' => dec_page_url('discurso')),
                array('label' => 'Memorial', 'href' => dec_page_url('memorial')),
            ),
        ),
        'livros' => array(
            'label' => 'Livros',
            'href' => get_post_type_archive_link('livro'),
            'children' => array_map(function ($p) {
                return array('label' => get_the_title($p), 'href' => get_permalink($p));
            }, $livros),
        ),
        'artigos' => array(
            'label' => 'Artigos científicos',
            'href' => get_post_type_archive_link('artigo'),
            'children' => array(),
        ),
        'entrevistas' => array(
            'label' => 'Entrevistas',
            'href' => get_post_type_archive_link('entrevista'),
            'children' => array(
                array('label' => 'Jornais', 'href' => add_query_arg('tipo', 'jornais', get_post_type_archive_link('entrevista'))),
                array('label' => 'TV', 'href' => add_query_arg('tipo', 'tv', get_post_type_archive_link('entrevista'))),
                array('label' => 'Podcast', 'href' => add_query_arg('tipo', 'podcast', get_post_type_archive_link('entrevista'))),
            ),
        ),
        'palestras' => array(
            'label' => 'Palestras',
            'href' => get_post_type_archive_link('palestra'),
            'children' => array(),
        ),
        'encontros' => array(
            'label' => 'Encontros especiais',
            'href' => dec_page_url('encontros'),
            'children' => array(
                array('label' => 'Fotos', 'href' => dec_page_url('encontros')),
            ),
        ),
        'redes' => array(
            'label' => 'Redes Sociais',
            'href' => '#',
            'children' => array(
                array('label' => 'Facebook', 'href' => 'https://www.facebook.com/elie.cheniaux', 'external' => true),
                array('label' => 'Instagram', 'href' => 'https://www.instagram.com/eliecheniaux', 'external' => true),
                array('label' => 'X', 'href' => 'https://x.com/CheniauxElie', 'external' => true),
                array('label' => 'YouTube', 'href' => 'https://www.youtube.com/@echeniaux', 'external' => true),
            ),
        ),
        'blog' => array(
            'label' => 'Blog',
            'href' => 'https://eliecheniaux.blogspot.com/',
            'external' => true,
            'children' => array(),
        ),
        'outros_textos' => array(
            'label' => 'Outros textos',
            'href' => 'https://criticos.com.br/?p=12181&cat=4',
            'external' => true,
            'children' => array(),
        ),
    );
}

/**
 * Renders "Nome | URL | Cor | Selo | Descrição" buy-link rows as buy-card
 * markup (used on single-livro.php).
 */
function dec_render_buy_cards($rows) {
    foreach ($rows as $cols) {
        $name = isset($cols[0]) ? $cols[0] : '';
        $url = isset($cols[1]) ? $cols[1] : '#';
        $color = isset($cols[2]) && $cols[2] !== '' ? $cols[2] : 'var(--accent)';
        $tag = isset($cols[3]) ? $cols[3] : '';
        $desc = isset($cols[4]) ? $cols[4] : '';
        ?>
        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" class="buy-card">
            <div class="buy-card-header">
                <div class="buy-card-icon" style="background:<?php echo esc_attr($color); ?>;color:white;">🛒</div>
                <?php if ($tag) : ?><span class="buy-tag" style="background:#f3f0e8;color:var(--navy);"><?php echo esc_html($tag); ?></span><?php endif; ?>
                <div class="buy-card-name"><?php echo esc_html($name); ?></div>
                <?php if ($desc) : ?><div class="buy-card-desc"><?php echo esc_html($desc); ?></div><?php endif; ?>
            </div>
            <div class="buy-card-footer">
                <span class="w-full block text-center text-xs font-bold uppercase tracking-wider py-2.5 rounded" style="background:<?php echo esc_attr($color); ?>;color:white;">Ver oferta →</span>
            </div>
        </a>
        <?php
    }
}

/**
 * Renders "Título | Texto | Texto do botão | URL do botão" CTA banner rows.
 */
function dec_render_cta_banners($rows) {
    foreach ($rows as $cols) {
        $titulo = isset($cols[0]) ? $cols[0] : '';
        $texto = isset($cols[1]) ? $cols[1] : '';
        $btn_text = isset($cols[2]) ? $cols[2] : '';
        $btn_url = isset($cols[3]) ? $cols[3] : '#';
        ?>
        <div class="cta-banner reveal">
            <div>
                <?php if ($titulo) : ?><h3 class="font-bold text-lg mb-1" style="color:var(--navy);font-family:'Playfair Display',serif;"><?php echo esc_html($titulo); ?></h3><?php endif; ?>
                <?php if ($texto) : ?><p class="text-sm text-gray-600"><?php echo esc_html($texto); ?></p><?php endif; ?>
            </div>
            <?php if ($btn_text) : ?><a href="<?php echo esc_url($btn_url); ?>" class="btn-outline flex-shrink-0"><?php echo esc_html($btn_text); ?></a><?php endif; ?>
        </div>
        <?php
    }
}
