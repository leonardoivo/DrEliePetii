<?php
/* Template Name: Quem sou eu — Biografia */
get_header();
while (have_posts()) : the_post();
?>
<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span>
      <a href="<?php echo esc_url(dec_page_url('biografia')); ?>">Quem sou eu</a><span class="text-gray-400">›</span>
      <span style="color:var(--navy);font-weight:700">Biografia</span>
    </div>
    <div class="flex flex-col md:flex-row items-start md:items-center gap-8">
      <div class="flex-1">
        <p class="text-xs font-bold uppercase tracking-widest mb-1" style="color:var(--gold)">Quem sou eu</p>
        <h1 class="text-4xl lg:text-5xl font-bold mb-3" style="color:var(--navy)"><?php the_title(); ?></h1>
      </div>
      <div class="flex justify-center">
        <div class="w-72 h-72 lg:w-80 lg:h-80 overflow-hidden border-4 shadow-2xl flex-shrink-0" style="border-color: var(--gold-light);">
          <img src="<?php echo esc_url(get_template_directory_uri() . '/img/dr-elie.jpg'); ?>" alt="Foto de <?php bloginfo('name'); ?>" class="object-cover w-full h-full" style="object-position: top center;">
        </div>
      </div>
    </div>
  </div>
</section>

<div class="bg-white border-b border-gray-100 sticky top-[62px] z-40 shadow-sm">
  <div class="max-w-screen-lg mx-auto px-6 flex overflow-x-auto">
    <a href="<?php echo esc_url(dec_page_url('biografia')); ?>" class="tab-link active">👤 Biografia</a>
    <a href="<?php echo esc_url(dec_page_url('curriculo')); ?>" class="tab-link">🎓 Currículo Lattes</a>
    <a href="<?php echo esc_url(dec_page_url('discurso')); ?>" class="tab-link">🏛️ Discurso AMRJ</a>
    <a href="<?php echo esc_url(dec_page_url('memorial')); ?>" class="tab-link">📜 Memorial</a>
  </div>
</div>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <div class="reveal"><?php the_content(); ?></div>
</main>

<?php endwhile; get_footer(); ?>
