<?php get_header(); ?>

<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span><span style="color:var(--navy);font-weight:700">Palestras</span>
    </div>
    <div class="flex items-center gap-5">
      <img src="<?php echo esc_url(dec_media_url_fallback(array(dec_opt('foto_palestras'), 'PalestraHumanidades.jpg'))); ?>" alt="Palestras" class="w-32 h-32 border-4 object-cover flex-shrink-0" style="border-color:var(--gold);">
      <h1 class="text-4xl lg:text-5xl font-bold" style="color:var(--navy)">Palestras</h1>
    </div>
  </div>
</section>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <?php
  $todas_palestras = get_posts(array(
      'post_type' => 'palestra',
      'posts_per_page' => -1,
      'orderby' => 'menu_order date',
      'order' => 'ASC',
  ));
  ?>

  <?php if ($todas_palestras) : ?>
    <div class="space-y-4">
      <?php foreach ($todas_palestras as $p) :
          $link = get_post_meta($p->ID, 'palestra_link', true);
      ?>
        <div class="card p-6 flex gap-6 items-start reveal">
          <div class="text-3xl">🎤</div>
          <div class="flex-1">
            <h2 class="font-bold text-lg mb-1" style="color:var(--navy)"><?php echo esc_html(get_the_title($p)); ?></h2>
            <?php if ($link) : ?><a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener" class="inline-block mt-3 text-xs font-bold uppercase tracking-wider" style="color:var(--gold)">Assistir →</a><?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
