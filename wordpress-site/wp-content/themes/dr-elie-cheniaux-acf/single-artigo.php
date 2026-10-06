<?php
get_header();
while (have_posts()) : the_post();
    $id = get_the_ID();
    $pdf_url  = dec_media_url(get_post_meta($id, 'artigo_pdf', true), 'pdf');
    $altura   = (int) get_post_meta($id, 'artigo_pdf_altura', true);
    if ($altura < 200) {
        $altura = 700;
    }
    $toolbar  = get_post_meta($id, 'artigo_pdf_toolbar', true) === 'nao' ? '0' : '1';
    $posicao  = get_post_meta($id, 'artigo_pdf_posicao', true) ?: 'depois';
    $has_text = trim(get_the_content()) !== '';

    $artigo_iframe = $pdf_url
        ? '<iframe src="' . esc_url($pdf_url . '#toolbar=' . $toolbar) . '" width="100%" height="' . esc_attr($altura) . '" style="height:' . esc_attr($altura) . 'px; border:1px solid #e5e7eb; border-radius:6px;"><p>Seu navegador não suporta exibição de PDF.</p></iframe>'
        : '';
    ?>
    <section class="page-hero py-14">
      <div class="max-w-screen-lg mx-auto px-6">
        <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
          <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span>
          <a href="<?php echo esc_url(get_post_type_archive_link('artigo')); ?>">Artigos</a><span class="text-gray-400">›</span>
          <span style="color:var(--navy);font-weight:700"><?php the_title(); ?></span>
        </div>
        <div class="flex items-start gap-6">
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('thumbnail', array('class' => 'w-32 h-32 border-4 object-cover flex-shrink-0', 'style' => 'border-color:var(--gold);')); ?>
          <?php endif; ?>
          <div>
            <p class="text-xs font-bold uppercase tracking-widest mb-1" style="color:var(--gold)">Artigos</p>
            <h1 class="text-4xl lg:text-5xl font-bold mb-3" style="color:var(--navy)"><?php the_title(); ?></h1>
          </div>
        </div>
      </div>
    </section>

    <main class="max-w-screen-xl mx-auto px-8 py-14">
      <?php if ($posicao === 'antes' && $artigo_iframe) : ?>
        <div class="reveal mb-8"><?php echo $artigo_iframe; ?></div>
      <?php endif; ?>

      <?php if ($has_text) : ?>
        <div class="prose max-w-none reveal mb-8"><?php the_content(); ?></div>
      <?php endif; ?>

      <?php if ($posicao !== 'antes' && $artigo_iframe) : ?>
        <div class="reveal"><?php echo $artigo_iframe; ?></div>
      <?php endif; ?>

      <div class="flex gap-4 flex-wrap reveal mt-6">
        <a href="<?php echo esc_url(get_post_type_archive_link('artigo')); ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded font-bold text-sm uppercase tracking-wide border-2 transition-all" style="border-color:var(--navy);color:var(--navy)">← Voltar aos Artigos</a>
      </div>
    </main>
<?php endwhile; get_footer(); ?>
