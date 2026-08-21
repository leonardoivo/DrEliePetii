<?php get_header(); ?>

<!-- ══════════════════ HERO ══════════════════ -->
<section id="quem-sou-eu" class="hero">
  <div class="max-w-screen-xl mx-auto px-6 py-20 relative z-10 grid lg:grid-cols-2 gap-16 items-center">
    <div>
      <span class="hero-badge">Bem-vindo(a)</span>
      <h1 class="hero-title text-5xl lg:text-6xl font-bold mb-4"><?php bloginfo('name'); ?></h1>
      <div class="hero-divider"></div>
      <p class="hero-subtitle mb-8">Psiquiatra · professor universitário · escritor</p>
      <div class="flex flex-wrap gap-4">
        <a href="#livros" class="btn-primary">Conheça meus livros</a>
        <a href="#contato" class="btn-outline">Contato ou agendamento de consulta</a>
      </div>
    </div>
    <div class="flex justify-center">
      <div class="w-72 h-72 lg:w-96 lg:h-96 overflow-hidden border-4 shadow-2xl" style="border-color: var(--gold-light);">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/dr-elie.jpg'); ?>" alt="Foto de <?php bloginfo('name'); ?>" class="object-cover w-full h-full" style="object-position: top center;">
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════ QUEM SOU EU ══════════════════ -->
<section id="biografia" class="py-20 bg-white">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="text-center mb-14 reveal">
      <h2 class="section-heading text-4xl font-bold">Quem sou eu</h2>
      <div class="section-line mx-auto"></div>
    </div>
    <div class="grid md:grid-cols-3 gap-6 reveal">
      <?php
      $quem_sou_eu = array(
          array('biografia', 'Biografia', 'dr-elie.jpg', 'Foto de Elie Cheniaux', 'Trajetória de vida, formação e experiências marcantes', 'Ler mais →', 'object-fit:cover;object-position:top center;'),
          array('bipolab', 'BiPoLaB', 'logo do BiPoLaB.jpg', 'logo do BiPoLaB', 'Laboratório de pesquisa sobre o transtorno bipolar', 'Ler mais →', 'object-fit:cover;'),
          array('curriculo', 'Currículo Lattes', 'Plataforma Lattes.jpg', 'Plataforma Lattes', 'Produção científica', 'Acessar →', 'object-fit:cover;'),
          array('discurso', 'Discurso de Posse na AMRJ', 'selo-amrj.jpg', 'Selo da Academia de Medicina do Rio de Janeiro', 'Ingresso na Academia de Medicina do Rio de Janeiro', 'Ler →', 'object-fit:contain;'),
          array('memorial', 'Memorial', 'carreira-16.jpg', 'Memorial', 'Reflexões, memórias e relatos que compõem minha trajetória intelectual e pessoal ao longo dos anos', 'Ler →', 'object-fit:cover;'),
      );
      foreach ($quem_sou_eu as $qse) :
          list($slug, $title, $img, $img_alt, $desc, $cta, $fit) = $qse;
      ?>
        <a href="<?php echo esc_url(dec_page_url($slug)); ?>" class="card p-8 text-center group">
          <div class="mb-4" style="border-radius:4px; height:130px; overflow:hidden; padding:0;">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/img/' . $img); ?>" alt="<?php echo esc_attr($img_alt); ?>" class="w-full h-full" style="<?php echo esc_attr($fit); ?>">
          </div>
          <h3 class="section-heading text-xl font-bold mb-2"><?php echo esc_html($title); ?></h3>
          <p class="text-gray-500 text-sm leading-relaxed"><?php echo esc_html($desc); ?></p>
          <span class="inline-block mt-4 text-xs font-bold uppercase tracking-wider" style="color:var(--gold)"><?php echo esc_html($cta); ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════ LIVROS ══════════════════ -->
<section id="livros" style="background: linear-gradient(135deg,#fdf8ee 0%,#fff 100%);" class="py-20">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="text-center mb-14 reveal">
      <h2 class="section-heading text-4xl font-bold">Livros</h2>
      <div class="section-line mx-auto"></div>
      <p class="text-gray-400 mt-4">Obras publicadas, sinopses e onde adquirir</p>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 reveal">
      <?php
      $livros = get_posts(array('post_type' => 'livro', 'posts_per_page' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC'));
      foreach ($livros as $livro) :
      ?>
        <?php $capa_home = get_post_meta($livro->ID, 'livro_capa_home', true); ?>
        <a href="<?php echo esc_url(get_permalink($livro)); ?>" class="card group overflow-hidden">
          <div style="padding:20px 0; display:flex; align-items:center; justify-content:center; background:#f5f0e8;">
            <?php if ($capa_home) : ?>
              <img src="<?php echo esc_url(get_template_directory_uri() . '/img/' . $capa_home); ?>" alt="<?php echo esc_attr(get_the_title($livro)); ?>" class="h-auto mx-auto" style="max-width:60%;">
            <?php else : ?>
              <?php echo get_the_post_thumbnail($livro, 'medium', array('class' => 'h-auto mx-auto', 'style' => 'max-width:60%;')); ?>
            <?php endif; ?>
          </div>
          <div class="px-5 py-3">
            <h3 class="font-bold text-base mb-1" style="color:var(--navy)"><?php echo esc_html(get_the_title($livro)); ?></h3>
            <span class="text-xs font-bold uppercase tracking-wider" style="color:var(--gold)">Ver livro →</span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════ ARTIGOS ══════════════════ -->
<section id="artigos" class="py-20 bg-white">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="text-center mb-14 reveal">
      <h2 class="section-heading text-4xl font-bold">Artigos Científicos</h2>
      <div class="section-line mx-auto"></div>
    </div>
    <div class="space-y-4 reveal">
      <?php
      $artigos = get_posts(array('post_type' => 'artigo', 'posts_per_page' => 4, 'orderby' => 'date', 'order' => 'DESC'));
      foreach ($artigos as $artigo) :
      ?>
        <div class="card p-6 flex gap-6 items-start">
          <div class="text-3xl">📰</div>
          <div class="flex-1">
            <h3 class="font-bold text-lg mb-1" style="color:var(--navy)"><?php echo esc_html(get_the_title($artigo)); ?></h3>
            <a href="<?php echo esc_url(get_permalink($artigo)); ?>" class="inline-block mt-3 text-xs font-bold uppercase tracking-wider" style="color:var(--gold)">Ler artigo →</a>
          </div>
        </div>
      <?php endforeach; ?>
      <div class="text-center mt-8">
        <a href="<?php echo esc_url(get_post_type_archive_link('artigo')); ?>" class="btn-outline" style="display:inline-block">Ver todos os artigos →</a>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════ ENTREVISTAS ══════════════════ -->
<section id="entrevistas" style="background: linear-gradient(135deg,#f8f9ff 0%,#fff 100%);" class="py-20">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="text-center mb-14 reveal">
      <h2 class="section-heading text-4xl font-bold">Entrevistas</h2>
      <div class="section-line mx-auto"></div>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 reveal">
      <?php
      $tipos = array(
          'jornais' => array('Jornais', 'tenha-os-principais-jornais-do-pais-no-seu-bolso.png', 'Entrevista nos jornais', 'Entrevistas na imprensa escrita'),
          'tv' => array('TV', 'Livro CINEMA E LOUCURA 2.jpg', 'Entrevista com Jornalista', 'Aparições e entrevistas em televisão'),
          'podcast' => array('Podcast', 'Entrevistas podcast.jpg', 'Entrevista em Podcast', 'Episódios e participações em podcasts'),
      );
      foreach ($tipos as $tipo_slug => $t) :
        list($tipo_label, $img, $img_alt, $desc) = $t;
        $archive_link = add_query_arg('tipo', $tipo_slug, get_post_type_archive_link('entrevista'));
      ?>
        <a href="<?php echo esc_url($archive_link); ?>" class="card p-7 text-center group">
          <div class="mb-4" style="border-radius:4px; overflow:hidden;">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/img/' . $img); ?>" alt="<?php echo esc_attr($img_alt); ?>" class="w-full h-auto">
          </div>
          <h3 class="font-bold mb-2" style="color:var(--navy)"><?php echo esc_html($tipo_label); ?></h3>
          <p class="text-gray-400 text-xs"><?php echo esc_html($desc); ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════ PALESTRAS ══════════════════ -->
<section id="palestras" class="py-20 bg-white">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="text-center mb-14 reveal">
      <h2 class="section-heading text-4xl font-bold">Palestras</h2>
      <div class="section-line mx-auto"></div>
    </div>
    <div class="space-y-4 reveal">
      <?php
      $palestras = get_posts(array('post_type' => 'palestra', 'posts_per_page' => 3, 'orderby' => 'menu_order date', 'order' => 'ASC'));
      foreach ($palestras as $palestra) :
          $link = get_post_meta($palestra->ID, 'palestra_link', true);
      ?>
        <div class="card p-6 flex gap-6 items-start">
          <div class="text-3xl">🎤</div>
          <div class="flex-1">
            <h3 class="font-bold text-lg mb-1" style="color:var(--navy)"><?php echo esc_html(get_the_title($palestra)); ?></h3>
            <?php if ($link) : ?><a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener" class="inline-block mt-3 text-xs font-bold uppercase tracking-wider" style="color:var(--gold)">Assistir →</a><?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-8">
      <a href="<?php echo esc_url(get_post_type_archive_link('palestra')); ?>" class="btn-outline" style="display:inline-block">Ver todas as palestras →</a>
    </div>
  </div>
</section>

<!-- ══════════════════ ENCONTROS ESPECIAIS ══════════════════ -->
<section id="encontros" style="background: linear-gradient(135deg,#fff8f0,#fff);" class="py-20">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="text-center mb-14 reveal">
      <h2 class="section-heading text-4xl font-bold">Encontros Especiais</h2>
      <div class="section-line mx-auto"></div>
      <p class="text-gray-400 mt-4">Momentos e registros com pessoas incríveis</p>
    </div>
    <div id="fotos-encontros" class="grid grid-cols-2 md:grid-cols-4 gap-4 reveal">
      <?php
      $encontros_imgs = get_theme_mod('dec_encontros_preview', array());
      foreach (array_slice($encontros_imgs, 0, 4) as $img) :
      ?>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/' . $img['src']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full h-auto">
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-8 reveal">
      <a href="<?php echo esc_url(dec_page_url('encontros')); ?>" class="btn-outline" style="display:inline-block">Ver galeria completa →</a>
    </div>
  </div>
</section>

<!-- ══════════════════ REDES SOCIAIS ══════════════════ -->
<section id="redes" class="py-20 bg-white">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="text-center mb-14 reveal">
      <h2 class="section-heading text-4xl font-bold">Redes Sociais</h2>
      <div class="section-line mx-auto"></div>
      <p class="text-gray-400 mt-4">Siga e acompanhe meu conteúdo</p>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 reveal">
      <a href="https://www.facebook.com/elie.cheniaux" target="_blank" rel="noopener" class="social-card">
        <div class="social-icon" style="background:#e8f0fe">📘</div>
        <div><div class="font-bold text-sm" style="color:var(--navy)">Facebook</div><div class="text-xs text-gray-400">Siga minha página</div></div>
      </a>
      <a href="https://www.instagram.com/eliecheniaux" target="_blank" rel="noopener" class="social-card">
        <div class="social-icon" style="background:#fce4ec">📸</div>
        <div><div class="font-bold text-sm" style="color:var(--navy)">Instagram</div><div class="text-xs text-gray-400">Fotos e histórias</div></div>
      </a>
      <a href="https://x.com/CheniauxElie" target="_blank" rel="noopener" class="social-card">
        <div class="social-icon" style="background:#e5e7eb">✖️</div>
        <div><div class="font-bold text-sm" style="color:var(--navy)">X</div><div class="text-xs text-gray-400">Acompanhe no X</div></div>
      </a>
      <a href="https://www.youtube.com/@echeniaux" target="_blank" rel="noopener" class="social-card">
        <div class="social-icon" style="background:#fde8e8">▶️</div>
        <div><div class="font-bold text-sm" style="color:var(--navy)">YouTube</div><div class="text-xs text-gray-400">Vídeos e palestras</div></div>
      </a>
      <a href="https://eliecheniaux.blogspot.com/" target="_blank" class="social-card">
        <div class="social-icon" style="background:#f0f9ff">✍️</div>
        <div><div class="font-bold text-sm" style="color:var(--navy)">Blog</div><div class="text-xs text-gray-400">Textos e reflexões</div></div>
      </a>
    </div>
  </div>
</section>

<!-- ══════════════════ BLOG ══════════════════ -->
<section id="blog" style="background: linear-gradient(135deg,#f0f9ff,#fff);" class="py-20">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="text-center mb-14 reveal">
      <h2 class="section-heading text-4xl font-bold">Blog</h2>
      <div class="section-line mx-auto"></div>
    </div>
    <div class="grid md:grid-cols-2 gap-6 reveal">
      <a id="blog-posts" href="https://eliecheniaux.blogspot.com/2022/08/abaixo-baixofobia.html" target="_blank" rel="noopener" class="card p-7 group">
        <div class="text-3xl mb-4">✍️</div>
        <div class="text-xs font-bold uppercase tracking-widest mb-2" style="color:var(--gold)">Blog · 07 Ago 2022</div>
        <h3 class="section-heading text-xl font-bold mb-3" style="color:var(--navy)">Abaixo a Baixofobia!</h3>
        <p class="text-gray-400 text-sm leading-relaxed mb-4">"Desde que começamos a sair juntos, nunca mais usei salto alto", disse-me ela, na expectativa de que eu, em seguida, expressasse profunda gratidão.</p>
        <span class="text-xs font-bold uppercase tracking-wider" style="color:var(--gold)">Ler post →</span>
      </a>
      <a href="https://eliecheniaux.blogspot.com/2021/12/dialogo-entre-dois-amigos-em-um-cafe-em.html" target="_blank" rel="noopener" class="card p-7 group">
        <div class="text-3xl mb-4">✍️</div>
        <div class="text-xs font-bold uppercase tracking-widest mb-2" style="color:var(--gold)">Blog · 29 Dez 2021</div>
        <h3 class="section-heading text-xl font-bold mb-3" style="color:var(--navy)">Diálogo Entre Dois Amigos em um Café em Copacabana</h3>
        <p class="text-gray-400 text-sm leading-relaxed mb-4">"— Em relação a esse ciúme que sinto da minha namorada, o que devo fazer? — Tome um antipsicótico..."</p>
        <span class="text-xs font-bold uppercase tracking-wider" style="color:var(--gold)">Ler post →</span>
      </a>
    </div>
    <div class="text-center mt-8 reveal">
      <a href="https://eliecheniaux.blogspot.com/" target="_blank" rel="noopener" class="btn-outline" style="display:inline-block">Ver todos os textos →</a>
    </div>
  </div>
</section>

<!-- ══════════════════ OUTROS TEXTOS ══════════════════ -->
<section id="outros-textos" class="py-20 bg-white">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="text-center mb-14 reveal">
      <h2 class="section-heading text-4xl font-bold">Outros Textos</h2>
      <div class="section-line mx-auto"></div>
    </div>
    <div class="grid gap-6 reveal max-w-lg mx-auto">
      <a id="outros-textos-post" href="https://criticos.com.br/?p=12181&cat=4" target="_blank" rel="noopener" class="card p-7 group">
        <div class="text-3xl mb-4">📝</div>
        <div class="text-xs font-bold uppercase tracking-widest mb-2" style="color:var(--gold)">Outros textos · 28 Jan 2020</div>
        <h3 class="section-heading text-xl font-bold mb-3" style="color:var(--navy)">Um Dia de Chuva em Nova York</h3>
        <p class="text-gray-400 text-sm leading-relaxed mb-4">Domingos Oliveira certa vez fez o seguinte comentário: "Um dos maiores prazeres da minha vida é quando os jornais anunciam um novo filme de Woody Allen..."</p>
        <span class="text-xs font-bold uppercase tracking-wider" style="color:var(--gold)">Ler texto →</span>
      </a>
    </div>
  </div>
</section>

<!-- ══════════════════ CONTATO ══════════════════ -->
<section id="contato" class="py-20 bg-white">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="text-center mb-14 reveal">
      <h2 class="section-heading text-4xl font-bold">Contato</h2>
      <div class="section-line mx-auto"></div>
      <p class="text-gray-400 mt-4">Entre em contato por qualquer um dos canais abaixo</p>
    </div>
    <div class="grid md:grid-cols-2 gap-10 reveal">
      <div>
        <div class="contact-row"><div class="contact-icon">📧</div><div><div class="font-bold text-sm mb-1" style="color:var(--navy)">E-mail</div><div class="text-gray-500 text-sm">echeniaux@gmail.com</div></div></div>
        <div class="contact-row"><div class="contact-icon">📱</div><div><div class="font-bold text-sm mb-1" style="color:var(--navy)">WhatsApp</div><div class="text-gray-500 text-sm"><a href="https://wa.me/5521991741465" target="_blank" rel="noopener" class="hover:underline">+55 21 99174-1465</a></div></div></div>
        <div class="contact-row border-b-0"><div class="contact-icon">📍</div><div><div class="font-bold text-sm mb-1" style="color:var(--navy)">Endereço</div><div class="text-gray-500 text-sm">Av. N. Sra. Copacabana, 1066 / 1101 – Rio de Janeiro – RJ – 22060-002</div></div></div>
      </div>
      <div class="card p-8">
        <h3 class="section-heading text-xl font-bold mb-6" style="color:var(--navy)">Envie uma mensagem</h3>
        <?php if (isset($_GET['contato'])) : ?>
          <?php if ($_GET['contato'] === 'sucesso') : ?>
            <div class="mb-4 p-4 rounded text-sm" style="background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;">Mensagem enviada com sucesso! Retornaremos em breve.</div>
          <?php elseif ($_GET['contato'] === 'invalido') : ?>
            <div class="mb-4 p-4 rounded text-sm" style="background:#fffbeb;color:#92400e;border:1px solid #fde68a;">Preencha nome, e-mail e mensagem corretamente antes de enviar.</div>
          <?php else : ?>
            <div class="mb-4 p-4 rounded text-sm" style="background:#fef2f2;color:#991b1b;border:1px solid #fecaca;">Não foi possível enviar a mensagem agora. Tente novamente em instantes.</div>
          <?php endif; ?>
        <?php endif; ?>
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="space-y-4">
          <input type="hidden" name="action" value="dec_contact_form">
          <?php wp_nonce_field('dec_contact_form', 'dec_contact_nonce'); ?>
          <input type="text" name="dec_contact_website" value="" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;" aria-hidden="true">
          <input type="text" name="dec_nome" placeholder="Seu nome" required class="w-full border border-gray-200 rounded px-4 py-3 text-sm">
          <input type="email" name="dec_email" placeholder="Seu e-mail" required class="w-full border border-gray-200 rounded px-4 py-3 text-sm">
          <textarea name="dec_mensagem" placeholder="Sua mensagem..." rows="5" required class="w-full border border-gray-200 rounded px-4 py-3 text-sm"></textarea>
          <button type="submit" class="btn-primary w-full text-center">Enviar mensagem</button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
