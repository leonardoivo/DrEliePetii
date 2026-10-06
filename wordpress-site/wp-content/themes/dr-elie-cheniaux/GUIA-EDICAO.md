# Editar imagens e PDFs pelo navegador — tema Dr. Elie Cheniaux (versão sem plugin)

Nada aqui exige mexer em código ou banco de dados. Tudo é feito no wp-admin.

## 1. Imagens e PDFs "do site" (fora de Livros/Artigos/Entrevistas/Palestras)

**Aparência → Mídia do Site.**

Cada item tem um botão **Selecionar imagem** / **Selecionar arquivo** que abre a
Biblioteca de Mídia (dá para enviar um arquivo novo na hora). Depois de escolher,
role até o fim e clique em **Salvar alterações**. Campo deixado em branco continua
usando a imagem padrão do tema.

O que dá para trocar nessa tela:

| Seção | Onde aparece no site |
|---|---|
| Foto principal | topo da Página inicial e da página Biografia |
| Cartões "Quem sou eu" (5) | blocos da Página inicial (Biografia, BiPoLaB, Currículo, Discurso, Memorial) |
| Página Discurso | foto do topo |
| Página Memorial | foto do topo + **PDF** + altura do PDF + barra de ferramentas + posição (antes/depois do texto) |
| Cartões de Entrevistas (3) | Página inicial e páginas de listagem de entrevistas |
| Outras páginas | foto do topo da página **BiPoLaB** e da listagem de **Palestras** |
| Galeria "Encontros Especiais" | usada como reserva — o normal é editar direto na página (veja abaixo) |

### Galeria da página "Encontros Especiais"

Edite **na própria página**: Páginas → "Encontros Especiais" → editar. Abaixo do
editor de blocos há a caixa **"Galeria de fotos — Encontros Especiais"**: adicione
várias fotos de uma vez e arraste para reordenar. Elas aparecem **abaixo do
cabeçalho verde**; as 4 primeiras vão também para a Página inicial. A legenda de
cada foto é o *título* do anexo na Biblioteca de Mídia.

Texto digitado no editor de blocos dessa página agora aparece **abaixo do
cabeçalho verde**, antes da galeria (antes caía dentro da barra verde).

### Logo e favicon

- **Logo do menu:** Aparência → Personalizar → Identidade do site → **Logo**.
- **Favicon (ícone da aba):** Aparência → Personalizar → Identidade do site → **Ícone do site**.

Sem nada definido, o tema usa os arquivos padrão (`DrElieLogo.avif` / `DrElieLogo.ico`).

## 2. Imagens e PDFs de um Livro / Artigo / Entrevista / Palestra

Abra o post (ex.: **Livros → editar "O Antifacebook"**). No box de detalhes:

- **Livro:** "Capa para as listagens", "Capa grande no topo", "Capa alternativa" —
  cada uma com botão de seleção de mídia. Se ficarem vazias, o tema usa a
  **Imagem destacada** do post (coluna da direita).
- **Artigo:** "Arquivo PDF do artigo" (seleção de mídia) + "Altura", "Barra de
  ferramentas" e "Posição do PDF em relação ao texto". O campo de texto grande do
  artigo é opcional — escreva ali uma introdução se quiser; o PDF fica antes ou
  depois conforme a opção escolhida.

## 3. Compatibilidade

Valores antigos (nome de arquivo dentro das pastas `img/` e `pdf/` do tema)
continuam funcionando. Ao selecionar um arquivo pela Biblioteca de Mídia, ele
passa a ser servido de `wp-content/uploads` e o valor antigo é substituído.
