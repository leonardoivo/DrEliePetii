<?php
get_header();

$tipos = array(
    'jornais' => array('label' => 'Jornais', 'emoji' => '📰', 'titulo' => 'Jornais', 'desc' => '', 'img' => 'tenha-os-principais-jornais-do-pais-no-seu-bolso.png'),
    'tv'      => array('label' => 'TV', 'emoji' => '📺', 'titulo' => 'Televisão', 'desc' => 'Participações e entrevistas em programas de televisão', 'img' => 'entrevista-jo.avif'),
    'podcast' => array('label' => 'Podcast', 'emoji' => '🎙️', 'titulo' => 'Podcasts', 'desc' => 'Episódios e participações em podcasts nacionais e internacionais', 'img' => 'Entrevistas podcast.jpg'),
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

$filtros = array();
foreach ($entrevistas as $e) {
    $terms = wp_get_post_terms($e->ID, 'entrevista_filtro');
    foreach ($terms as $t) {
        $filtros[$t->slug] = $t->name;
    }
}
?>

<section class="page-hero py-14">
  <div class="max-w-screen-lg mx-auto px-6">
    <div class="breadcrumb text-sm mb-6 flex items-center gap-2">
      <a href="<?php echo esc_url(home_url('/')); ?>">Início</a><span class="text-gray-400">›</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('entrevista')); ?>" class="text-gray-400">Entrevistas</a><span class="text-gray-400">›</span>
      <span style="color:var(--navy);font-weight:700"><?php echo esc_html($tipo_info['label']); ?></span>
    </div>
    <div class="flex items-center gap-5">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/img/' . $tipo_info['img']); ?>" alt="<?php echo esc_attr($tipo_info['label']); ?>" class="w-32 h-32 border-4 object-cover flex-shrink-0 rounded shadow-lg" style="border-color:var(--gold);">
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

  <?php if ($filtros) : ?>
    <div class="flex flex-wrap gap-2 mb-8">
      <button class="filter-btn active" onclick="filterCat(this,'todos')" style="background:var(--navy);color:white;">Todos</button>
      <?php foreach ($filtros as $slug => $name) : ?>
        <button class="filter-btn" onclick="filterCat(this,'<?php echo esc_attr($slug); ?>')"><?php echo esc_html($name); ?></button>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div id="cards-grid" class="grid sm:grid-cols-2 <?php echo $tipo_atual === 'jornais' ? '' : 'lg:grid-cols-3'; ?> gap-6">
    <?php foreach ($entrevistas as $e) :
        $terms = wp_get_post_terms($e->ID, 'entrevista_filtro', array('fields' => 'slugs'));
        $cat = !is_wp_error($terms) && !empty($terms) ? $terms[0] : '';
        $veiculo = get_post_meta($e->ID, 'entrevista_veiculo', true);
        $link = get_post_meta($e->ID, 'entrevista_link', true);
        $data = get_post_meta($e->ID, 'entrevista_data', true);
    ?>
      <?php if ($tipo_atual === 'podcast') : ?>
        <article class="pod-card reveal" data-cat="<?php echo esc_attr($cat); ?>">
          <div class="pod-cover" style="background:linear-gradient(135deg,var(--navy),var(--gold));">🎙️</div>
          <div class="p-5">
            <?php if ($veiculo) : ?><span class="tag" style="background:#f3f0e8;color:var(--navy);"><?php echo esc_html($veiculo); ?></span><?php endif; ?>
            <h3 class="font-bold text-base mt-2 mb-1" style="color:var(--navy)"><?php echo esc_html(get_the_title($e)); ?></h3>
            <p class="text-gray-400 text-xs leading-relaxed mb-4"><?php echo esc_html(get_the_excerpt($e)); ?></p>
            <?php if ($link) : ?><a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener" class="stream-btn" style="background:var(--navy);color:white;">▶ Ouvir</a><?php endif; ?>
          </div>
        </article>
      <?php else : ?>
        <article class="card reveal" data-cat="<?php echo esc_attr($cat); ?>">
          <?php if (has_post_thumbnail($e)) : ?>
            <div class="thumb"><?php echo get_the_post_thumbnail($e, 'medium', array('class' => 'w-full h-auto')); ?></div>
          <?php endif; ?>
          <div class="p-6">
            <?php if ($veiculo) : ?><span class="tag" style="background:#f3f0e8;color:var(--navy);"><?php echo esc_html($veiculo); ?><?php echo $data ? ' · ' . esc_html($data) : ''; ?></span><?php endif; ?>
            <h3 class="font-bold text-lg mt-2 mb-1" style="color:var(--navy)"><?php echo esc_html(get_the_title($e)); ?></h3>
            <p class="text-gray-400 text-sm"><?php echo esc_html(get_the_excerpt($e)); ?></p>
            <?php if ($link) : ?><a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener" class="inline-block mt-3 text-xs font-bold uppercase tracking-wider" style="color:var(--gold)">Acessar →</a><?php endif; ?>
          </div>
        </article>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <?php if (!$entrevistas) : ?>
    <p class="text-center text-gray-400 py-14">Nenhuma entrevista cadastrada nesta categoria ainda.</p>
  <?php endif; ?>
  <div id="empty-state" class="text-center text-gray-400 py-14 hidden">Nenhum resultado para este filtro.</div>
</main>

<?php get_footer(); ?>
