<?php
get_header();

$tipos = array(
    'jornais' => array('label' => 'Jornais', 'emoji' => '📰', 'titulo' => 'Jornais', 'desc' => '', 'img' => 'tenha-os-principais-jornais-do-pais-no-seu-bolso.png', 'opt' => 'entrevistas_jornais'),
    'tv'      => array('label' => 'TV', 'emoji' => '📺', 'titulo' => 'Televisão', 'desc' => 'Participações e entrevistas em programas de televisão', 'img' => 'entrevista-jo.avif', 'opt' => 'entrevistas_tv'),
    'podcast' => array('label' => 'Podcast', 'emoji' => '🎙️', 'titulo' => 'Podcasts', 'desc' => 'Episódios e participações em podcasts nacionais e internacionais', 'img' => 'Entrevistas podcast.jpg', 'opt' => 'entrevistas_podcast'),
);
$tipo_atual = isset($_GET['tipo']) && isset($tipos[$_GET['tipo']]) ? sanitize_key($_GET['tipo']) : 'jornais';
$tipo_info = $tipos[$tipo_atual];

$entrevistas = get_posts(array(
    'post_type' => 'entrevista',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        array('taxonomy' => 'entrevista_tipo', 'field' => 'slug', 'terms' => $tipo_atual),
    ),
));

$ctas = array('jornais' => 'Acessar →', 'tv' => 'Acessar →', 'podcast' => 'Assistir →');
?>

<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('entrevista')); ?>" class="text-gray-400">Entrevistas</a><span class="text-gray-400">›</span>
      <span style="color:var(--navy);font-weight:700"><?php echo esc_html($tipo_info['label']); ?></span>
    </div>
    <div class="flex items-center gap-5">
      <img src="<?php echo esc_url(dec_media_url_fallback(array(dec_opt($tipo_info['opt']), $tipo_info['img']))); ?>" alt="<?php echo esc_attr($tipo_info['label']); ?>" class="w-32 h-32 border-4 object-cover flex-shrink-0 rounded shadow-lg" style="border-color:var(--gold);">
      <div>
        <p class="text-xs font-bold uppercase tracking-widest mb-1" style="color:var(--gold)">Entrevistas</p>
        <h1 class="text-4xl lg:text-5xl font-bold" style="color:var(--navy)"><?php echo esc_html($tipo_info['titulo']); ?></h1>
        <?php if ($tipo_info['desc']) : ?><p class="text-gray-400 mt-2"><?php echo esc_html($tipo_info['desc']); ?></p><?php endif; ?>
      </div>
    </div>
  </div>
</section>

<div class="bg-white border-b border-gray-100">
  <div class="max-w-screen-lg mx-auto px-6 flex overflow-x-auto">
    <?php foreach ($tipos as $slug => $info) :
        $url = add_query_arg('tipo', $slug, get_post_type_archive_link('entrevista'));
    ?>
      <a href="<?php echo esc_url($url); ?>" class="tab-link <?php echo $slug === $tipo_atual ? 'active' : ''; ?>"><?php echo $info['emoji']; ?> <?php echo esc_html($info['label']); ?></a>
    <?php endforeach; ?>
  </div>
</div>

<main class="max-w-screen-lg mx-auto px-6 py-14">

  <div class="space-y-4">
    <?php foreach ($entrevistas as $e) :
        $veiculo = get_post_meta($e->ID, 'entrevista_veiculo', true);
        $link = get_post_meta($e->ID, 'entrevista_link', true);
        $data = get_post_meta($e->ID, 'entrevista_data', true);
    ?>
      <article class="card p-6 flex gap-6 items-start reveal">
        <div class="text-3xl"><?php echo $tipo_info['emoji']; ?></div>
        <div class="flex-1">
          <?php if ($veiculo) : ?><span class="tag" style="background:#f3f0e8;color:var(--navy);"><?php echo esc_html($veiculo); ?><?php echo $data ? ' · ' . esc_html($data) : ''; ?></span><?php endif; ?>
          <h2 class="font-bold text-lg mt-2 mb-1" style="color:var(--navy)"><?php echo esc_html(get_the_title($e)); ?></h2>
          <?php if (get_the_excerpt($e)) : ?><p class="text-gray-400 text-sm leading-relaxed"><?php echo esc_html(get_the_excerpt($e)); ?></p><?php endif; ?>
          <?php if ($link) : ?><a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener" class="inline-block mt-3 text-xs font-bold uppercase tracking-wider" style="color:var(--gold)"><?php echo esc_html($ctas[$tipo_atual]); ?></a><?php endif; ?>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <?php if (!$entrevistas) : ?>
    <p class="text-center text-gray-400 py-14">Nenhuma entrevista cadastrada nesta categoria ainda.</p>
  <?php endif; ?>
  <div id="empty-state" class="text-center text-gray-400 py-14 hidden">Nenhum resultado para este filtro.</div>
</main>

<?php get_footer(); ?>
