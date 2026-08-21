<?php get_header(); ?>

<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span><span style="color:var(--navy);font-weight:700">Livros</span>
    </div>
    <h1 class="text-4xl lg:text-5xl font-bold" style="color:var(--navy)">Livros</h1>
  </div>
</section>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php while (have_posts()) : the_post(); ?>
      <a href="<?php the_permalink(); ?>" class="card group overflow-hidden">
        <div style="padding:20px 0; display:flex; align-items:center; justify-content:center; background:#f5f0e8;">
          <?php the_post_thumbnail('medium', array('class' => 'h-auto mx-auto', 'style' => 'max-width:60%;')); ?>
        </div>
        <div class="px-5 py-3">
          <h2 class="font-bold text-base mb-1" style="color:var(--navy)"><?php the_title(); ?></h2>
          <span class="text-xs font-bold uppercase tracking-wider" style="color:var(--gold)">Ver livro →</span>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
</main>

<?php get_footer(); ?>
