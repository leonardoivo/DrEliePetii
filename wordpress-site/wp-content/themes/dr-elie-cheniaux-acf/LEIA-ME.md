# Tema Dr. Elie Cheniaux — versão ACF

Mesmo site e mesmo visual do tema `dr-elie-cheniaux`, mas os campos personalizados
(imagens, PDFs e os dados de Livros/Artigos/Entrevistas/Palestras) são geridos
pelo plugin **Advanced Custom Fields**.

## Instalação

1. **Plugins → Adicionar novo** → procure por **"Advanced Custom Fields"** → Instalar → Ativar.
   (A versão gratuita basta. Com **ACF PRO** a tela de mídia global fica um pouco melhor — ver abaixo.)
2. **Aparência → Temas** → ative **"Dr. Elie Cheniaux (ACF)"**.

Os grupos de campos são registrados por código (`inc/acf-fields.php`) — não é
preciso criar nada na interface do ACF. Se o plugin não estiver ativo, aparece um
aviso no admin e o site continua no ar usando as imagens padrão do tema.

## Onde editar

### Imagens/PDFs de um post
Abra o Livro / Artigo / Entrevista / Palestra e edite os campos ACF na página de
edição. Campos de imagem/arquivo abrem a Biblioteca de Mídia.

- **Livro:** capa para listagens, capa do topo, capa alternativa (se vazias, usa a Imagem destacada).
- **Artigo:** arquivo PDF + altura + barra de ferramentas + posição (antes/depois do texto). O editor de texto do artigo é opcional.
- **Entrevista:** veículo, link, data + o box lateral "Classificação da Entrevista" (Tipo: Jornal/TV/Podcast e Filtro).
- **Palestra:** link do vídeo.

### Galeria da página "Encontros Especiais"
Edite direto na página: **Páginas → "Encontros Especiais" → editar**. O grupo ACF
**"Galeria de fotos — Encontros Especiais"** aparece nessa tela (campo *gallery*).
As fotos aparecem abaixo do cabeçalho verde; as 4 primeiras vão também para a
Página inicial. Texto do editor de blocos passou a aparecer abaixo do cabeçalho.

### Imagens/PDFs gerais do site
- **Com ACF PRO:** menu **Aparência → Mídia do Site** (página de opções do ACF, com abas).
- **Sem ACF PRO:** menu **Aparência → Mídia do Site** leva a uma página privada
  chamada "Mídia do Site" (criada automaticamente, não aparece no site público).
  Edite os campos ACF dessa página e clique em **Atualizar**.

Conteúdo: foto principal, os 5 cartões "Quem sou eu", foto do Discurso, foto + PDF
do Memorial (com altura/toolbar/posição), os 3 cartões de Entrevistas, as fotos de
topo das páginas BiPoLaB e Palestras, e a galeria "Encontros Especiais".

### Logo e favicon
Iguais à versão sem plugin: **Aparência → Personalizar → Identidade do site**
(Logo e Ícone do site).

## Compatibilidade

Os nomes dos campos ACF são iguais às chaves de metadados que os templates já
liam, e os campos de imagem/arquivo retornam o **ID do anexo**. Por isso os
arquivos de template são idênticos aos da versão sem plugin — a diferença está
só na camada de edição.

Valores antigos (nome de arquivo em `img/` ou `pdf/`) seguem funcionando até
serem substituídos por um item da Biblioteca de Mídia.
