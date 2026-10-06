<?php
/* Template Name: Quem sou eu — Discurso AMRJ */
get_header();
while (have_posts()) : the_post();
?>
<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span>
      <a href="<?php echo esc_url(dec_page_url('biografia')); ?>">Quem sou eu</a><span class="text-gray-400">›</span>
      <span style="color:var(--navy);font-weight:700">Discurso de Posse na AMRJ</span>
    </div>
    <div class="flex items-center gap-8">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/img/Discursando.jpg'); ?>" alt="Discurso de Posse" class="w-40 h-40 border-4 object-cover flex-shrink-0 rounded shadow-lg" style="border-color:var(--gold);">
      <div>
        <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color:var(--gold)">Quem sou eu</p>
        <h1 class="text-4xl lg:text-5xl font-bold mb-2" style="color:var(--navy)"><?php the_title(); ?></h1>
        <p class="text-gray-500 text-xl">Academia de Medicina do Rio de Janeiro</p>
      </div>
    </div>
  </div>
</section>

<div class="bg-white border-b border-gray-100 sticky top-[62px] z-40 shadow-sm">
  <div class="max-w-screen-lg mx-auto px-6 flex overflow-x-auto">
    <a href="<?php echo esc_url(dec_page_url('biografia')); ?>" class="tab-link">👤 Biografia</a>
    <a href="<?php echo esc_url(dec_page_url('bipolab')); ?>" class="tab-link">🧠 BiPoLaB</a>
    <a href="<?php echo esc_url(dec_page_url('curriculo')); ?>" class="tab-link">🎓 Currículo Lattes</a>
    <a href="<?php echo esc_url(dec_page_url('discurso')); ?>" class="tab-link active">🏛️ Discurso AMRJ</a>
    <a href="<?php echo esc_url(dec_page_url('memorial')); ?>" class="tab-link">📜 Memorial</a>
  </div>
</div>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <div class="reveal"><?php the_content(); ?></div>
</main>

<?php endwhile; get_footer(); ?>
