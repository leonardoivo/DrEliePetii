<?php
/* Template Name: Quem sou eu — Memorial */
get_header();
while (have_posts()) : the_post();
?>
<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span>
      <a href="<?php echo esc_url(dec_page_url('biografia')); ?>">Quem sou eu</a><span class="text-gray-400">›</span>
      <span style="color:var(--navy);font-weight:700">Memorial</span>
    </div>
    <div class="flex items-start gap-6">
      <div class="border-4 flex-shrink-0" style="border-color:var(--gold); width:245px; height:130px; max-width:100%; overflow:hidden;">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/carreira-16.jpg'); ?>" alt="Memorial" class="w-full h-full object-cover">
      </div>
      <div>
        <p class="text-xs font-bold uppercase tracking-widest mb-1" style="color:var(--gold)">Quem sou eu</p>
        <h1 class="text-4xl lg:text-5xl font-bold mb-3" style="color:var(--navy)"><?php the_title(); ?></h1>
      </div>
    </div>
  </div>
</section>

<div class="bg-white border-b border-gray-100 sticky top-[62px] z-40 shadow-sm">
  <div class="max-w-screen-lg mx-auto px-6 flex overflow-x-auto">
    <a href="<?php echo esc_url(dec_page_url('biografia')); ?>" class="tab-link">👤 Biografia</a>
    <a href="<?php echo esc_url(dec_page_url('bipolab')); ?>" class="tab-link">🧠 BiPoLaB</a>
    <a href="<?php echo esc_url(dec_page_url('curriculo')); ?>" class="tab-link">🎓 Currículo Lattes</a>
    <a href="<?php echo esc_url(dec_page_url('discurso')); ?>" class="tab-link">🏛️ Discurso AMRJ</a>
    <a href="<?php echo esc_url(dec_page_url('memorial')); ?>" class="tab-link active">📜 Memorial</a>
  </div>
</div>

<main class="max-w-screen-lg mx-auto px-6 py-14">
  <div class="reveal"><?php the_content(); ?></div>
  <div class="reveal">
    <iframe height="700px" src="<?php echo esc_url(get_template_directory_uri() . '/pdf/Memorial_para_AMRJ.pdf#toolbar=1'); ?>" style="border:1px solid #e5e7eb; border-radius:6px;" width="100%">
      <p>Seu navegador não suporta exibição de PDF.</p>
    </iframe>
    <div class="flex gap-4 flex-wrap mt-6">
      <a class="inline-flex items-center gap-2 px-6 py-3 rounded font-bold text-sm uppercase tracking-wide border-2 transition-all" href="<?php echo esc_url(dec_page_url('biografia')); ?>" style="border-color:var(--navy);color:var(--navy)">← Ver Biografia</a>
    </div>
  </div>
</main>

<?php endwhile; get_footer(); ?>
