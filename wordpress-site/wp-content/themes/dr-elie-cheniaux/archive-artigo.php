<?php get_header(); ?>

<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span><span style="color:var(--navy);font-weight:700">Artigos Científicos</span>
    </div>
    <div class="flex items-center gap-5">
      <img src="<?php echo esc_url(content_url('/uploads/2026/08/artigo-imagem-padrao-2.jpg')); ?>" alt="Artigos Científicos" class="w-32 h-32 border-4 object-cover flex-shrink-0" style="border-color:var(--gold);">
      <h1 class="text-4xl lg:text-5xl font-bold" style="color:var(--navy)">Artigos Científicos</h1>
    </div>
  </div>
</section>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <div class="space-y-4">
    <?php while (have_posts()) : the_post(); ?>
      <div class="card p-6 flex gap-6 items-start reveal">
        <div class="text-3xl">📰</div>
        <div class="flex-1">
          <h2 class="font-bold text-lg mb-1" style="color:var(--navy)"><?php the_title(); ?></h2>
          <a href="<?php the_permalink(); ?>" class="inline-block mt-3 text-xs font-bold uppercase tracking-wider" style="color:var(--gold)">Ler artigo →</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <?php
  the_posts_pagination(array(
      'prev_text' => '← Anterior',
      'next_text' => 'Próximo →',
  ));
  ?>
</main>

<?php get_footer(); ?>
