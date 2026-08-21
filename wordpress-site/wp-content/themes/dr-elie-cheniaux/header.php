<!DOCTYPE html>
<html lang="pt-BR" <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white'); ?>>
<?php wp_body_open(); ?>

<?php $dec_nav = dec_get_nav_items(); ?>

<!-- ══════════════════ NAVBAR ══════════════════ -->
<nav id="main-nav" class="shadow-sm">
  <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between">
    <div class="flex items-center gap-2 flex-shrink-0 mr-6">
      <img src="<?php echo esc_url(get_template_directory_uri() . '/img/DrElieLogo.avif'); ?>" alt="Logo" class="w-10 h-10 border-2" style="border-color:var(--gold);"/>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo text-xl py-4 font-bold"><?php bloginfo('name'); ?></a>
    </div>

    <div class="hidden lg:flex items-center flex-wrap justify-end">
      <?php if (!is_front_page()) : ?>
        <div class="nav-item"><a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link">Início</a></div>
      <?php endif; ?>
      <?php foreach ($dec_nav as $item) : ?>
        <div class="nav-item">
          <a href="<?php echo esc_url($item['href']); ?>" class="nav-link" <?php echo !empty($item['external']) ? 'target="_blank" rel="noopener"' : ''; ?>>
            <?php echo esc_html($item['label']); ?>
            <?php if (!empty($item['children'])) : ?>
              <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            <?php endif; ?>
          </a>
          <?php if (!empty($item['children'])) : ?>
            <div class="dropdown">
              <?php foreach ($item['children'] as $child) : ?>
                <a href="<?php echo esc_url($child['href']); ?>" <?php echo !empty($child['external']) ? 'target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($child['label']); ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
      <div class="nav-item"><a href="<?php echo esc_url(home_url('/') . '#contato'); ?>" class="nav-link">Contato</a></div>
    </div>

    <button id="hamburger" class="lg:hidden flex flex-col gap-1.5 p-2" aria-label="Abrir menu">
      <span class="block w-6 h-0.5 bg-gray-700"></span>
      <span class="block w-6 h-0.5 bg-gray-700"></span>
      <span class="block w-6 h-0.5 bg-gray-700"></span>
    </button>
  </div>
</nav>

<!-- ══════════════════ MOBILE MENU ══════════════════ -->
<div id="mobile-menu">
  <button id="close-menu" class="absolute top-5 right-6 text-3xl text-gray-600" aria-label="Fechar menu">&times;</button>
  <?php if (!is_front_page()) : ?>
    <div class="mob-section"><a class="mob-link" href="<?php echo esc_url(home_url('/')); ?>">Início</a></div>
  <?php endif; ?>
  <?php foreach ($dec_nav as $key => $item) : ?>
    <div class="mob-section">
      <?php if (!empty($item['children'])) : ?>
        <div class="mob-link" onclick="toggleMob('mob-<?php echo esc_attr($key); ?>')"><?php echo esc_html($item['label']); ?> ▾</div>
        <div id="mob-<?php echo esc_attr($key); ?>" class="mob-sub">
          <?php foreach ($item['children'] as $child) : ?>
            <a href="<?php echo esc_url($child['href']); ?>" <?php echo !empty($child['external']) ? 'target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($child['label']); ?></a>
          <?php endforeach; ?>
        </div>
      <?php else : ?>
        <a class="mob-link" href="<?php echo esc_url($item['href']); ?>" <?php echo !empty($item['external']) ? 'target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($item['label']); ?></a>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
  <div class="mob-section"><a class="mob-link" href="<?php echo esc_url(home_url('/') . '#contato'); ?>">Contato</a></div>
</div>
