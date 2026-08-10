<?php get_header(); ?>

<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span><span style="color:var(--navy);font-weight:700">Palestras</span>
    </div>
    <h1 class="text-4xl lg:text-5xl font-bold" style="color:var(--navy)">Palestras</h1>
  </div>
</section>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <div id="cards-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php while (have_posts()) : the_post(); ?>
      <article class="card reveal">
        <?php if (has_post_thumbnail()) : ?>
          <div class="thumb"><?php the_post_thumbnail('medium', array('class' => 'w-full h-auto')); ?></div>
        <?php endif; ?>
        <div class="p-5">
          <h2 class="font-bold text-lg mb-2" style="color:var(--navy)"><?php the_title(); ?></h2>
          <?php if (get_the_excerpt()) : ?><p class="text-gray-400 text-sm leading-relaxed"><?php the_excerpt(); ?></p><?php endif; ?>
        </div>
      </article>
    <?php endwhile; ?>
  </div>
</main>

<?php get_footer(); ?>
