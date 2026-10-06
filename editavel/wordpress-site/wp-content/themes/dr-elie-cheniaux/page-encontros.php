<?php
/* Template Name: Encontros Especiais */
get_header();
while (have_posts()) : the_post();
?>
<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span><span style="color:var(--navy);font-weight:700">Encontros Especiais</span>
    </div>
    <h1 class="text-4xl lg:text-5xl font-bold" style="color:var(--navy)"><?php the_title(); ?></h1>
    <?php if (get_the_content()) : ?><div class="mt-4 text-gray-500"><?php the_content(); ?></div><?php endif; ?>
  </div>
</section>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php
    $encontros_posts = get_posts(array(
        'post_type' => 'encontro',
        'posts_per_page' => -1,
        'orderby' => 'menu_order date',
        'order' => 'ASC',
    ));
    foreach ($encontros_posts as $ep) :
        $caption = get_the_title($ep);
    ?>
      <article class="card reveal">
        <div class="thumb">
          <img src="<?php echo esc_url(get_the_post_thumbnail_url($ep, 'large')); ?>" alt="<?php echo esc_attr($caption); ?>" class="w-full h-auto">
        </div>
        <p class="text-gray-400 text-xs leading-relaxed p-3"><?php echo esc_html($caption); ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</main>

<?php endwhile; get_footer(); ?>
