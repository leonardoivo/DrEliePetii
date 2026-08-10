<?php
get_header();
?>
<main class="max-w-screen-lg mx-auto px-6 py-14">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article class="card p-8 mb-6">
      <h2 class="section-heading text-2xl font-bold mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="text-gray-500"><?php the_excerpt(); ?></div>
    </article>
  <?php endwhile; else : ?>
    <p>Nada encontrado.</p>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
