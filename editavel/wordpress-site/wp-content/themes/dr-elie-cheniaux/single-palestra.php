<?php
get_header();
while (have_posts()) : the_post();
?>
    <section class="page-hero py-14">
      <div class="max-w-screen-lg mx-auto px-6">
        <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
          <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span>
          <a href="<?php echo esc_url(get_post_type_archive_link('palestra')); ?>">Palestras</a><span class="text-gray-400">›</span>
          <span style="color:var(--navy);font-weight:700"><?php the_title(); ?></span>
        </div>
        <h1 class="text-4xl lg:text-5xl font-bold" style="color:var(--navy)"><?php the_title(); ?></h1>
      </div>
    </section>
    <main class="max-w-screen-lg mx-auto px-6 py-14">
      <?php if (has_post_thumbnail()) : ?><div class="mb-6"><?php the_post_thumbnail('large', array('class' => 'w-full h-auto rounded')); ?></div><?php endif; ?>
      <div class="prose text-gray-600 leading-relaxed"><?php the_excerpt(); ?></div>
      <div class="mt-10"><a href="<?php echo esc_url(get_post_type_archive_link('palestra')); ?>" class="btn-outline">← Voltar às Palestras</a></div>
    </main>
<?php endwhile; get_footer(); ?>
