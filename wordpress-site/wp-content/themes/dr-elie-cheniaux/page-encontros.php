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
    $imgs = get_theme_mod('dec_encontros_preview', array());
    foreach ($imgs as $img) :
        $caption = pathinfo($img['src'], PATHINFO_FILENAME);
    ?>
      <article class="card reveal">
        <div class="thumb">
          <img src="<?php echo esc_url(get_template_directory_uri() . '/img/' . $img['src']); ?>" alt="<?php echo esc_attr($caption); ?>" class="w-full h-auto">
        </div>
        <p class="text-gray-400 text-xs leading-relaxed p-3"><?php echo esc_html($caption); ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</main>

<?php endwhile; get_footer(); ?>
