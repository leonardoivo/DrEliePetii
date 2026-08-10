<!-- ══════════════════ FOOTER ══════════════════ -->
<footer class="py-10">
  <div class="max-w-screen-lg mx-auto px-6 text-center">
    <p class="font-display text-xl font-bold mb-2" style="font-family:'Playfair Display',serif; color:var(--gold-light)"><?php bloginfo('name'); ?></p>
    <p class="text-sm text-blue-200 mb-6">Psiquiatra · Professor universitário · Escritor</p>
    <div class="flex justify-center gap-6 text-sm text-blue-300 mb-6 flex-wrap">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-white transition-colors">Início</a>
      <a href="<?php echo esc_url(dec_page_url('biografia')); ?>" class="hover:text-white transition-colors">Biografia</a>
      <a href="<?php echo esc_url(get_post_type_archive_link('livro')); ?>" class="hover:text-white transition-colors">Livros</a>
      <a href="<?php echo esc_url(get_post_type_archive_link('artigo')); ?>" class="hover:text-white transition-colors">Artigos</a>
      <a href="<?php echo esc_url(get_post_type_archive_link('entrevista')); ?>" class="hover:text-white transition-colors">Entrevistas</a>
      <a href="<?php echo esc_url(home_url('/') . '#contato'); ?>" class="hover:text-white transition-colors">Contato</a>
    </div>
    <p class="text-xs text-blue-400">© <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. Todos os direitos reservados.</p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
