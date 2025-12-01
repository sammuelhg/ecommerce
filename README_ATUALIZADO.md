# Documentação do Sistema E-commerce LosFit

**Última atualização:** 01/12/2025

---

## Visão Geral

Sistema de e-commerce desenvolvido com Laravel 12, Livewire 3 e Bootstrap 5 para venda de produtos de moda fitness, praia, crochê e suplementos alimentares da marca LosFit.

## Stack Tecnológica

- **Backend**: Laravel 12.x + PHP 8.2+
- **Frontend**: Bootstrap 5.3+, Alpine.js, Livewire 3
- **Banco de Dados**: MySQL
- **Autenticação**: Laravel UI + Socialite (Google, Facebook)
- **Build**: Vite

---

## Funcionalidades Principais

### 1. Hierarquia de Categorias (SEO Otimizado)

#### Estrutura
- **parent_id**: Campo para relacionamento hierárquico
- **URLs aninhadas**: `/loja/categoria/{parent}/{child}`

#### Categorias Atuais
**Principais:**
- ModaFit (`/loja/categoria/fit`)
- ModaPraia (`/loja/categoria/praia`)
- ModaCrochê (`/loja/categoria/croche`)
- Suplementos (`/loja/categoria/suplementos`) - Categoria genérica para SEO

**Subcategorias:**
- LosfitNutri (`/loja/categoria/suplementos/losfitnutri`) - Marca própria

#### Campos
- `name`: Nome da categoria
- `slug`: URL amigável  
- `description`: Descrição para SEO
- `parent_id`: ID da categoria pai (nullable)
- `is_active`: Status

### 2. Sistema de Atributos de Produto

#### Campo "Attribute"
Novo campo genérico adicionado aos produtos:
- Posicionado entre `color` e `size`
- Tamanho: 100 caracteres
- Exemplos: "Manga Longa", "Estampado", "Premium"
- Adicionado automaticamente ao título do produto
- Permite diferenciar produtos além de cor e tamanho

### 3. Sistema de Variações com Cores Dinâmicas

#### ColorHelper (`app/Helpers/ColorHelper.php`)
Mapeamento de nomes de cores para códigos hexadecimais:
- 40+ cores pré-definidas (vermelho, azul marinho, rosa choque, etc.)
- Método: `ColorHelper::getHex('azul marinho')` retorna `#000080`

#### Exibição na Página do Produto
**Cores:**
- Botões circulares (40px) com cor real da paleta
- Tooltip mostrando nome e estoque
- Agrupamento por `product_model_id` + `product_type_id`
- Soma de estoque de todas as variações
- Esgotados: translú cidos + linha vermelha diagonal

**Tamanhos:**
- Labels com estoque: "M (8)"
- Desabilitado quando `stock = 0`

### 4. Duplicação Inteligente de Produtos

#### Modal ProductDuplicateModal
Ao clicar em "Duplicar", abre modal com campos:
- Atributo
- Cor
- Tamanho

#### Validação
- Exige alteração de **pelo menos 1** campo
- Se todos iguais = erro com mensagem

#### Comportamento
- Nome atualizado com novo atributo
- SKU sempre novo (incremental)
- Slug único (com uniqid())
- **Sem** sufixo "(Cópia)"

### 5. Sistema de SKU Automático

#### SkuGeneratorService
**Formato**: `CATEGORIA-TIPO-SEQ-COR-TAM`

**Exemplo**: `FIT-CAM-0001-PRETO-M`
- FIT: Categoria
- CAM: Tipo  
- 0001: Sequencial auto-incrementado
- PRETO: Cor
- M: Tamanho

#### Regras
- SKUs vazios convertidos para `null` (evita constraint violation)
- Gerado ao salvar produto com tipo + cor + tamanho
- Opcional para produtos sem atributos completos

### 6. Gestão de Imagens Avançada (Novo)

#### Funcionalidades
- **Upload Direto**: Interface simplificada para upload múltiplo.
- **Preview Instantâneo**: Visualização imediata das imagens selecionadas antes do upload.
- **Cropper.js**: Ferramenta de corte integrada para ajustar imagens (quadradas 1:1).
- **Galeria Visual**: Grid responsivo com ações rápidas (definir capa, excluir).
- **Otimização**: Conversão automática para WebP e redimensionamento via `MediaService`.

### 7. Precificação Avançada (Novo)

#### Novos Campos
- **Preço de Custo (`cost_price`)**: Para cálculo de margem interna.
- **Preço "De" (`compare_at_price`)**: Para exibir promoções (ex: De R$ 100 por R$ 80).
- **Preço de Venda (`price`)**: Preço final ao consumidor.

---

## CRUD Administrativo

### CRUD de Categorias (`/admin/categories`)

**Campos:**
- Nome
- Slug (auto-gerado)
- **Descrição (SEO)** - Textarea para conteúdo rico
- **Categoria Pai** - Dropdown para criar subcategorias
- Status (Ativo/Inativo)

**Exibição no ProductForm:**
- Hierárquica: `Suplementos > LosfitNutri`

### CRUD de Produtos (`/admin/products`)

**Interface Renovada:**
- **Abas**: Geral, Imagens, Preço & Estoque, SEO & Marketing.
- **Layout**: Mais limpo e organizado, com validações em tempo real.

**Campos:**
- **Geral**: Nome (auto-gerado), Categoria, Tipo, Modelo, Material, Cor, Tamanho, Atributo.
- **Imagens**: Upload múltiplo, galeria, definição de capa.
- **Preço**: Preço de Venda, Preço "De", Preço de Custo, Estoque, SKU.
- **SEO**: Slug (readonly), Descrição Detalhada.

**Botões:**
- **Salvar/Atualizar**: Sempre visível no topo das abas.
- **Duplicar**: Modal inteligente para criar variações rapidamente.
- **Excluir**: Com confirmação.

---

## Sistema de Autenticação

### Login Padrão
- Laravel UI (email + senha)
- Recuperação de senha

### Login Social
- Google OAuth
- Facebook Login
- Campos adicionais na tabela `users`:
  - `google_id`, `facebook_id`, `avatar`
  - `password` nullable

### Persistência
- Carrinho e wishlist sincronizados após login social
- Emails de boas-vindas enviados automaticamente

---

## Instalação

```bash
# 1. Clonar repositório
git clone <url>
cd ecommerce-hp

# 2. Dependências
composer install
npm install

#3. Ambiente
cp .env.example .env
php artisan key:generate

# 4. Banco de dados
php artisan migrate --seed

# 5. Storage
php artisan storage:link

# 6. Build
npm run build

# 7. Servidor
php artisan serve
```

---

## Estrutura do Banco

### Principais Tabelas

**products**
- Campos de atributos: `color`, `attribute`, `size`
- Relacionamentos: `category_id`, `product_type_id`, `product_model_id`, `product_material_id`
- SKU único (nullable)

**categories**
- Hierárquica com `parent_id`
- Campo `description` para SEO

**users**
- Social login: `google_id`, `facebook_id`, `avatar`
- Perfil: `phone`, `address`, `birth_date`

---

## Services

- **SkuGeneratorService**: Geração automática de SKUs
- **ColorHelper**: Mapeamento de cores
- **CartService**: Gerenciamento de carrinho
- **WishlistService**: Lista de desejos
- **MediaService**: Otimização de imagens (WebP, redimensionamento)

---

## Rotas Principais

### Loja
- `/loja` - Catálogo
- `/loja/categoria/{slug}` - Categoria
- `/loja/categoria/{parent}/{child}` - Subcategoria
- `/loja/produto/{slug}` - Detalhe do produto

### Admin
- `/admin` - Dashboard
- `/admin/products` - Produtos
- `/admin/categories` - Categorias
- `/admin/types` - Tipos
- `/admin/materials` - Materiais
- `/admin/models` - Modelos

---

**Desenvolvido para LosFit - Moda Fitness, Praia, Crochê e Suplementos**
