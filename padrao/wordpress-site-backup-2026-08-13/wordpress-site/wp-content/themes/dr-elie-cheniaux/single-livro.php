<?php
get_header();
while (have_posts()) : the_post();
    $id = get_the_ID();
    $autor = get_post_meta($id, 'livro_autor', true);
    $subtitulo = get_post_meta($id, 'livro_subtitulo', true);
    $tagline = get_post_meta($id, 'livro_tagline', true);
    $ano = get_post_meta($id, 'livro_ano', true);
    $paginas = get_post_meta($id, 'livro_paginas', true);
    $editora = get_post_meta($id, 'livro_editora', true);
    $idioma = get_post_meta($id, 'livro_idioma', true);
    $formato = get_post_meta($id, 'livro_formato', true);
    $genero = get_post_meta($id, 'livro_genero', true);
    $accent = get_post_meta($id, 'livro_accent', true) ?: '#1a4427';
    $accent_light = get_post_meta($id, 'livro_accent_light', true) ?: '#e8d5a0';
    $accent_dark = get_post_meta($id, 'livro_accent_dark', true) ?: '#123018';
    $capa_alt = get_post_meta($id, 'livro_capa_alt', true);
    $endorsement = get_post_meta($id, 'livro_endorsement', true);
    $tema_titulo = get_post_meta($id, 'livro_tema_titulo', true);
    $tema_lista = dec_csv_to_array(get_post_meta($id, 'livro_tema_lista', true));
    $pull_quote = get_post_meta($id, 'livro_pull_quote', true);
    $pull_attr = get_post_meta($id, 'livro_pull_attr', true);
    $pref_nome = get_post_meta($id, 'livro_prefacio_nome', true);
    $pref_cargo = get_post_meta($id, 'livro_prefacio_cargo', true);
    $pref_extra = get_post_meta($id, 'livro_prefacio_extra', true);
    $pref_texto = get_post_meta($id, 'livro_prefacio_texto', true);
    $pref2_nome = get_post_meta($id, 'livro_prefacio2_nome', true);
    $pref2_cargo = get_post_meta($id, 'livro_prefacio2_cargo', true);
    $pref2_extra = get_post_meta($id, 'livro_prefacio2_extra', true);
    $pref2_texto = get_post_meta($id, 'livro_prefacio2_texto', true);
    $pref3_nome = get_post_meta($id, 'livro_prefacio3_nome', true);
    $pref3_cargo = get_post_meta($id, 'livro_prefacio3_cargo', true);
    $pref3_extra = get_post_meta($id, 'livro_prefacio3_extra', true);
    $pref3_texto = get_post_meta($id, 'livro_prefacio3_texto', true);
    $resenha_texto = get_post_meta($id, 'livro_resenha_texto', true);
    $resenha_autores = dec_parse_pipe_rows(get_post_meta($id, 'livro_resenha_autores', true));
    $compradores = dec_parse_pipe_rows(get_post_meta($id, 'livro_compradores', true));
    $ctas = dec_parse_pipe_rows(get_post_meta($id, 'livro_ctas', true));
    $generos = dec_csv_to_array($genero);
    $tem_prefacio = !empty($pref_texto);
    $prefacio_label = !empty($pref2_texto) ? 'Prefácios' : 'Prefácio';
    $tem_resenha = !empty($resenha_texto);
    $tem_comprar = !empty($compradores);

    $outros_livros = get_posts(array(
        'post_type' => 'livro', 'posts_per_page' => 6, 'post__not_in' => array($id), 'orderby' => 'rand',
    ));
    ?>
    <style>
      :root {
        --accent: <?php echo esc_html($accent); ?>;
        --accent-rgb: <?php echo esc_html(dec_hex_to_rgb($accent)); ?>;
        --accent-light: <?php echo esc_html($accent_light); ?>;
        --accent-dark: <?php echo esc_html($accent_dark); ?>;
      }
    </style>

    <!-- ══ HERO ══ -->
    <section class="book-hero">
      <div class="hero-deco hero-deco-1"></div>
      <div class="hero-deco hero-deco-2"></div>
      <div class="hero-deco hero-deco-3"></div>
      <div class="max-w-screen-xl mx-auto px-6 py-20 relative z-10 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
          <div class="flex justify-center lg:justify-end order-2 lg:order-1">
            <div class="book-cover-wrap">
              <?php the_post_thumbnail('large', array('alt' => 'Capa do livro ' . get_the_title())); ?>
            </div>
          </div>
          <div class="order-1 lg:order-2">
            <?php foreach ($generos as $g) : ?>
              <div class="hero-badge"><?php echo esc_html($g); ?></div>
            <?php endforeach; ?>
            <h1 class="hero-title text-5xl lg:text-6xl xl:text-7xl font-bold mb-3"><?php the_title(); ?></h1>
            <?php if ($subtitulo) : ?><p class="text-lg text-gray-500 mb-2" style="font-family:'Playfair Display',serif;"><?php echo esc_html($subtitulo); ?></p><?php endif; ?>
            <?php if ($autor) : ?><p class="hero-author mb-2"><?php echo esc_html($autor); ?></p><?php endif; ?>
            <div class="hero-divider"></div>
            <?php if ($tagline) : ?><p class="hero-tagline mb-10"><?php echo esc_html($tagline); ?></p><?php endif; ?>
            <div class="flex flex-wrap gap-4 mb-10">
              <?php if ($tem_comprar) : ?><a href="#comprar" class="btn-primary">Comprar agora</a><?php endif; ?>
              <a href="#sinopse" class="btn-outline">Sinopse</a>
              <?php if ($tem_prefacio) : ?><a href="#prefacio" class="btn-outline"><?php echo esc_html($prefacio_label); ?></a><?php endif; ?>
              <?php if ($tem_resenha) : ?><a href="#resenha" class="btn-outline">Resenha</a><?php endif; ?>
            </div>
            <?php if ($endorsement) : ?>
              <div class="flex items-center gap-3 text-sm text-gray-500"><span><?php echo esc_html($endorsement); ?></span></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- ══ STATS BAR ══ -->
    <div class="stats-bar">
      <div class="max-w-screen-xl mx-auto px-4 flex flex-wrap justify-center gap-4">
        <?php
        $stats = array(
            array('📝', $genero),
            array('📅', $ano ? 'Ano: ' . $ano : ''),
            array('📖', $paginas ? $paginas . ' páginas' : ''),
            array('🏢', $editora ? 'Editora: ' . $editora : ''),
            array('🌐', $idioma ? 'Idioma: ' . $idioma : ''),
        );
        foreach ($stats as $s) :
            if (empty($s[1])) continue;
        ?>
          <div class="stat-pill">
            <span class="stat-icon"><?php echo $s[0]; ?></span>
            <span><?php echo esc_html($s[1]); ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ══ INNER TAB NAV ══ -->
    <div class="inner-tab-bar">
      <div class="max-w-screen-lg mx-auto px-4 flex overflow-x-auto">
        <a href="#sinopse" class="inner-tab">Sinopse</a>
        <?php if ($tem_prefacio) : ?><a href="#prefacio" class="inner-tab"><?php echo esc_html($prefacio_label); ?></a><?php endif; ?>
        <?php if ($tem_resenha) : ?><a href="#resenha" class="inner-tab">Resenha</a><?php endif; ?>
        <?php if ($tem_comprar) : ?><a href="#comprar" class="inner-tab">Onde Comprar</a><?php endif; ?>
        <?php if ($outros_livros) : ?><a href="#outros-livros" class="inner-tab">Outros Livros</a><?php endif; ?>
      </div>
    </div>

    <!-- ══ SINOPSE ══ -->
    <section id="sinopse" class="py-24 bg-white">
      <div class="max-w-screen-lg mx-auto px-6">
        <div class="mb-14 reveal">
          <span class="section-label">Sobre o livro</span>
          <h2 class="section-heading text-4xl font-bold mb-5">Sinopse</h2>
          <div class="section-line"></div>
        </div>
        <div class="grid lg:grid-cols-3 gap-12 items-start">
          <div class="lg:col-span-2 space-y-6 text-gray-600 leading-relaxed text-base reveal">
            <?php the_content(); ?>
            <?php if ($tema_lista) : ?>
              <div class="rounded-lg p-6 mt-4" style="background:var(--accent-light);border-left:4px solid var(--accent);">
                <?php if ($tema_titulo) : ?><p class="font-semibold text-sm" style="color:var(--accent-dark)"><?php echo esc_html($tema_titulo); ?></p><?php endif; ?>
                <div class="mt-3 flex flex-wrap gap-2">
                  <?php foreach ($tema_lista as $tema) : ?><span class="tema-tag"><?php echo esc_html($tema); ?></span><?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
          <div class="reveal reveal-delay-2">
            <div class="ficha-card">
              <h3 class="font-bold text-base mb-5" style="color:var(--navy)">Ficha Técnica</h3>
              <div class="space-y-1">
                <?php
                $ficha = array('Autor' => $autor, 'Editora' => $editora, 'Ano' => $ano, 'Páginas' => $paginas, 'Gênero' => $genero, 'Idioma' => $idioma, 'Formato' => $formato);
                foreach ($ficha as $label => $val) :
                    if (empty($val)) continue;
                ?>
                  <div class="ficha-row"><span class="font-bold text-gray-700 text-sm"><?php echo esc_html($label); ?></span><span class="text-gray-500 text-sm"><?php echo esc_html($val); ?></span></div>
                <?php endforeach; ?>
              </div>
              <?php if ($tem_comprar) : ?><a href="#comprar" class="btn-primary w-full text-center block mt-6" style="padding:13px 24px;">Comprar agora</a><?php endif; ?>
            </div>
            <?php if ($capa_alt) : ?>
              <div class="mt-6 text-center">
                <img src="<?php echo esc_url($capa_alt); ?>" alt="Capa alternativa" class="w-full rounded-lg shadow-md" style="max-height:280px;object-fit:cover;object-position:top;"/>
                <p class="text-xs text-gray-400 mt-2">Edição alternativa</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <?php if ($pull_quote) : ?>
    <!-- ══ PULL QUOTE ══ -->
    <section class="pull-quote-section">
      <div class="max-w-screen-lg mx-auto px-6 relative z-10 reveal">
        <span class="pull-quote-mark">"</span>
        <blockquote class="pull-quote-text mt-4 mb-8"><?php echo esc_html($pull_quote); ?></blockquote>
        <?php if ($pull_attr) : ?><p class="pull-quote-attr">— <?php echo esc_html($pull_attr); ?></p><?php endif; ?>
      </div>
    </section>
    <?php endif; ?>

    <?php if ($tem_prefacio) : ?>
    <!-- ══ PREFÁCIO ══ -->
    <section id="prefacio" class="py-24" style="background:linear-gradient(135deg,#fff9f9 0%,#fff 60%,var(--accent-light) 100%);">
      <div class="max-w-screen-lg mx-auto px-6">
        <div class="mb-14 reveal">
          <span class="section-label">Apresentação</span>
          <h2 class="section-heading text-4xl font-bold mb-5"><?php echo esc_html($prefacio_label); ?></h2>
          <div class="section-line"></div>
        </div>
        <div class="prefacio-card flex flex-col md:flex-row reveal">
          <div class="prefacio-stripe" style="background:linear-gradient(180deg,var(--accent),var(--accent-dark));"></div>
          <div class="flex-1 p-8 lg:p-12">
            <?php if ($pref_nome) : ?>
              <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-100">
                <div class="prefacist-avatar"><span style="font-size:1.4rem;">✍️</span></div>
                <div>
                  <div class="font-bold text-lg" style="color:var(--navy)"><?php echo esc_html($pref_nome); ?></div>
                  <?php if ($pref_cargo) : ?><div class="text-sm text-gray-400"><?php echo esc_html($pref_cargo); ?></div><?php endif; ?>
                  <?php if ($pref_extra) : ?><div class="text-xs mt-1" style="color:var(--accent)"><?php echo esc_html($pref_extra); ?></div><?php endif; ?>
                </div>
              </div>
            <?php endif; ?>
            <div class="mb-8 overflow-hidden">
              <span class="open-quote">"</span>
              <p class="excerpt-text"><?php echo esc_html($pref_texto); ?></p>
            </div>
          </div>
          <?php if ($pref2_texto) : ?>
          <div class="flex-1 p-8 lg:p-12">
            <?php if ($pref2_nome) : ?>
              <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-100">
                <div class="prefacist-avatar"><span style="font-size:1.4rem;">✍️</span></div>
                <div>
                  <div class="font-bold text-lg" style="color:var(--navy)"><?php echo esc_html($pref2_nome); ?></div>
                  <?php if ($pref2_cargo) : ?><div class="text-sm text-gray-400"><?php echo esc_html($pref2_cargo); ?></div><?php endif; ?>
                  <?php if ($pref2_extra) : ?><div class="text-xs mt-1" style="color:var(--accent)"><?php echo esc_html($pref2_extra); ?></div><?php endif; ?>
                </div>
              </div>
            <?php endif; ?>
            <div class="mb-8 overflow-hidden">
              <span class="open-quote">"</span>
              <p class="excerpt-text"><?php echo esc_html($pref2_texto); ?></p>
            </div>
          </div>
          <?php endif; ?>
          <?php if ($pref3_texto) : ?>
          <div class="flex-1 p-8 lg:p-12">
            <?php if ($pref3_nome) : ?>
              <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-100">
                <div class="prefacist-avatar"><span style="font-size:1.4rem;">✍️</span></div>
                <div>
                  <div class="font-bold text-lg" style="color:var(--navy)"><?php echo esc_html($pref3_nome); ?></div>
                  <?php if ($pref3_cargo) : ?><div class="text-sm text-gray-400"><?php echo esc_html($pref3_cargo); ?></div><?php endif; ?>
                  <?php if ($pref3_extra) : ?><div class="text-xs mt-1" style="color:var(--accent)"><?php echo esc_html($pref3_extra); ?></div><?php endif; ?>
                </div>
              </div>
            <?php endif; ?>
            <div class="mb-8 overflow-hidden">
              <span class="open-quote">"</span>
              <p class="excerpt-text"><?php echo esc_html($pref3_texto); ?></p>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php if ($tem_resenha) : ?>
    <!-- ══ RESENHA ══ -->
    <section id="resenha" class="py-24" style="background:linear-gradient(135deg,#f0fdfa 0%,#fff 100%);">
      <div class="max-w-screen-lg mx-auto px-6">
        <div class="mb-14 reveal">
          <h2 class="section-heading text-4xl font-bold mb-5">Resenha</h2>
          <div class="section-line"></div>
        </div>
        <div class="prefacio-card flex flex-col md:flex-row reveal">
          <div class="prefacio-stripe" style="background:linear-gradient(180deg,#0f766e,#0d9488);"></div>
          <div class="flex-1 p-8 lg:p-12">
            <div class="mb-8 overflow-hidden">
              <span class="open-quote">"</span>
              <p class="excerpt-text"><?php echo esc_html($resenha_texto); ?></p>
            </div>
            <?php if ($resenha_autores) : ?>
              <div class="rounded-lg p-5 text-sm leading-relaxed" style="background:#fffbeb;border:1px solid #fde68a;color:#78350f;">
                <p class="font-semibold mb-4">Sobre os autores da resenha</p>
                <ul class="space-y-3 list-disc list-inside">
                  <?php foreach ($resenha_autores as $a) : ?>
                    <li><span class="font-semibold"><?php echo esc_html($a[0]); ?></span> <?php echo isset($a[1]) ? esc_html($a[1]) : ''; ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php if ($tem_comprar) : ?>
    <!-- ══ ONDE COMPRAR ══ -->
    <section id="comprar" class="py-24 bg-white">
      <div class="max-w-screen-lg mx-auto px-6">
        <div class="mb-14 reveal">
          <span class="section-label">Adquira o livro</span>
          <h2 class="section-heading text-4xl font-bold mb-5">Onde Comprar</h2>
          <div class="section-line"></div>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 reveal">
          <?php dec_render_buy_cards($compradores); ?>
        </div>
        <?php if ($ctas) : ?>
          <div class="mt-14 space-y-6"><?php dec_render_cta_banners($ctas); ?></div>
        <?php endif; ?>
      </div>
    </section>
    <?php endif; ?>

    <?php if ($outros_livros) : ?>
    <!-- ══ OUTROS LIVROS ══ -->
    <section id="outros-livros" class="py-24" style="background:linear-gradient(135deg,#f5f5f0 0%,#fff 100%);">
      <div class="max-w-screen-lg mx-auto px-6">
        <div class="text-center mb-14 reveal">
          <span class="section-label" style="display:block;text-align:center;">Biblioteca do autor</span>
          <h2 class="section-heading text-3xl font-bold mb-4">Outros Livros de <?php bloginfo('name'); ?></h2>
          <div class="section-line mx-auto"></div>
        </div>
        <div class="books-scroll reveal">
          <?php foreach ($outros_livros as $ol) :
              $ol_capa_home = get_post_meta($ol->ID, 'livro_capa_home', true);
          ?>
            <a href="<?php echo esc_url(get_permalink($ol)); ?>" class="book-thumb">
              <?php if ($ol_capa_home) : ?>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/img/' . $ol_capa_home); ?>" alt="<?php echo esc_attr(get_the_title($ol)); ?>">
              <?php else : ?>
                <?php echo get_the_post_thumbnail($ol, 'medium'); ?>
              <?php endif; ?>
              <div class="book-thumb-title"><?php echo esc_html(get_the_title($ol)); ?></div>
            </a>
          <?php endforeach; ?>
          <a href="<?php echo esc_url(get_post_type_archive_link('livro')); ?>" class="book-thumb" style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:180px;background:linear-gradient(135deg,var(--navy),var(--accent-dark));">
            <div style="font-size:2rem;margin-bottom:8px;">📚</div>
            <div class="book-thumb-title" style="color:white;text-align:center;font-size:.8rem;">Ver todos os livros</div>
          </a>
        </div>
      </div>
    </section>
    <?php endif; ?>

<?php endwhile; get_footer(); ?>
