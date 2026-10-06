<?php
/* Template Name: BiPoLaB */
get_header();
while (have_posts()) : the_post();
?>
<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span>
      <a href="<?php echo esc_url(dec_page_url('biografia')); ?>">Quem sou eu</a><span class="text-gray-400">›</span>
      <span style="color:var(--navy);font-weight:700">BiPoLaB</span>
    </div>
    <div class="flex items-center gap-5">
      <img src="<?php echo esc_url(dec_media_url_fallback(array(dec_opt('foto_bipolab'), 'logodoBiPoLaB.jpg'))); ?>" alt="BiPoLaB" class="w-32 h-32 border-4 object-cover flex-shrink-0" style="border-color:var(--gold);">
      <h1 class="text-4xl lg:text-5xl font-bold" style="color:var(--navy)"><?php the_title(); ?></h1>
    </div>
  </div>
</section>

<div class="bg-white border-b border-gray-100 sticky top-[62px] z-40 shadow-sm">
  <div class="max-w-screen-lg mx-auto px-6 flex overflow-x-auto">
    <a href="<?php echo esc_url(dec_page_url('biografia')); ?>" class="tab-link">👤 Biografia</a>
    <a href="<?php echo esc_url(dec_page_url('bipolab')); ?>" class="tab-link active">🧠 BiPoLaB</a>
    <a href="<?php echo esc_url(dec_page_url('curriculo')); ?>" class="tab-link">🎓 Currículo Lattes</a>
    <a href="<?php echo esc_url(dec_page_url('discurso')); ?>" class="tab-link">🏛️ Discurso AMRJ</a>
    <a href="<?php echo esc_url(dec_page_url('memorial')); ?>" class="tab-link">📜 Memorial</a>
  </div>
</div>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <div class="reveal"><?php the_content(); ?></div>
</main>

<?php endwhile; get_footer(); ?>
