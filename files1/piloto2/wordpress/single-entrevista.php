<?php
get_header();
while (have_posts()) : the_post();
    $id = get_the_ID();
    $veiculo = get_post_meta($id, 'entrevista_veiculo', true);
    $link = get_post_meta($id, 'entrevista_link', true);
    $data = get_post_meta($id, 'entrevista_data', true);
    $tipo_terms = get_the_terms($id, 'entrevista_tipo');
    $tipo_label = $tipo_terms && !is_wp_error($tipo_terms) ? $tipo_terms[0]->name : 'Entrevista';
    ?>
    <section class="page-hero py-14">
      <div class="max-w-screen-lg mx-auto px-6">
        <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
          <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span>
          <a href="<?php echo esc_url(get_post_type_archive_link('entrevista')); ?>">Entrevistas</a><span class="text-gray-400">›</span>
          <span style="color:var(--navy);font-weight:700"><?php the_title(); ?></span>
        </div>
        <p class="text-xs font-bold uppercase tracking-widest mb-1" style="color:var(--gold)"><?php echo esc_html($tipo_label); ?><?php echo $veiculo ? ' · ' . esc_html($veiculo) : ''; ?></p>
        <h1 class="text-4xl lg:text-5xl font-bold mb-3" style="color:var(--navy)"><?php the_title(); ?></h1>
        <?php if ($data) : ?><p class="text-gray-500 text-sm"><?php echo esc_html($data); ?></p><?php endif; ?>
      </div>
    </section>

    <main class="max-w-screen-lg mx-auto px-6 py-14">
      <?php if (has_post_thumbnail()) : ?><div class="mb-6"><?php the_post_thumbnail('large', array('class' => 'w-full h-auto rounded')); ?></div><?php endif; ?>
      <div class="prose text-gray-600 leading-relaxed"><?php the_excerpt(); ?></div>
      <?php if ($link) : ?>
        <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener" class="btn-primary inline-block mt-8">Acessar entrevista →</a>
      <?php endif; ?>
      <div class="mt-10">
        <a href="<?php echo esc_url(get_post_type_archive_link('entrevista')); ?>" class="btn-outline">← Voltar às Entrevistas</a>
      </div>
    </main>
<?php endwhile; get_footer(); ?>
