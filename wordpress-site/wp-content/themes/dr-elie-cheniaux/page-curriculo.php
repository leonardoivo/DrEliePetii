<?php
/* Template Name: Quem sou eu — Currículo Lattes */
get_header();
while (have_posts()) : the_post();
?>
<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span><span style="color:var(--navy);font-weight:700">Currículo Lattes</span>
    </div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
      <h1 class="text-4xl lg:text-5xl font-bold" style="color:var(--navy)"><?php the_title(); ?></h1>
      <a href="https://lattes.cnpq.br/4838737347351092" target="_blank" class="inline-flex items-center gap-3 px-6 py-3 rounded font-bold text-sm uppercase tracking-wide shadow-md flex-shrink-0" style="background:var(--navy);color:white"><span>🎓</span> Acessar Lattes CNPq</a>
    </div>
  </div>
</section>

<div class="bg-white border-b border-gray-100 sticky top-[62px] z-40 shadow-sm">
  <div class="max-w-screen-lg mx-auto px-6 flex overflow-x-auto">
    <a href="<?php echo esc_url(dec_page_url('biografia')); ?>" class="tab-link">👤 Biografia</a>
    <a href="<?php echo esc_url(dec_page_url('curriculo')); ?>" class="tab-link active">🎓 Currículo Lattes</a>
    <a href="<?php echo esc_url(dec_page_url('discurso')); ?>" class="tab-link">🏛️ Discurso AMRJ</a>
    <a href="<?php echo esc_url(dec_page_url('memorial')); ?>" class="tab-link">📜 Memorial</a>
  </div>
</div>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <div class="reveal"><?php the_content(); ?></div>
</main>

<?php endwhile; get_footer(); ?>
