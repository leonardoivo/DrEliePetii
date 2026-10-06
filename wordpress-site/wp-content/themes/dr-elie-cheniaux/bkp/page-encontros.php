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
  </div>
</section>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <?php if (trim(get_the_content()) !== '') : ?>
    <div class="reveal mb-10 text-gray-500 prose max-w-none"><?php the_content(); ?></div>
  <?php endif; ?>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php foreach (dec_encontros_imgs(get_the_ID()) as $img) : ?>
      <article class="card reveal">
        <div class="thumb">
          <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['caption']); ?>" class="w-full h-auto">
        </div>
        <p class="text-gray-400 text-xs leading-relaxed p-3"><?php echo esc_html($img['caption']); ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</main>

<?php endwhile; get_footer(); ?>
