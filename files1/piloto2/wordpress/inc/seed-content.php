<?php
/**
 * Seeds the site with the real content migrated from the original static
 * site, the first time the theme is activated. Idempotent: guarded by the
 * "dec_seeded" option, so it never overwrites content that already exists
 * (e.g. content an editor has since changed by hand).
 */

if (!defined('ABSPATH')) {
    exit;
}

function dec_seed_content() {
    if (get_option('dec_seeded')) {
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    dec_seed_pages();
    dec_seed_livros();
    dec_seed_artigos();
    dec_seed_entrevistas();
    dec_seed_palestras();
    dec_seed_encontros_gallery();

    update_option('dec_seeded', 1);
}
add_action('after_switch_theme', 'dec_seed_content');

/**
 * Imports an image bundled in the theme's /img folder into the Media
 * Library and returns the attachment ID (or 0 on failure).
 */
function dec_import_theme_image($filename, $title = '') {
    static $cache = array();
    if (isset($cache[$filename])) {
        return $cache[$filename];
    }
    $path = get_template_directory() . '/img/' . $filename;
    if (!file_exists($path)) {
        return 0;
    }
    $filetype = wp_check_filetype(basename($path), null);
    $upload = wp_upload_bits(basename($path), null, file_get_contents($path));
    if (!empty($upload['error'])) {
        return 0;
    }
    $attachment = array(
        'post_mime_type' => $filetype['type'],
        'post_title' => $title ?: sanitize_file_name(basename($path)),
        'post_content' => '',
        'post_status' => 'inherit',
    );
    $attach_id = wp_insert_attachment($attachment, $upload['file']);
    $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
    wp_update_attachment_metadata($attach_id, $attach_data);
    $cache[$filename] = $attach_id;
    return $attach_id;
}


function dec_seed_pages() {
    $pages = array(
    'biografia' => array(
        'title' => 'Biografia',
        'content' => '
<div class="grid lg:grid-cols-3 gap-12">
<!-- Main text -->
<div class="lg:col-span-2 space-y-10">
<!-- Intro -->
<div class="reveal">
<div class="prose">
<ul class="list-disc list-inside space-y-2">
<li>Professor Titular de psiquiatria da Faculdade de Ciências Médicas da Universidade do Estado do Rio de Janeiro (FCM-UERJ)    
  <br/><a href="https://fcm.uerj.br/dem" target="_blank">https://fcm.uerj.br/dem</a></li>
<li>Médico graduado pela Universidade do Estado do Rio de Janeiro, especialista em psiquiatria pela Associação Brasileira de Psiquiatria (ABP) <br/><a href="https://www.abp.org.br/lista-de-psiquiatras" target="_blank">https://www.abp.org.br/lista-de-psiquiatras</a></li>
<li>RQE: 9397 (CREMERJ) Especialista em Psiquiatria <br/><a href="https://portal.cremerj.org.br/busca-medicos" target="_blank">https://portal.cremerj.org.br/busca-medicos</a></li>
<li>Ex-professor do Programa de Pós-graduação em Psiquiatria e Saúde Mental da Universidade Federal do Rio de Janeiro (PROPSAM-IPUB-UFRJ) <a href="https://propsam.ipub.ufrj.br" target="_blank">https://propsam.ipub.ufrj.br</a></li>
<li>Coordenador do Laboratório de Pesquisa em Transtorno Bipolar (BiPoLaB), vinculado ao Programa de Pós-Graduação em Ciências Médicas da UERJ <a href="https://www.pgcm.uerj.br/administracao/src/view/action/SiteAction.php" target="_blank">https://www.pgcm.uerj.br/administracao/src/view/action/SiteAction.php</a></li>
<li>Membro titular da Academia de Medicina do Rio de Janeiro (AMRJ), cadeira 56 <a href="https://amrj.org.br/membro-amrj/elie-cheniaux-junior/" target="_blank">https://amrj.org.br/membro-amrj/elie-cheniaux-junior/</a></li>
<li>Membro titular da Academia Brasileira de Médicos Escritores (ABRAMES), cadeira 30 <a href="https://www.abrames.com.br/2022/01/cadeira-30.html" target="_blank">https://www.abrames.com.br/2022/01/cadeira-30.html</a></li>
<li>Médico (aposentado) do Instituto de Psiquiatria da UFRJ (IPUB) <a href="https://www.ipub.ufrj.br/" target="_blank">https://www.ipub.ufrj.br/</a></li>
<li>Mestre e doutor em psiquiatria e saúde mental (PROPSAM-IPUB-UFRJ)</li>
<li>Com pós-doutorado pela COPPE/UFRJ &amp; PUC-Rio</li>
<li>Psicanalista, membro licenciado da Sociedade Psicanalítica do Rio de Janeiro (SPRJ) <a href="https://sprj.org.br/site/" target="_blank">https://sprj.org.br/site/</a></li>
</ul>
</div>
</div>
<!-- Timeline -->
</div>
<!-- Sidebar -->
<aside class="space-y-6">
<!-- Quick facts -->
<!-- Navigation cards -->
<div class="reveal">
<h3 class="font-bold text-xs uppercase tracking-widest text-gray-400 mb-3">Continuar lendo</h3>
<div class="space-y-3">
<a class="flex items-center gap-3 bg-white rounded shadow p-4 hover:shadow-md transition-shadow" href="quem-sou-eu-curriculo.html">
<span class="text-2xl">🎓</span>
<div><div class="font-bold text-sm" style="color:var(--navy)">Currículo Lattes</div><div class="text-xs text-gray-400">Produção acadêmica completa</div></div>
</a>
<a class="flex items-center gap-3 bg-white rounded shadow p-4 hover:shadow-md transition-shadow" href="quem-sou-eu-discurso.html">
<span class="text-2xl">🏛️</span>
<div><div class="font-bold text-sm" style="color:var(--navy)">Discurso na AMRJ</div><div class="text-xs text-gray-400">Leia o discurso de posse</div></div>
</a>
<a class="flex items-center gap-3 bg-white rounded shadow p-4 hover:shadow-md transition-shadow" href="quem-sou-eu-memorial.html">
<span class="text-2xl">📜</span>
<div><div class="font-bold text-sm" style="color:var(--navy)">Memorial</div><div class="text-xs text-gray-400">Reflexões e memórias</div></div>
</a>
</div>
</div>
</aside>
</div>
',
    ),
    'curriculo' => array(
        'title' => 'Currículo Lattes',
        'content' => '
<!-- Accordion sections -->
<div class="reveal">
<iframe height="700px" src="https://lattes.cnpq.br/4838737347351092" style="border:1px solid #e5e7eb; border-radius:6px;" width="100%">
</iframe>
</div><!-- end accordion -->
<!-- Lattes CTA -->
<div class="mt-10 bg-white rounded shadow p-8 text-center reveal">
<div class="text-4xl mb-4">🎓</div>
<h3 class="text-xl font-bold mb-2" style="color:var(--navy)">Currículo Lattes</h3>
<p class="text-gray-400 text-sm mb-6">Para acessar o currículo  e atualizado na plataforma CNPq, clique no botão abaixo.</p>
<a class="inline-block px-8 py-3 rounded font-bold text-sm uppercase tracking-wide transition-transform hover:-translate-y-1" href="https://lattes.cnpq.br/4838737347351092" style="background:var(--navy);color:white" target="_blank">Acessar Lattes CNPq →</a>
</div>
',
    ),
    'discurso' => array(
        'title' => 'Discurso de Posse na AMRJ',
        'content' => '
<div>
<!-- Speech text -->
<div>
<!-- Meta card -->
<div class="speech-meta mb-8 reveal">
<div class="grid sm:grid-cols-3 gap-6 text-sm">
<div><div class="text-blue-300 text-xs font-bold uppercase tracking-widest mb-1">Data</div><div class="font-bold">Setembro de 2019</div></div>
<div><div class="text-blue-300 text-xs font-bold uppercase tracking-widest mb-1">Local</div><div class="font-bold">Sede da AMRJ, Rio de Janeiro</div></div>
<div><div class="text-blue-300 text-xs font-bold uppercase tracking-widest mb-1">Cadeira</div><div class="font-bold">Nº 56 — Patrono: Dr. José de Paula Lopes Pontes</div></div>
</div>
</div>
<!-- Speech body -->
<article class="bg-white rounded shadow-sm px-8 py-10 reveal">
<div class="speech-body">
<div class="my-8">
<iframe height="700px" src="https://www.eliecheniaux.com/_files/ugd/8a0ecd_64a31554f015454994c770c0d0a5dc43.pdf#toolbar=0" style="border:1px solid #e5e7eb; border-radius:6px;" width="100%">
              &lt;p&gt;Seu navegador não suporta exibição de PDF.&lt;/p&gt;
            </iframe>
</div>
</div>
</article>
<!-- Download CTA -->
<div class="mt-6 flex gap-4 flex-wrap reveal">
</div>
</div>
</div>
',
    ),
    'memorial' => array(
        'title' => 'Memorial',
        'content' => '
<div>
<!-- Memorial text -->
<div>
<iframe height="700px" src="/wp-content/themes/dr-elie-cheniaux/pdf/Memorial_para_AMRJ.pdf#toolbar=0" style="border:1px solid #e5e7eb; border-radius:6px;" width="100%">
              &lt;p&gt;Seu navegador não suporta exibição de PDF.&lt;/p&gt;
            </iframe>
<!-- Download -->
<div class="flex gap-4 flex-wrap reveal">
<a class="inline-flex items-center gap-2 px-6 py-3 rounded font-bold text-sm uppercase tracking-wide border-2 transition-all" href="quem-sou-eu-biografia.html" style="border-color:var(--navy);color:var(--navy)">← Ver Biografia</a>
</div>
</div>
</div>
',
    ),
    'bipolab' => array(
        'title' => 'Sobre o BiPoLaB',
        'content' => '
<p>    O Laboratório de Pesquisa sobre o Transtorno Bipolar, o BiPoLaB, foi criado, em 2002, no Instituto de Psiquiatria da UFRJ, onde era vinculado ao Programa de Pós-Graduação em Psiquiatria e Saúde Mental (PROPSAM). Atualmente, está associado ao Programa de Pós-Graduação em Ciências Médicas (PGCM) da UERJ. Ele é coordenado pelos professores Elie Cheniaux e Estevão Scotti-Muzzi, que orientam ou supervisionam alunos de mestrado, doutorado, residência médica, especialização e iniciação científica. O BiPoLaB realiza estudos clínicos no ambulatório de psiquiatria do Hospital Universitário Pedro Ernesto (HUPE), nas sextas pela manhã, desde 2024.</p>
<!-- Lattes CTA -->
<div class="mt-10 bg-white rounded shadow p-8 text-center reveal">
</div>
',
    ),
);

    $templates = array(
        'biografia' => 'page-biografia.php',
        'curriculo' => 'page-curriculo.php',
        'discurso' => 'page-discurso.php',
        'memorial' => 'page-memorial.php',
        'bipolab' => 'page-bipolab.php',
    );

    foreach ($pages as $slug => $data) {
        if (get_page_by_path($slug)) {
            continue;
        }
        $post_id = wp_insert_post(array(
            'post_title' => $data['title'],
            'post_name' => $slug,
            'post_content' => $data['content'],
            'post_type' => 'page',
            'post_status' => 'publish',
        ));
        if ($post_id && isset($templates[$slug])) {
            update_post_meta($post_id, '_wp_page_template', $templates[$slug]);
        }
    }

    // Encontros especiais gallery page (no scraped body text; the template renders the gallery from a theme_mod).
    if (!get_page_by_path('encontros')) {
        wp_insert_post(array(
            'post_title' => 'Encontros Especiais',
            'post_name' => 'encontros',
            'post_content' => '',
            'post_type' => 'page',
            'post_status' => 'publish',
            'meta_input' => array('_wp_page_template' => 'page-encontros.php'),
        ));
    }
}


function dec_seed_livros() {
    if (get_posts(array('post_type' => 'livro', 'posts_per_page' => 1, 'post_status' => 'any'))) {
        return;
    }
    $livros = array(
    array(
        'slug' => 'livro-antifacebook-v2',
        'title' => 'O Antifacebook',
        'author' => 'Elie Cheniaux',
        'tagline' => 'Meus encontros e desencontros com Woody Allen, Hitchcock, Freud, Deus, o Flamengo, as mulheres e... comigo mesmo',
        'badges' => array(
            'Autoficção',
            'Crônica',
        ),
        'cover_img' => 'Livro O ANTIFACEBOOK.jpg',
        'endorsement' => '',
        'stats' => array(
            array(
                'icon' => '📝',
                'label' => 'Gênero',
                'value' => 'Autoficção, Crônica',
            ),
            array(
                'icon' => '📅',
                'label' => 'Ano',
                'value' => '2014',
            ),
            array(
                'icon' => '📖',
                'label' => 'Páginas',
                'value' => '77',
            ),
            array(
                'icon' => '🏢',
                'label' => 'Editora',
                'value' => 'Editora Prospectiva',
            ),
            array(
                'icon' => '🌐',
                'label' => 'Idioma',
                'value' => 'Português',
            ),
        ),
        'sinopse_paras' => array(
            '“O Antifacebook” apresenta 24 textos de humor, num formato de crônica, curtos e escritos em primeira pessoa. São narrados fatos da vida do autor - que não necessariamente ocorreram -, mas a ênfase está menos nos relatos do que nos comentários, marcados por uma alta dose de ironia – especialmente autoironia – e, vez por outra, algum lirismo.',
            'Os principais temas abordados são: amor, sexo e casamento; felicidade, solidão e autoestima; futebol e Flamengo; religião; psiquiatria e psicanálise; e cinema.',
            'Nas crônicas, vários personagens são recorrentes, sendo citados, cada um deles, exatamente 117 vezes.',
            'Alguns são reais, como Zico, Chico Buarque, Nelson Rodrigues, Woody Allen, Alfred Hitchcock e Scarlett Johansson; e outros são fictícios, como o general Waldick (“o adorável vizinho do 505”), Deise (“a sedutora colega do ensino médio”), a mãe, a ex-esposa, Deus e, o mais fictício de todos, o “eu”.',
        ),
        'tema_label' => '',
        'tema_tags' => array(
        ),
        'ficha' => array(
            'Autor' => 'Elie Cheniaux',
            'Editora' => 'Editora Prospectiva',
            'Ano' => '2014',
            'Páginas' => '77 p.',
            'Gênero' => 'Autoficção, Crônica',
            'Idioma' => 'Português',
            'Formato' => 'Impresso / eBook',
        ),
        'pull_quote' => 'Neste livro, apresento 24 crônicas curtas de humor, todas escritas em primeira pessoa. Nelas, narro episódios da minha própria vida — que não necessariamente aconteceram —, mas o foco não está tanto no que se passou, e sim nos meus comentários sobre cada situação. Tudo isso vem recheado com uma boa dose de ironia, muita autoironia e, de vez em quando, um toque de lirismo.',
        'pull_attr' => '— Elie Cheniaux, O Antifacebook',
        'prefacio' => '',
        'buy_cards' => array(
            array(
                'href' => 'https://www.amazon.com.br/s?k=cheniaux+o+antifacebook&i=stripbooks&__mk_pt_BR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=1RL1NQ5MLP50H&sprefix=cheniaux+o+antifacebook%2Cstripbooks%2C200&ref=nb_sb_nos',
                'tag' => 'Mais popular',
                'name' => 'Amazon Brasil',
                'desc' => 'Entrega rápida · Frete grátis Prime',
                'btn_text' => 'Comprar na Amazon →',
                'btn_bg' => '#ff9900',
                'icon_bg' => '#fff3cd',
            ),
            array(
                'href' => 'https://www.amazon.com.br/kindle-dbs/hz/subscribe/ku?ref=dbs_p_ebk_r00_pbcb_diupu0&passThroughAsin=B07X4JN9W4',
                'tag' => 'Versão digital',
                'name' => 'Kindle / eBook',
                'desc' => 'Leitura imediata · Qualquer dispositivo',
                'btn_text' => 'Baixar eBook →',
                'btn_bg' => '#0369a1',
                'icon_bg' => '#e0f2fe',
            ),
            array(
                'href' => 'https://www.soupro.com.br/web/index.php/livros/o-antifacebook',
                'tag' => 'Editora',
                'name' => 'Editora Prospectiva',
                'desc' => 'Seja pró!',
                'btn_text' => 'Comprar →',
                'btn_bg' => '#166534',
                'icon_bg' => '#f0fdf4',
            ),
            array(
                'href' => 'https://digitalizabrasil.com.br/e-books/o-antifacebook',
                'tag' => 'Livros Digitais',
                'name' => 'Digitaliza Brasil',
                'desc' => 'Conversão e distribuiçao de conteúdos digitais',
                'btn_text' => 'Buscar →',
                'btn_bg' => '#7e22ce',
                'icon_bg' => '#fdf4ff',
            ),
        ),
        'ctas' => array(
            array(
                'titulo' => 'Universidades e bibliotecas',
                'texto' => 'Interessado em adquirir exemplares para sua instituição? Entre em contato com o autor.',
                'btn_text' => 'Entrar em contato',
                'btn_href' => 'index.html#contato',
            ),
        ),
        'accent_vars' => array(
            'gold' => '#c9a84c',
            'gold-light' => '#e8d5a0',
            'navy' => '#1a4427',
            'accent' => '#1d4ed8',
            'accent-light' => '#dbeafe',
            'accent-dark' => '#1e3a8a',
        ),
    ),
    array(
        'slug' => 'livro-cinema-loucura-v2',
        'title' => 'Cinema e Loucura',
        'author' => 'Elie Cheniaux, J. Landeira-Fernandez',
        'tagline' => 'Conhecendo os Transtornos Mentais Através dos Filmes.',
        'badges' => array(
            'Não-ficção acadêmica / Científica',
        ),
        'cover_img' => 'Livro CINEMA E LOUCURA.jpg',
        'endorsement' => 'Prefácio de Ruy Castro · Escritor e biógrafo',
        'stats' => array(
            array(
                'icon' => '🎭',
                'label' => 'Não-ficção acadêmica/científica',
                'value' => '',
            ),
            array(
                'icon' => '📅',
                'label' => 'Ano',
                'value' => '2010',
            ),
            array(
                'icon' => '📖',
                'label' => 'Páginas',
                'value' => '288',
            ),
            array(
                'icon' => '🏢',
                'label' => 'Editora',
                'value' => 'ARTMED EDITORA',
            ),
            array(
                'icon' => '🎬',
                'label' => 'Filmes analisados',
                'value' => '+30 obras',
            ),
        ),
        'sinopse_paras' => array(
            'Cinema e Loucura Neste livro surpreendente, os autores se propuseram a uma tarefa pioneira: usar personagens de filmes clássicos e modernos para auxiliar o leitor a compreender os mecanismos dos transtornos mentais, criando uma obra de interesse não apenas aos estudantes de saúde mental, mas a todos aqueles apaixonados por cinema.',
        ),
        'tema_label' => 'Alguns filmes analisados na obra:',
        'tema_tags' => array(
            'A sombra do vulcão',
            'As loucuras do Rei George',
            'Contos proibidos do Marques de Sade',
            'Freud, Além da Alma',
            'Um Estranho no Ninho',
            'Bicho de 7 cabeças',
            'Amnesia',
            'Um salto para felicidade',
            'Memórias postumas',
            'As filhas de Marvin',
            'Meu nome é não é Johnny',
            '+ outros',
        ),
        'ficha' => array(
            'Autor' => 'Elie Cheniaux, J. Landeira-Fernandez',
            'Editora' => 'Artmed Editora',
            'Ano' => '2010',
            'Páginas' => '288 p.',
            'Gênero' => 'Não-ficção acadêmica/Científica',
            'Idioma' => 'Português',
            'Formato' => 'Impresso',
        ),
        'pull_quote' => '',
        'pull_attr' => '',
        'prefacio' => array(
            'nome' => 'Ruy Castro',
            'cargo' => 'Escritor, biógrafo e jornalista',
            'extra' => 'Autor de Estrela Solitária e Chega de Saudade',
            'texto' => 'Exceto pelos filmes de Shirley Temple, Rin-Tin-Tin e, possivelmente, Xuxa, o cinema sempre foi o veículo por excelência dos transtornos mentais – cognitivos, psicóticos, dissociativos, sexuais –, sem falar nos transtornos relacionados a substâncias (álcool, anfetaminas, alucinógenos, opioi- des) e outros que tiram o personagem da “norma” e o tornam tão atraente (ou assustador) para a plateia. Mas, não sendo o cinema uma ciência exata, como saber se, por exemplo, Norman Bates, o protagonista de Psicose, é um psicopata ou uma vítima de transtorno de identidade? Como identificar as inúmeras parafilias exploradas em filmes como Lolita, Janela indiscreta e Tudo que você sempre quis saber sobre sexo? E como classificar o comportamento de Glenn Close em Atração fatal? (Uma dica: ela era borderline.) Neste surpreendente Cinema e loucura – Conhecendo os transtornos mentais através dos filmes1 , os professores Jesus Landeira-Fernandez (PUC-Rio e UNESA) e Elie Cheniaux (UERJ e UFRJ) propuseram-se uma tarefa pioneira: usar personagens de 184 filmes clássicos e moder- nos, inclusive brasileiros, para ensinar ao leitor o mecanismo desses desvios que conduzem a tantos sofrimentos concretos. Pela primeira vez, os filmes de Alfred Hitchcock, Billy Wilder, Woody Allen, Stanley Kubrick, Martin Scorsese, Roman Polanski e outros grandes diretores são analisados à luz – ou às trevas – das doenças mentais. Agora você vai saber por que nós somos loucos por eles.',
        ),
        'buy_cards' => array(
            array(
                'href' => 'https://www.amazon.com.br/Cinema-Loucura-Conhecendo-Transtornos-Mentais/dp/8536321318',
                'tag' => 'Mais popular',
                'name' => 'Amazon Brasil',
                'desc' => 'Entrega rápida · Frete grátis Prime',
                'btn_text' => 'Comprar na Amazon →',
                'btn_bg' => '#ff9900',
                'icon_bg' => '#fff3cd',
            ),
            array(
                'href' => 'https://www.amazon.com.br/Cinema-loucura-Conhecendo-transtornos-mentais-ebook/dp/B01690SVEG/ref=tmm_kin_swatch_0',
                'tag' => 'Versão digital',
                'name' => 'Kindle / eBook',
                'desc' => 'Leitura imediata · Qualquer dispositivo',
                'btn_text' => 'Baixar eBook →',
                'btn_bg' => '#9d174d',
                'icon_bg' => '#fdf2f8',
            ),
            array(
                'href' => 'https://loja.grupoa.com.br/marcas/artmed?utm_feeditemid=&utm_device=c&utm_term=&utm_source=google&utm_medium=cpc&utm_campaign=google_publishing_pmax_volta_as_aulas_2026&utm_group=&utm_content=&hsa_cam=23641325660&hsa_grp=&hsa_mt=&hsa_src=x&hsa_ad=&hsa_acc=9260032853&hsa_net=adwords&hsa_kw=&hsa_tgt=&hsa_ver=3&gad_source=1&gad_campaignid=23646072388&gbraid=0AAAAADyHXLSFrpSly4c4CTySNoomolIOP&gclid=Cj0KCQjwve7NBhC-ARIsALZy9HUgYhgP3uXTCw7NKKeazBwIPIrGz57L6VOnzh2S8vNf_s0kHUTtrLoaAjAkEALw_wcB#&search-term=cheniaux',
                'tag' => 'Livraria',
                'name' => 'Grupo A+ Educação',
                'desc' => 'Livraria tradicional · Entrega nacional',
                'btn_text' => 'Comprar →',
                'btn_bg' => '#166534',
                'icon_bg' => '#f0fdf4',
            ),
            array(
                'href' => 'https://www.travessa.com.br/cinema-e-loucura-conhecendo-os-transtornos-mentais-atraves-dos-filmes/artigo/f9f1b997-c7d9-4765-9c4c-e6d90e134f28',
                'tag' => 'Livraria',
                'name' => 'Livraria da Travessa',
                'desc' => 'A maior rede de livrarias do Rio de Janeiro · Melhores preços',
                'btn_text' => 'Buscar →',
                'btn_bg' => '#7e22ce',
                'icon_bg' => '#fdf4ff',
            ),
            array(
                'href' => 'https://www.martinsfontespaulista.com.br/cinema-e-loucura-624867/p',
                'tag' => 'Livraria',
                'name' => 'Livraria Martins Fontes',
                'desc' => 'Livros nacionais e importados, com mais de 700 mil títulos.',
                'btn_text' => 'Buscar →',
                'btn_bg' => '#7e22ce',
                'icon_bg' => '#fdf4ff',
            ),
        ),
        'ctas' => array(
            array(
                'titulo' => 'Artmed Editora',
                'texto' => 'Publicado pela Editora Rubio — referência em publicações de saúde no Brasil. Consulte também o catálogo completo da editora.',
                'btn_text' => 'Visitar editora',
                'btn_href' => 'https://loja.grupoa.com.br/cinema-e-loucura-9788536321318-p992338',
            ),
            array(
                'titulo' => 'Indicação bibliográfica',
                'texto' => 'Professores que desejam adotar Cinema e Loucura em disciplinas de saúde mental, psicologia ou cinema podem entrar em contato com o autor.',
                'btn_text' => 'Entrar em contato',
                'btn_href' => 'index.html#contato',
            ),
        ),
        'accent_vars' => array(
            'gold' => '#c9a84c',
            'gold-light' => '#e8d5a0',
            'navy' => '#1a4427',
            'accent' => '#7f1d1d',
            'accent-mid' => '#991b1b',
            'accent-light' => '#fee2e2',
            'accent-warm' => '#fef2f2',
        ),
    ),
    array(
        'slug' => 'livro-fogo-cinzas-v2',
        'title' => 'Fogo & Cinzas',
        'author' => 'Elie Cheniaux e Thiara Cruz',
        'tagline' => 'O título faz referência a uma metáfora, criada pelo psiquiatra grego Athanasios Koukopoulos, que compara as fases de mania e de depressão do transtorno bipolar com Fogo & Cinzas, respectivamente. A obra aborda histórias de vida e do adoecimento mental de 17 celebridades que sofriam ou sofrem do transtorno, como Vicent Van Gogh, Alberto Santos Dumont, Edgar Allan Poe, Ernest Hemingway, Virginia Woolf, Ulysses Guimarães, Kanye West, entre outros..',
        'badges' => array(
            'Narrativa / Psiquiatria',
        ),
        'cover_img' => 'Livro Fogo e Cinzas -1.jpg',
        'endorsement' => '',
        'stats' => array(
            array(
                'icon' => '',
                'label' => 'Ano',
                'value' => '2023',
            ),
            array(
                'icon' => '',
                'label' => 'Páginas',
                'value' => '180',
            ),
            array(
                'icon' => '',
                'label' => 'Editora',
                'value' => 'Editora dos Editores',
            ),
        ),
        'sinopse_paras' => array(
            'FOGO & CINZAS: AS INCRÍVEIS HISTÓRIAS DE BIPOLARES FAMOSOS',
            'Apesar de representar uma condição clínica muito grave, o transtorno bipolar tem sido associado a possíveis vantagens compensatórias, especialmente a criatividade. Este livro discute as histórias de vida e do adoecimento mental de 17 indivíduos famosos que sofriam ou sofrem de transtorno bipolar, artistas em sua maioria. São eles: Alberto Santos-Dumont, Carrie Fisher, Edgar Allan Poe, Ernest Hemingway, George III da Inglaterra, Kanye West, Kay Jamison, Maria I de Portugal, Patrick Kennedy, Richard Dreyfuss, Robert Schumann, Stephen Fry, Sylvia Plath, Ulysses Guimarães, Vincent van Gogh, Virginia Woolf e Vivien Leigh..',
            'Embora a análise psiquiátrica de cada caso tenha sido feita de forma rigorosa do ponto de vista técnico, levando em consideração a psicopatologia clássica e os critérios diagnósticos mais modernos, o texto foi escrito em uma linguagem simples e acessível. Assim, esta obra é voltada não apenas para os estudantes e profissionais das áreas de psiquiatria e saúde mental, mas também para o público leigo em geral.',
        ),
        'tema_label' => '',
        'tema_tags' => array(
        ),
        'ficha' => array(
        ),
        'pull_quote' => '',
        'pull_attr' => '',
        'prefacio' => array(
            'nome' => 'Flávio Kapczinski',
            'cargo' => 'Psiquiatra',
            'extra' => 'Apresentação',
            'texto' => 'Tenho dedicado minha carreira ao estudo da fascinante e desafiadora doença bipolar. No decorrer dos anos, procurando auxiliar pacientes e seus familiares, fui me deparando com questões de grande importância lançadas neste livro. Muitas vezes o sucesso em diferentes áreas criativas como as artes, a ciência e o empreendedorismo depende de doses pouco usuais de audácia, desinibição, charme pessoal e mesmo carisma. Essas são características marcantes de pacientes em fase hipomaníaca ou mesmo hipertímica da doença bipolar. Poderíamos dizer que certos indivíduos, quando eufóricos, parecem “tocados pelo fogo”, usando as palavras da estudiosa e portadora da doença bipolar Kay Redfield Jamison. No decorrer da leitura do livro, me deparei com personagens célebres, escritores e artistas favoritos. É impossível resistir, por exemplo, às narrativas que envolvem as vicissitudes de Robert Schumann. Esse músico é apontado como um dos maiores mestres da melodia em música erudita. De fato, não há como evitar reminiscências da infância ouvindo-se Kinderszenen, um clássico desse autor. Já disse Beethoven que a música é mais profunda do que qualquer filosofia. De fato, a música de Robert Schumann nos remete à profundidade da nostalgia de tempos passados bem como de cenas de amor e contemplação. Seria parte desse contato profundo com o mundo emocional um resultado da doença bipolar? Vamos além, e analisando a biografia e obras de Virginia Woolf, verificamos um amálgama de intensas vivências pessoais, erudição e criatividade na sua forma mais intensa e disruptiva. Virgínia Wolf cometeu suicídio após uma carreira de grande sucesso literário. Ela foi um dos mestres da literatura moderna. Mas foi também uma vítima da doença bipolar não tratada. Curiosamente Virgínia Wolf e seu marido foram editores na Inglaterra da obra do professor alemão Sigmund Freud. Amigos em comum tentaram organizar um encontro de Virginia Woolf com o professor Freud. Esse encontro jamais ocorreu, e mesmo que tivesse ocorrido, a doença bipolar, embora descrita, ainda não apresentava nenhum tipo de tratamento eficaz. Virgínia Wolf foi tratada com dietas e descanso. Pouco lhe valeram esses tratamentos, e sua doença seguiu um curso de gravidade cada vez maior, culminando com o suicídio. E que dizer dos relatos biográficos e literários de Ernest Hemingway? Pois o grande autor de Por quem os sinos dobram sofria da doença bipolar. Cometeu suicídio, bem como seu pai e sua neta. Histórias como essas são tratadas com riqueza de detalhes e bibliografia de suporte ao longo do livro. Que obra adorável! Além de leitura obrigatória para profissionais que se dedicam à doença bipolar, a obra é também de grande valia para aqueles que apreciam a história da arte e a riqueza de detalhes da vida de seus protagonistas. Fica a pergunta que o livro trata ao longo de suas páginas: a doença bipolar seria afinal um facilitador da genialidade? Eu, como tantos outros, prefiro acreditar que existem seres humanos especiais e de talento incontestável, gênios. E genialidade não é doença. Mas os autores deixam a nós, leitores, com a “pulga atrás da orelha”... Seria a doença bipolar, em muitos casos, a centelha das grandes mentes criativas? Convido o leitor a deliciar-se nessas páginas de cultura e história da doença mental e seus tratamentos. Encontrei nas páginas desse livro boas doses de tratamentos que muito recomendo: cultura, ciência e humanismo.',
        ),
        'resenha_texto' => 'Figuras públicas sempre tiveram seus feitos levados à população geral através da mídia, principalmente pelo potencial impacto na vida das pessoas por meio da participação em movimentos culturais, políticos, ou simplesmente por serem formadoras de opinião. Em "Fogo & Cinzas: as incríveis histórias de bipolares famosos" [1] o renomado psiquiatra Elie Cheniaux e a psicóloga Thiara Cruz trazem em 17 capítulos independentes a análise de histórias de figuras famosas sob a ótica da ciência da saúde mental, tendo como base comportamentos relatados, documentos oficiais, notícias e históricos médicos. Nesta obra, os autores assumem papel de “investigadores” e “historiadores”, buscando organizar os dados obtidos para relatar e enquadrar padrões comportamentais e de sintomas em determinada classificação diagnóstica. De leitura simples e fluida, o texto é acessível à população leiga na área, sem abrir mão do rigor científico na análise psicopatológica realizada. Durante a leitura, diversos relatos lembram os de pessoas comuns e nos fazem enxergar que a manifestação da doença psiquiátrica não ocorre de forma “tão diferente” entre a pessoa “comum,’’ e o famoso. Explico: “tão diferente”, pois o que diverge não é a manifestação da doença em si, mas os meios para colocar em prática as ideias de grandeza/delírios e os gastos exagerados, que podem passar despercebidos a depender da disponibilidade de recursos do indivíduo. A exemplo disso, podemos dizer que provavelmente Santos-Dumont não construiria 22 dirigíveis ao longo de sua vida se não fosse um herdeiro bastante rico. Estudos tentam relacionar, de forma indireta, a presença de transtorno bipolar e a criatividade, inteligência e sucesso de alguns indivíduos. Entretanto, durante a obra percebe-se que muitos daqueles famosos, provavelmente o seriam da mesma forma com ou sem o diagnóstico. Em muitos dos casos, a posição de destaque já poderia anteriormente ser atribuída à origem familiar, pois eram compostas por pessoas famosas de Hollywood, como Carrie Fisher, da política como na família Kennedy, da realeza como George III e Maria I e em outros casos o acesso a recursos educacionais e estímulos no desenvolvimento ou a oportunidade de “sentar-se à mesa com a sociedade intelectual” de artistas, escritores, inventores, como Santos-Dumont frequentemente tinha. Um dos grandes méritos do Fogo & Cinzas é trazer personalidades nascidas em diferentes épocas: desde o Rei George III em 1738, até Kanye West em 1977, mostrando que as manifestações psiquiátricas do transtorno eram semelhantes em todas as épocas. Contudo, também observamos que a forma como eram interpretadas e tratadas era diferente. No passado, maior ênfase era dada a diagnósticos diferenciais com condições clínicas, como porfiria, e terapêuticas de cunho moral, tratamentos purgativos e sangrias. Observamos a evolução da psiquiatria com o surgimento de medicações como o lítio e tratamentos como eletroconvulsoterapia, marcos importantes com grande impacto no desfecho do transtorno. Nota-se também a evolução dos sistemas classificatórios diagnósticos, sendo que muitos famosos receberam diagnóstico de psicose maníaco-depressiva, que possui algumas diferenças conceituais em comparação ao transtorno bipolar. Outro grande mérito da obra é a contribuição para a redução do estigma sobre o transtorno. Carrie Fisher, por exemplo, tornou-se ativista em prol da saúde mental, e tendo sido submetida à eletroconvulsoterapia, falou publicamente sobre essa forma de tratamento, buscando reduzir os preconceitos sobre o tema. Já Patrick Kennedy foi um grande apoiador de um projeto (depois tornado lei) que obrigava seguradoras de saúde a ampliarem a cobertura de tratamentos psiquiátricos. Por sua vez, o comediante Stephen Fry, que só aceitou iniciar tratamento dezessete anos após seu diagnóstico, hoje é presidente de uma instituição de caridade destinada a pessoas que sofrem de transtornos mentais. A psicóloga Kay Jamison, que sofre de transtorno bipolar, é coautora de um dos livros mais importantes sobre o assunto. Muitos famosos utilizaram de sua notoriedade para trazer maior visibilidade ao tema, contribuindo para a redução da psicofobia, mostrando a importância do tratamento e da necessidade dos sistemas de saúde olharem para o tema com maior atenção. Nesta obra, de maneira brilhante, Cheniaux e Thiara Cruz suscitam o debate sobre a possível relação entre o transtorno afetivo bipolar e uma maior criatividade, traçam um panorama histórico da classificação e tratamentos da comorbidade e mostram os avanços assistenciais e a visibilidade trazida pelas figuras da obra ao longo dos anos. O texto de fácil compreensão consegue acessar desde o leigo até o especialista em saúde mental. É uma obra que permite àqueles não familizarizados com o tema compreender características do adoecimento psíquico. Portanto, a popularização desta obra contribui de forma relavante para a redução da psicofobia.',
        'resenha_autores' => array(
            array('Caio Silveira de Caro', 'é médico generalista graduado pela Universidade Regional de Blumenau (2015-2021).- Pós Graduado (NÃO ESPECIALISTA) em Psiquiatria na Clínica Médica e Cirúrgica no pela Faculdade Israelita de ciências da Saúde Albert Einstein. - Realiza atualmente especialização em Psiquiatria no Hospital Heidelberg(Curitiba/PR). - Atuou como Médico Clínico no Serviço de Avaliação em Saúde mental(SAS), da Prefeitura Municipal de Blumenau.'),
            array('Karla de Souza', 'é médica Psiquiatra'),
            array('Jéssica Lovcke', 'é médica graduada em Medicina pela Universidade do Oeste de Santa Catarina - UNOESC (2013 - 2018), possui curso de especialização em atenção básica em saúde pela Universidade Federal de Santa Catarina (2019 - 2020), especialização pelo programa de formação em psiquiatria acreditado pela ABP no hospital Heidelberg no município de Curitiba/PR (2023 - 2026) e pós graduação em psiquiatria forense pelo IPq-USP (2025 - 2026)'),
            array('Gabriela de Almeida', 'é médica formada pelo Centro Universitário Ingá (2018). Tem experiência no atendimento Clínico Geral e Urgência na UPA e UBS de Dourados.'),
            array('Daniel Guadagnin', 'é dentista graduado em Odontologia pela Universidade Positivo(2012) e possui graduação em Medicina pela FACULDADE EVANGELICA MACKENZIE DO PARANA(2022). Tem experiência na área de Medicina'),
            array('Mariana Sampaio Ferelli', 'é médica graduada em Medicina pela Universidad Advenstista del Plata(2018). Atualmente é Especializando da Clínica Heidelberg. Tem experiência na área de Medicina, com ênfase em Psiquiatria'),
        ),
        'buy_cards' => array(
            array(
                'href' => 'https://www.amazon.com.br/Fogo-Cinzas-incr%C3%ADveis-hist%C3%B3rias-bipolares/dp/8585162759',
                'tag' => '',
                'name' => 'Amazon',
                'desc' => 'Impresso · Kindle',
                'btn_text' => 'Comprar na Amazon →',
                'btn_bg' => '#ff9900',
                'icon_bg' => '#ff9900',
            ),
            array(
                'href' => 'https://www.mercadolivre.com.br/fogo--cinzas--editora-dos-editores/up/MLBU3766425451',
                'tag' => '',
                'name' => 'Mercado Livre',
                'desc' => 'Novos e usados',
                'btn_text' => 'Ver no Mercado Livre →',
                'btn_bg' => '#ffe600',
                'icon_bg' => '#ffe600',
            ),
            array(
                'href' => 'https://www.estantevirtual.com.br/livro/fogo--cinzas-0I2-6156-000-BK',
                'tag' => '',
                'name' => 'Estante Virtual',
                'desc' => 'Sebos e livrarias',
                'btn_text' => 'Ver na Estante Virtual →',
                'btn_bg' => '#e63946',
                'icon_bg' => '#e63946',
            ),
            array(
                'href' => 'https://www.editoradoseditores.com.br/lancamentos/fogo-amp-cinzas-as-incriveis-historias-de-bipolares-famosos',
                'tag' => '',
                'name' => 'Editora dos Editores',
                'desc' => 'Livro físico',
                'btn_text' => 'Baixar eBook →',
                'btn_bg' => 'var(--accent)',
                'icon_bg' => 'var(--accent)',
            ),
            array(
                'href' => 'https://www.travessa.com.br/fogo-e-cinzas-as-incriveis-historias-de-bipolares-famosos/artigo/6b4ccfe7-4312-4878-b5b2-113dcbb5e449',
                'tag' => '',
                'name' => 'Livraria da Travessa',
                'desc' => 'Impresso',
                'btn_text' => 'Comprar na Amazon →',
                'btn_bg' => '#ff9900',
                'icon_bg' => '#ff9900',
            ),
            array(
                'href' => 'https://www.martinsfontespaulista.com.br/fogo---cinzas-1061728/p',
                'tag' => '',
                'name' => 'Martins Fontes',
                'desc' => 'Impresso',
                'btn_text' => 'Ver na Estante Virtual →',
                'btn_bg' => '#e63946',
                'icon_bg' => '#e63946',
            ),
            array(
                'href' => 'https://booklover.com.br/fogo-cinzas-as-incriveis-historias-de-bipolares-famosos-elie-cheniaux/',
                'tag' => '',
                'name' => 'Book Lover',
                'desc' => 'Livro físico',
                'btn_text' => 'Baixar eBook →',
                'btn_bg' => 'var(--accent)',
                'icon_bg' => 'var(--accent)',
            ),
        ),
        'ctas' => array(
        ),
        'accent_vars' => array(
            'gold' => '#c9a84c',
            'gold-light' => '#e8d5a0',
            'navy' => '#1a4427',
            'accent' => '#92400e',
        ),
    ),
    array(
        'slug' => 'livro-manual-psicopatologia-v2',
        'title' => 'Manual de Psicopatologia',
        'author' => 'Elie Cheniaux',
        'tagline' => 'Com sete novos apêndices e ampla revisão da literatura, a obra traz os principais conceitos da psicopatologia descritiva, com conteúdo seguro e diversos exemplos clínicos, para estudantes e profissionais de psiquiatria, psicologia e saúde mental.',
        'badges' => array(
            'Medicina · Psiquiatria · Livro Didático',
        ),
        'cover_img' => 'LivroMANUAL.jpg',
        'endorsement' => '',
        'stats' => array(
            array(
                'icon' => '',
                'label' => 'Ano',
                'value' => '7ª edição · 2020',
            ),
            array(
                'icon' => '',
                'label' => 'Páginas',
                'value' => '215',
            ),
            array(
                'icon' => '',
                'label' => 'Editora',
                'value' => 'Guanabara Koogan',
            ),
        ),
        'sinopse_paras' => array(
            'O Manual de Psicopatologia constitui uma proposta de síntese e revisão dos conceitos da psicopatologia descritiva. Após estudo dos principais autores, foi elaborada uma obra que representasse o somatório de todos os textos, privilegiando, nos casos de divergência, geralmente as proposições mais comuns. Cada função psíquica é estudada em um capítulo diferente, e cada capítulo apresenta sua definição, as alterações quantitativas e qualitativas (com diversos exemplos clínicos), a técnica de exame e sua relação com os principais transtornos e síndromes mentais. Também está incluída uma discussão sobre as descobertas das neurociências e as formulações teóricas da psicanálise relacionadas àquela função psíquica. O livro conta ainda com capítulos sobre os conceitos básicos da psicopatologia, a entrevista psiquiátrica e as principais síndromes psiquiátricas. Além disso, traz 13 apêndices, sendo sete novos, que abordam, além das alterações psicopatológicas e do exame psíquico, alguns temas psiquiátricos – como a antiga histeria, o transtorno bipolar e o transtorno esquizoafetivo –, a interface entre neurociência e psicanálise e a relação do cinema com a psicopatologia e a psiquiatria. Com prefácio assinado pelos professores Miguel Chalub, Antonio Egidio Nardi e Humberto Corrêa, esta sétima edição é, entre todas, a que apresenta a mais ampla revisão do texto.',
        ),
        'tema_label' => '',
        'tema_tags' => array(
        ),
        'ficha' => array(
        ),
        'pull_quote' => '',
        'pull_attr' => '',
        'prefacio' => array(
            'nome' => 'Humberto Corrêa',
            'cargo' => 'Humberto Corrêa Professor Titular de Psiquiatria da Faculdade de Medicina da Universidade Federal de Minas Gerais',
            'extra' => 'Apresentação',
            'texto' => 'Junto aos manuscritos da sétima edição, revista e ampliada, do Manual de Psicopatologia do professor Elie Cheniaux, recebi o convite para escrever o seu prefácio. Só nessa pequena frase introdutória acima temos várias informações muito relevantes para nossos leitores. Comecemos, primeiramente, pela que pode parecer a mais simples delas. Trata-se da sétima edição de um livro em um mercado editorial que é, no Brasil, podemos assim considerar, restrito. De fato, o número de livros lidos anualmente por cada brasileiro não nos coloca em nenhum ranking internacional de destaque, muitos autores têm dificuldade em publicar suas obras, e muitos livros, por vezes excelentes livros, não passam da sua primeira edição. A sétima edição de um livro é motivo de comemoração e um “atestado” de sucesso! Em segundo lugar, trata-se de um livro de psicopatologia. Podemos dizer que a origem dessa disciplina se dá com Karl Jaspers no seu “A Psicopatologia Geral”, de 1913, que lançou as suas bases e que têm como elementos fundadores uma clínica minuciosa e um rigor filosófico. A psicopatologia, base do exame psiquiátrico, exige tempo, treinamento, disciplina; exige, principalmente, reflexão. Talvez por isso ela ande um pouco esquecida pelas novas gerações, nesses novos “tempos líquidos”, onde tudo parece descartável. Tempos em que se buscam respostas rápidas, prontas, geralmente superficiais, frequentemente erradas ou inadequadas. Mesmo com todos os avanços na psiquiatria nas últimas décadas, da neurobiologia à genética, das novas formas de psicoterapia às modernas terapêuticas farmacológicas e de neuromodulação, que, lembremos, não existiam ao tempo que Jaspers escreveu o seu “Tratado”, a Psicopatologia ainda é fundamental, mas, exige-se agora algo mais que o nosso autor faz com maestria e leveza, a interlocução com as neurociências e a psicoterapia. Em terceiro lugar, trata-se, como dissemos da Sétima(!) Edição, completamente revista e ampliada. Nosso querido autor, Elie Cheniaux, revisou todo o texto e ainda nos brinda com novos seis apêndices. Por todas essas razões, e muitas outras que nosso curto espaço não permite elencar, o Manual De Psicopatologia, esse “pequeno” mas grande livro do Elie Cheniaux, é indispensável a todos os médicos e psicólogos que se interessam pela sublime “ciência-arte” de compreender o ser humano.',
        ),
        'buy_cards' => array(
            array(
                'href' => 'https://www.amazon.com.br/s?k=manual+de+psicopatologia+elie+cheniaux',
                'tag' => '',
                'name' => 'Amazon',
                'desc' => 'Impresso · Kindle',
                'btn_text' => 'Comprar na Amazon →',
                'btn_bg' => '#ff9900',
                'icon_bg' => '#ff9900',
            ),
            array(
                'href' => 'https://www.grupogen.com.br/catalogsearch/result/?q=cheniaux',
                'tag' => '',
                'name' => 'G',
                'desc' => 'Livraria online',
                'btn_text' => 'Ver no Grupo Gen →',
                'btn_bg' => '#e53e3e',
                'icon_bg' => '#e53e3e',
            ),
            array(
                'href' => 'https://www.livrariacultura.com.br',
                'tag' => '',
                'name' => 'C',
                'desc' => 'Livraria online',
                'btn_text' => 'Ver na Cultura →',
                'btn_bg' => '#6b21a8',
                'icon_bg' => '#6b21a8',
            ),
            array(
                'href' => 'https://www.grupogen.com.br/catalogsearch/result/?q=cheniaux',
                'tag' => '',
                'name' => 'Guanabara Koogan',
                'desc' => 'Direto na editora',
                'btn_text' => 'Comprar na Editora →',
                'btn_bg' => 'var(--accent)',
                'icon_bg' => 'var(--accent)',
            ),
            array(
                'href' => 'https://www.amazon.com.br/s?k=manual+psicopatologia+cheniaux+ebook',
                'tag' => '',
                'name' => 'eBook / Kindle',
                'desc' => 'Versão digital',
                'btn_text' => 'Baixar eBook →',
                'btn_bg' => 'var(--navy)',
                'icon_bg' => '#1a4427',
            ),
        ),
        'ctas' => array(
        ),
        'accent_vars' => array(
            'gold' => '#c9a84c',
            'gold-light' => '#e8d5a0',
            'navy' => '#1a4427',
            'accent' => '#0f766e',
        ),
    ),
    array(
        'slug' => 'livro-sindrome-pre-menstrual-v2',
        'title' => 'Síndrome Pré-Menstrual',
        'author' => 'Elie Cheniaux',
        'tagline' => 'Um ponto de encontro entre a psiquiatria e a ginecologia',
        'badges' => array(
            'Medicina / Saúde da Mulher',
        ),
        'cover_img' => 'Livro SÍNDROME PRÉ-MENSTRUAL.jpg',
        'endorsement' => '',
        'stats' => array(
            array(
                'icon' => '',
                'label' => 'Ano',
                'value' => '2001',
            ),
            array(
                'icon' => '',
                'label' => 'Páginas',
                'value' => '147',
            ),
            array(
                'icon' => '',
                'label' => 'Editora',
                'value' => 'EdUerj',
            ),
        ),
        'sinopse_paras' => array(
            'A síndrome pré-menstrual é um bom exemplo da interação, ainda pouco conhecida, do sistema endócrino com o sistema nervoso e o psiquismo; é um ponto de encontro entre a psiquiatria, a endocrinologia e a ginecologia. O seu estudo contribui para uma maior integração do conhecimento médico.',
            'A obra é baseada na tese de doutoramento do autor, intitulada “A Inclusão da Síndrome Pré-Menstrual entre os Transtornos Mentais”, defendida no Instituto de Psiquiatria da UFRJ em 1997, sob a orientação do prof. dr. Miguel Chalub (professor adjunto de psiquiatria da UERJ e UFRJ).',
        ),
        'tema_label' => '',
        'tema_tags' => array(
        ),
        'ficha' => array(
        ),
        'pull_quote' => '',
        'pull_attr' => '',
        'prefacio' => array(
            'nome' => 'Miguel Chalub',
            'cargo' => 'Miguel Chalub professor na Universidade do Estado do Rio de Janeiro e médico no Hospital de Custódia e Tratamento Psiquiátrico do Estado do Rio de Janeiro.',
            'extra' => '',
            'texto' => 'Aqui está o texto extraído do documento: Parece claro que certas doenças comprometem apenas a matéria, enquanto outras afetam somente o espírito. Porém, a noção de doença psicossomática deixa supor que não há doença puramente física, uma vez que a mente reage a qualquer alteração material; já uma enfermidade exclusivamente psíquica não seria apenas doença da alma, visto que não há atividade mental sem um corpo que a suporte. O conceito não escapa à dualidade doenças do corpo versus doenças da mente, pois prova apenas que há moléstias predominantemente físicas ou psíquicas e psicossomáticas propriamente ditas. Existem afecções difíceis de determinar se são físicas ou mentais. É o caso da síndrome pré-menstrual. Durante o fluxo menstrual ou dias antes, muitas mulheres reclamam de sinais e sintomas classificáveis, a um só tempo, como psíquicos e físicos. Alguns são ginecológicos de fato como edema regional, mas se observa também irritabilidade. Os estados afetivos polarizados podem ser tão intensos que já se cogitou de isentar as mulheres de responsabilidade penal, caso cometessem delitos durante a síndrome. Ora, o problema é ginecológico ou psiquiátrico? Baseado na tese de doutoramento do autor, este livro é uma importante contribuição ao tema. Elie Cheniaux Jr., Professor da Faculdade de Ciências Médicas da UERJ, estuda os problemas psiquiátricos envolvidos na SPM, que, a princípio apresenta-se como ginecológica. Psiquiatras, ginecologistas e psicólogos encontrarão nesta obra manancial excelente para lidarem com este verdadeiro desafio. .',
        ),
        'buy_cards' => array(
            array(
                'href' => 'https://www.amazon.com.br/s?k=cheniaux+s%C3%ADndrome+pr%C3%A9-menstrual&i=stripbooks&__mk_pt_BR=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=3AAKIL7FCUTR4&sprefix=cheniaux+s%C3%ADndrome+pr%C3%A9-menstrua%2Cstripbooks%2C198&ref=nb_sb_noss',
                'tag' => '',
                'name' => 'Amazon',
                'desc' => 'Entrega rápida · frete grátis Prime',
                'btn_text' => 'Comprar →',
                'btn_bg' => 'var(--accent)',
                'icon_bg' => '',
            ),
            array(
                'href' => 'https://lista.mercadolivre.com.br/manual-de-psicopatologia-elie-cheniaux',
                'tag' => '',
                'name' => 'Mercado Livre',
                'desc' => 'Especializada em saúde e medicina',
                'btn_text' => 'Ver opção →',
                'btn_bg' => 'var(--navy)',
                'icon_bg' => '',
            ),
            array(
                'href' => 'https://www.touchelivros.com.br/sindrome-pre-menstrual-um-ponto-de-encontro-entre-a-psiquiatria-e-a-ginecologia/',
                'tag' => '',
                'name' => 'Touché Livros',
                'desc' => 'Livraria com tradição no Brasil',
                'btn_text' => 'Ver opção →',
                'btn_bg' => '',
                'icon_bg' => '',
            ),
            array(
                'href' => 'https://www.skoob.com.br/pt/book/958646',
                'tag' => '',
                'name' => 'Skoob',
                'desc' => 'A maior rede social para leitores do Brasil',
                'btn_text' => 'Ver opção →',
                'btn_bg' => '',
                'icon_bg' => '',
            ),
            array(
                'href' => 'https://www.amazon.com.br/Sindrome-Menstrual-Encontro-Psiquiatria-Ginecologia/dp/8575110101',
                'tag' => '',
                'name' => 'eBook / Kindle',
                'desc' => 'Leitura imediata em qualquer dispositivo',
                'btn_text' => 'Baixar →',
                'btn_bg' => 'var(--gold)',
                'icon_bg' => '',
            ),
            array(
                'href' => 'https://www.estantevirtual.com.br/livro/sindrome-premenstrual-16X-3348-000',
                'tag' => '',
                'name' => 'Estante Virtual',
                'desc' => 'Novos e usados · sebos confiáveis',
                'btn_text' => 'Ver opção →',
                'btn_bg' => '',
                'icon_bg' => '',
            ),
        ),
        'ctas' => array(
        ),
        'accent_vars' => array(
            'gold' => '#c9a84c',
            'gold-light' => '#e8d5a0',
            'navy' => '#1a4427',
            'accent' => '#7c3aed',
        ),
    ),
    array(
        'slug' => 'livro-woody-allen-v2',
        'title' => 'Woody Allen',
        'author' => 'Elie Cheniaux',
        'subtitulo' => 'Seus filmes são mesmo autobiográficos?',
        'tagline' => 'O livro "Woody Allen: Seus filmes são mesmo autobiográficos?", escrito por Elie Cheniaux, investiga a relação entre a vida real e a obra cinematográfica do famoso diretor, ator e roteirista. A obra analisa se os filmes de Woody Allen refletem sua verdadeira biografia ou se são fruto apenas de sua grande criatividade',
        'badges' => array(
            'Ensaio / Cinema / Psicologia',
        ),
        'cover_img' => 'Livro WOODY ALLEN.jpg',
        'endorsement' => '',
        'stats' => array(
            array(
                'icon' => '',
                'label' => 'Ano',
                'value' => '2021',
            ),
            array(
                'icon' => '',
                'label' => 'Páginas',
                'value' => '487',
            ),
            array(
                'icon' => '',
                'label' => 'Editora',
                'value' => 'Autografia',
            ),
        ),
        'sinopse_paras' => array(
            'Tão apaixonado por Woody Allen quanto por seu suposto alter ego das telas, Elie Cheniaux se debruça de forma minuciosa sobre a vida e obra do ator, diretor e roteirista para investigar até que ponto vão as semelhanças e diferenças. A decupagem criteriosa de seus 50 longas-metragens resultou em um trabalho revelador por parte do autor. (Marcelo Janot, crítico de cinema, O Globo)',
        ),
        'tema_label' => '',
        'tema_tags' => array(
        ),
        'ficha' => array(
        ),
        'pull_quote' => '',
        'pull_attr' => '',
        'prefacio' => array(
            'nome' => 'Ana Rodrigues',
            'cargo' => 'Presidente da Associação de Críticos de Cinema do Rio de Janeiro (ACC-RJ); crítica de cinema (Jornal do Brasil)',
            'extra' => '',
            'texto' => 'No artigo O percurso sombrio, de Woody Allen, publicado originalmente no The New York Times, em 1988, e que introduz a autobiografia de Ingmar Bergman, Lanterna mágica, o diretor americano cita as experiências familiares traumáticas da infância do mestre sueco, incluindo o viés de culpa imposto pela educação religiosa e a ausência de sentido da vida. Allen conclui, com seu humor peculiar, que, com uma história dessas, o sujeito só poderia virar um gênio. Bergman, o diretor que mais inspirou Woody, fez das experiências pessoais material valioso para a sua obra de viagem profunda na existência. Em Woody Allen – Seus filmes são mesmo autobiográficos?, Elie Cheniaux penetra numa das maiores questões que envolvem a obra do realizador que melhor traduziu o comportamento social ocidental através do cinema desde o final dos anos 1960. É a partir de experiências pessoais que o criador desenvolve sua arte. Mas é necessariamente a encarnação do próprio autor que determina um personagem? Com Woody Allen há uma frequente comparação da vida real do ator, diretor e roteirista com o papel que interpreta ou que é interpretado por atores que replicam seus gestos e maneira de falar. Até mesmo mulheres como a Jasmine, de Cate Blanchett, reproduzem o gaguejar típico das criações de Woody. Encontramos nas mulheres retratadas, um dos principais elementos de sua cinematografia, sinais da família do diretor, de relacionamentos e do próprio Allen. Mas até que ponto essas vivências estão nos filmes dele? Neste livro, cada caso é exposto e analisado, e o caráter comparativo proporciona uma leitura curiosa e instigante. Na arte, há um fascínio em conhecer quem é e como pensa o indivíduo que criou aquele mundo. O que passa pela cabeça do criador? Quando a obra é tão rica e contínua como a de Woody Allen, que atua em muitos dos seus filmes, a provocação é ainda maior. Só para citar no cinema, sobre criadores como Charles Chaplin, Orson Welles, Ingmar Bergman, Federico Fellini ou Stanley Kubrick, atores ou somente diretores, surgem sempre perguntas. O que eles pensavam quando criaram aquelas cenas? Onde estavam? Qual era o estado de espírito? Quais experiências eles viveram e quais pessoas podem ter estimulado a criação daquelas cenas? Por meio deste livro, de texto leve e bem fundamentado, vamos passear pela obra de Woody Allen e por aspectos da vida pessoal do artista para entender o neurótico ou apenas o cara simples que curte um jogo de basquete e gosta de tocar jazz com seu clarinete. Teorias para decifrar o homem por trás da obra ou a obra por trás do homem vão fluindo. Muito do que disse Woody em entrevistas ou está em seus filmes é colocado em espelhamento. Culpa e castigo, baixa autoestima e narcisismo, drama e comédia, família e Nova York. O sexo visto com algo separado do amor. Por outro lado, o romantismo que passeia por suas obras como Manhattan, Todos dizem eu te amo e Meia-noite em Paris. Allen pensa no amor como algo lúdico que nos distrai das verdadeiras questões existenciais. Talvez seja o medo da morte? O livro observa essa obsessão pelo destino na obra do cineasta e na própria maneira com que Woody reflete isso em suas entrevistas. Ele sempre encontra o caminho do humor para explicar o que é inevitável. O fim. E a maneira como vive, filmando com orçamento baixo e grandes estrelas, um filme por ano, mostra como Woody pensa. Sempre em processo criativo e de renovação. Há sempre uma história para contar. Uma intenção de assegurar que está vivo? É necessário alimentar nossa alma, e Woody Allen cuida disso fazendo filmes e, assim, driblando a morte. Como seu mestre Bergman pensou em O sétimo selo e o ruivo referenciou em A última noite de Boris Grushenko. Woody Allen – Seus filmes são mesmo autobiográficos? reúne os elementos que envolvem essa questão e proporciona ao leitor a oportunidade de pensar sobre processos criativos, experiências e existência. A obra de Allen reflete homens e mulheres do mundo contemporâneo. O diretor que, a partir do final dos anos 1960, capturou, num contexto psicanalítico, o mundo que estava em transformação comportamental. Detalhes destacados no livro nos levam aos filmes. Revisitá-los ou descobri-los é a oportunidade de uma experiência muito especial.',
        ),
        'buy_cards' => array(
            array(
                'href' => 'https://www.amazon.com.br/s?k=Woody+Allen+Cheniaux',
                'tag' => '',
                'name' => 'Amazon',
                'desc' => 'Entrega rápida · frete grátis Prime',
                'btn_text' => 'Comprar →',
                'btn_bg' => 'var(--accent)',
                'icon_bg' => '',
            ),
            array(
                'href' => 'https://www.livrariacultura.com.br',
                'tag' => '',
                'name' => 'Livraria Cultura',
                'desc' => 'Amplo catálogo · clássicos do cinema',
                'btn_text' => 'Ver opção →',
                'btn_bg' => 'var(--navy)',
                'icon_bg' => '',
            ),
            array(
                'href' => 'https://www.autografia.com.br/produto/woody-allen-seus-filmes-sao-mesmo-autobiograficos/',
                'tag' => '',
                'name' => 'Editora Autobigrafia',
                'desc' => 'Amplo catálogo · clássicos do cinema',
                'btn_text' => 'Ver opção →',
                'btn_bg' => 'var(--navy)',
                'icon_bg' => '',
            ),
            array(
                'href' => 'https://www.estantevirtual.com.br',
                'tag' => '',
                'name' => 'Estante Virtual',
                'desc' => 'Novos e usados · sebos do Brasil',
                'btn_text' => 'Ver opção →',
                'btn_bg' => '',
                'icon_bg' => '',
            ),
            array(
                'href' => 'https://www.amazon.com.br/s?k=Woody+Allen+Cheniaux+ebook',
                'tag' => '',
                'name' => 'eBook Kindle',
                'desc' => 'Leitura imediata em qualquer dispositivo',
                'btn_text' => 'Baixar →',
                'btn_bg' => 'var(--gold)',
                'icon_bg' => '',
            ),
        ),
        'ctas' => array(
        ),
        'accent_vars' => array(
            'gold' => '#c9a84c',
            'gold-light' => '#e8d5a0',
            'navy' => '#1a4427',
            'accent' => '#b45309',
        ),
    ),
);

    foreach ($livros as $i => $l) {
        $post_id = wp_insert_post(array(
            'post_title' => $l['title'],
            'post_name' => str_replace('livro-', '', str_replace('-v2', '', $l['slug'])),
            'post_content' => implode("\n\n", array_map(function ($p) { return '<p>' . $p . '</p>'; }, $l['sinopse_paras'])),
            'post_type' => 'livro',
            'post_status' => 'publish',
            'menu_order' => $i,
        ));
        if (!$post_id) {
            continue;
        }

        update_post_meta($post_id, 'livro_autor', $l['author']);
        if (!empty($l['subtitulo'])) {
            update_post_meta($post_id, 'livro_subtitulo', $l['subtitulo']);
        }
        update_post_meta($post_id, 'livro_tagline', $l['tagline']);
        update_post_meta($post_id, 'livro_genero', implode(', ', $l['badges']));
        update_post_meta($post_id, 'livro_endorsement', $l['endorsement']);

        foreach ($l['stats'] as $stat) {
            if ($stat['label'] === 'Ano') update_post_meta($post_id, 'livro_ano', $stat['value']);
            if ($stat['label'] === 'Páginas') update_post_meta($post_id, 'livro_paginas', $stat['value']);
            if ($stat['label'] === 'Editora') update_post_meta($post_id, 'livro_editora', $stat['value']);
            if ($stat['label'] === 'Idioma') update_post_meta($post_id, 'livro_idioma', $stat['value']);
        }
        if (!empty($l['ficha']['Formato'])) {
            update_post_meta($post_id, 'livro_formato', $l['ficha']['Formato']);
        }

        update_post_meta($post_id, 'livro_accent', isset($l['accent_vars']['accent']) ? $l['accent_vars']['accent'] : '#1a4427');
        update_post_meta($post_id, 'livro_accent_light', isset($l['accent_vars']['accent-light']) ? $l['accent_vars']['accent-light'] : '#e8d5a0');
        update_post_meta($post_id, 'livro_accent_dark', isset($l['accent_vars']['accent-dark']) ? $l['accent_vars']['accent-dark'] : (isset($l['accent_vars']['accent-mid']) ? $l['accent_vars']['accent-mid'] : '#123018'));

        if ($l['tema_label'] || $l['tema_tags']) {
            update_post_meta($post_id, 'livro_tema_titulo', $l['tema_label']);
            update_post_meta($post_id, 'livro_tema_lista', implode(', ', $l['tema_tags']));
        }

        if ($l['pull_quote']) {
            update_post_meta($post_id, 'livro_pull_quote', $l['pull_quote']);
            update_post_meta($post_id, 'livro_pull_attr', $l['pull_attr']);
        }

        if ($l['prefacio']) {
            update_post_meta($post_id, 'livro_prefacio_nome', $l['prefacio']['nome']);
            update_post_meta($post_id, 'livro_prefacio_cargo', $l['prefacio']['cargo']);
            update_post_meta($post_id, 'livro_prefacio_extra', $l['prefacio']['extra']);
            update_post_meta($post_id, 'livro_prefacio_texto', $l['prefacio']['texto']);
        }

        if (!empty($l['resenha_texto'])) {
            update_post_meta($post_id, 'livro_resenha_texto', $l['resenha_texto']);
            $resenha_autores_lines = array();
            foreach ($l['resenha_autores'] as $a) {
                $resenha_autores_lines[] = implode(' | ', $a);
            }
            update_post_meta($post_id, 'livro_resenha_autores', implode("\n", $resenha_autores_lines));
        }

        $compradores_lines = array();
        foreach ($l['buy_cards'] as $b) {
            $compradores_lines[] = implode(' | ', array($b['name'], $b['href'], $b['btn_bg'] ?: $b['icon_bg'], $b['tag'], $b['desc']));
        }
        if ($compradores_lines) {
            update_post_meta($post_id, 'livro_compradores', implode("\n", $compradores_lines));
        }

        $cta_lines = array();
        foreach ($l['ctas'] as $c) {
            $btn_href = $c['btn_href'];
            if (strpos($btn_href, 'index.html#') === 0) {
                $btn_href = home_url('/') . '#' . substr($btn_href, strlen('index.html#'));
            }
            $cta_lines[] = implode(' | ', array($c['titulo'], $c['texto'], $c['btn_text'], $btn_href));
        }
        if ($cta_lines) {
            update_post_meta($post_id, 'livro_ctas', implode("\n", $cta_lines));
        }

        $thumb_id = dec_import_theme_image($l['cover_img'], $l['title'] . ' - capa');
        if ($thumb_id) {
            set_post_thumbnail($post_id, $thumb_id);
        }
    }
}


function dec_seed_artigos() {
    if (get_posts(array('post_type' => 'artigo', 'posts_per_page' => 1, 'post_status' => 'any'))) {
        return;
    }
    $artigos = array(
    array(
        'title' => 'Insight no TB',
        'pdf' => 'artigo - Insight no TB.pdf',
    ),
    array(
        'title' => 'Santos Dumont',
        'pdf' => 'artigo - Santos Dumont.pdf',
    ),
    array(
        'title' => 'TB autoavaliação',
        'pdf' => 'artigo - TB autoavaliação.pdf',
    ),
    array(
        'title' => 'TB autoavaliação 2',
        'pdf' => 'artigo - TB autoavaliação2.pdf',
    ),
    array(
        'title' => 'TB Evolução 12 Meses',
        'pdf' => 'artigo - TB evolução 12 meses.pdf',
    ),
    array(
        'title' => 'TB Evolução 5 Anos',
        'pdf' => 'artigo - TB evolução 5 anos.pdf',
    ),
    array(
        'title' => 'Antidepressivos no TB',
        'pdf' => 'artigo - antidepressivos no TB.pdf',
    ),
    array(
        'title' => 'Atenção no TB',
        'pdf' => 'artigo - atenção no TB.pdf',
    ),
    array(
        'title' => 'Criatividade no TB',
        'pdf' => 'artigo - Criatividade no TB.pdf',
    ),
    array(
        'title' => 'Energia na Mania',
        'pdf' => 'artigo - energia na mania.pdf',
    ),
    array(
        'title' => 'Energia no TB',
        'pdf' => 'artigo - energia no TB.pdf',
    ),
    array(
        'title' => 'Escala Catatonia',
        'pdf' => 'artigo - escala catatonia.pdf',
    ),
    array(
        'title' => 'Escala Insight',
        'pdf' => 'artigo - escala insight.pdf',
    ),
    array(
        'title' => 'Energia na Mania',
        'pdf' => 'artigo - energia na mania.pdf',
    ),
    array(
        'title' => 'Filmes Woody',
        'pdf' => 'artigo - filmes Woody.pdf',
    ),
    array(
        'title' => 'Filosofia da Mente',
        'pdf' => 'artigo - filosofia mente.pdf',
    ),
    array(
        'title' => 'Lamotrigina na Depressão BP',
        'pdf' => 'artigo - lamotrigina na depressão bp.pdf',
    ),
    array(
        'title' => 'Lamotrigina Virada',
        'pdf' => 'artigo - lamotrigina virada.pdf',
    ),
    array(
        'title' => 'Mania com Delirium',
        'pdf' => 'artigo- mania com delirium.pdf',
    ),
    array(
        'title' => 'Neurobiologia da Psicanálise',
        'pdf' => 'artigo - neurobiologia da psicanálise.pdf',
    ),
    array(
        'title' => 'Sonhos',
        'pdf' => 'artigo - sonhos.pdf',
    ),
    array(
        'title' => 'TR Esquizoafetivo',
        'pdf' => 'artigo - tr esquizoafetivo.pdf',
    ),
);
    $placeholder = dec_import_theme_image('carreira-16.jpg', 'Artigo - imagem padrão');

    foreach ($artigos as $a) {
        $post_id = wp_insert_post(array(
            'post_title' => $a['title'],
            'post_type' => 'artigo',
            'post_status' => 'publish',
        ));
        if (!$post_id) {
            continue;
        }
        update_post_meta($post_id, 'artigo_pdf', $a['pdf']);
        if ($placeholder) {
            set_post_thumbnail($post_id, $placeholder);
        }
    }
}


function dec_seed_entrevistas() {
    if (get_posts(array('post_type' => 'entrevista', 'posts_per_page' => 1, 'post_status' => 'any'))) {
        return;
    }
    $entrevistas = array(
    'jornais' => array(
        'cards' => array(
            array(
                'title' => '"Entrevista com Elie Cheniaux sobre seu livro"',
                'desc' => 'Elie Cheniaux fala sobre livro que aborda transtornos mentais nos filmes.',
                'tag' => 'Jornal do Commércio de Pernambuco',
                'cat' => '2024',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => '"LOUCURA NAS TELAS"',
                'desc' => 'Com personagens muito doidos, filmes ampliam compreensão sobre doenças mentais; cineterapia é a nova moda em tratamento psicológico.',
                'tag' => 'Folha de S.Paulo',
                'cat' => '2024',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => '"Seu mau-humor está durando muito tempo?"',
                'desc' => 'Faça o teste e descubra se isso é normal.',
                'tag' => 'UOL - Notícias',
                'cat' => '2023',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => '"Especialistas dizem que é impossível passar um dia sem mentir, mas há casos normais e doentios"',
                'desc' => '',
                'tag' => 'UOL - Universa',
                'cat' => '2023',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => '"Saúde Mental"',
                'desc' => '',
                'tag' => 'Folha de S.Paulo',
                'cat' => '2022',
                'img' => '',
                'href' => '#',
            ),
        ),
        'filters' => array(
        ),
    ),
    'tv' => array(
        'cards' => array(
            array(
                'title' => '"Entrevista no Programa do Jô"',
                'desc' => 'Dr. Elie Cheniaux é um dos autores do livro “Cinema e Loucura”.',
                'tag' => 'TV Globo',
                'cat' => 'aberta',
                'img' => 'entrevista-jo.avif',
                'href' => 'https://globoplay.globo.com/v/2112130/',
            ),
            array(
                'title' => '"Debate sobre Educação"',
                'desc' => 'Discussão sobre o papel da educação humanística no século XXI.',
                'tag' => 'Record News',
                'cat' => 'aberta',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => '"Série Pensadores Brasileiros"',
                'desc' => 'Episódio da série dedicada a intelectuais e pensadores do Brasil contemporâneo.',
                'tag' => 'Canal Futura',
                'cat' => 'fechada',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => '"Entrevista Canal Cultural"',
                'desc' => 'Conversa longa e aprofundada sobre trajetória literária e acadêmica.',
                'tag' => 'YouTube',
                'cat' => 'web',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => '"Lançamento da Obra"',
                'desc' => 'Entrevista sobre o mais recente livro publicado e sua recepção pelo público.',
                'tag' => 'TV Brasil',
                'cat' => 'aberta',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => '"Mesa de Debates Online"',
                'desc' => 'Participação em painel virtual sobre literatura contemporânea brasileira.',
                'tag' => 'Vimeo',
                'cat' => 'web',
                'img' => '',
                'href' => '#',
            ),
        ),
        'filters' => array(
            'Todos',
            'TV Aberta',
            'TV a Cabo',
            'Web TV',
        ),
    ),
    'podcast' => array(
        'cards' => array(
            array(
                'title' => 'Podcast Letras & Vozes',
                'desc' => '"Literatura e Memória no Brasil Contemporâneo" — Conversa sobre os temas centrais da obra mais recente.',
                'tag' => 'Cultura',
                'cat' => 'cultura',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => 'Ciência em Pauta',
                'desc' => '"Pesquisa Humanística e Futuro das Ciências Humanas" — Debate sobre o futuro da pesquisa no Brasil.',
                'tag' => 'Academia',
                'cat' => 'academia',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => 'Passado Presente',
                'desc' => '"A Marinha e a História do Brasil" — Análise histórica sobre o papel da Marinha na formação nacional.',
                'tag' => 'História',
                'cat' => 'historia',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => 'Leituras do Sul',
                'desc' => '"Escritores Brasileiros Hoje" — Reflexões sobre o mercado editorial e o ofício do escritor no Brasil.',
                'tag' => 'Cultura',
                'cat' => 'cultura',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => 'Vozes Acadêmicas',
                'desc' => '"Memória, Identidade e Pesquisa" — Conversa com pesquisadores sobre os caminhos da produção científica.',
                'tag' => 'Academia',
                'cat' => 'academia',
                'img' => '',
                'href' => '#',
            ),
            array(
                'title' => 'História do Brasil',
                'desc' => '"Documentos e Memória Nacional" — Debate sobre arquivos históricos e preservação da memória.',
                'tag' => 'História',
                'cat' => 'historia',
                'img' => '',
                'href' => '#',
            ),
        ),
        'filters' => array(
            'Todos',
            'Cultura',
            'Academia',
            'História',
        ),
    ),
);

    foreach ($entrevistas as $tipo => $group) {
        foreach ($group['cards'] as $card) {
            $title = trim($card['title'], '"');
            $post_id = wp_insert_post(array(
                'post_title' => $title ?: $card['tag'],
                'post_excerpt' => $card['desc'],
                'post_type' => 'entrevista',
                'post_status' => 'publish',
            ));
            if (!$post_id) {
                continue;
            }
            wp_set_post_terms($post_id, array($tipo), 'entrevista_tipo', false);
            if ($card['cat']) {
                wp_set_post_terms($post_id, array($card['cat']), 'entrevista_filtro', false);
            }
            update_post_meta($post_id, 'entrevista_veiculo', $card['tag']);
            update_post_meta($post_id, 'entrevista_data', $card['cat']);
            update_post_meta($post_id, 'entrevista_link', $card['href'] === '#' ? '' : $card['href']);
            if ($card['img']) {
                $thumb_id = dec_import_theme_image($card['img'], $title);
                if ($thumb_id) {
                    set_post_thumbnail($post_id, $thumb_id);
                }
            }
        }
    }
}


function dec_seed_palestras() {
    if (get_posts(array('post_type' => 'palestra', 'posts_per_page' => 1, 'post_status' => 'any'))) {
        return;
    }
    $palestras = array(
    array(
        'title' => 'Rio 2C',
        'desc' => 'Rio 2C.',
        'img' => 'PalestraRio2c.jpg',
    ),
    array(
        'title' => 'TV',
        'desc' => '',
        'img' => 'IMG_20230326_073823_581.jpg',
    ),
    array(
        'title' => 'Palestra Humanidades',
        'desc' => 'Palestra Humanidades.',
        'img' => 'PalestraHumanidades.jpg',
    ),
);

    foreach ($palestras as $p) {
        $post_id = wp_insert_post(array(
            'post_title' => $p['title'],
            'post_excerpt' => $p['desc'],
            'post_type' => 'palestra',
            'post_status' => 'publish',
        ));
        if (!$post_id) {
            continue;
        }
        if ($p['img']) {
            $thumb_id = dec_import_theme_image($p['img'], $p['title']);
            if ($thumb_id) {
                set_post_thumbnail($post_id, $thumb_id);
            }
        }
    }
}


function dec_seed_encontros_gallery() {
    $imgs = array(
    array(
        'src' => 'Jorge Alberto Costa e Silva.jpeg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Jô Soares.jpeg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Natália Mota.jpeg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Roberto Lent.JPG',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Ruy Castro.jpg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Banca promoção professor titular.jpg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Alexandre Valença.jpeg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Antonio Egidio Nardi.JPG',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Bruno Reys, Denise Monteiro e Gulnar Azevedo.jpeg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Eric Kandel.JPG',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Flávio Kapczinsk.jpeg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Guilherme Messas, Maurício Viotti e Paulo Dalgalarrondo.jpg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Humberto Correa.jpeg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Leandro e Rondinelli.jpeg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Miguel Chalub.JPG',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Paulo Pavão e Roberto Piedade.jpeg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Paulo Pavão.jpeg',
        'alt' => 'TV',
    ),
    array(
        'src' => 'Valentim Gentil e Fábio Gomes de Matos.jpeg',
        'alt' => 'TV',
    ),
);
    set_theme_mod('dec_encontros_preview', $imgs);
}
