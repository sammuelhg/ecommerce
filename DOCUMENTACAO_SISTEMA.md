# 📘 Documentação Completa do Sistema LosFit E-commerce

**Versão:** 1.0.0
**Data de Atualização:** 01/12/2025
**Status:** Em Desenvolvimento Ativo

---

## 1. 🎯 Visão Geral e Propósito

O **LosFit E-commerce** é uma plataforma robusta e moderna desenvolvida para a venda de produtos de moda fitness, praia, crochê e suplementos. O sistema prioriza uma experiência de usuário premium, alta performance e otimização para SEO, além de fornecer um painel administrativo poderoso para gestão de catálogo.

### Diferenciais do Sistema
*   **Gestão Visual de Produtos**: Upload de múltiplas imagens com preview instantâneo e definição de capa.
*   **SEO Nativo**: Geração automática de slugs, meta descriptions e títulos otimizados.
*   **Precificação Flexível**: Suporte a preços promocionais ("De/Por") e preço de custo para análise de margem.
*   **Variações Dinâmicas**: Controle de estoque por cor e tamanho com visualização intuitiva.

---

## 2. 🏗️ Arquitetura Técnica

O projeto segue o padrão MVC (Model-View-Controller) utilizando o ecossistema Laravel.

### Stack Tecnológica
*   **Backend**: Laravel 12.x (PHP 8.2+)
*   **Frontend Interativo**: Livewire 3 (Full-stack framework) + Alpine.js
*   **Estilização**: Bootstrap 5.3 (Customizado) + CSS Nativo
*   **Banco de Dados**: MySQL 8.0
*   **Build Tool**: Vite

### Estrutura de Pastas Chave
```
app/
├── Livewire/           # Componentes da lógica de interface (Admin & Loja)
│   ├── Admin/          # Gestão (ProductForm, ProductIndex, etc.)
│   └── Shop/           # Frontend (ProductShow, Cart, etc.)
├── Models/             # Modelos Eloquent (Product, Category, ProductImage)
├── Services/           # Lógica de negócio complexa (MediaService, CartService)
└── Helpers/            # Funções auxiliares (ColorHelper)

resources/views/
├── livewire/           # Templates Blade dos componentes
│   └── admin/
│       └── product-form/ # Partials do formulário (general, images, pricing, seo)
└── components/         # Componentes reutilizáveis de UI
```

---

## 3. 🚀 Guia de Instalação

### Pré-requisitos
*   PHP >= 8.2
*   Composer
*   Node.js & NPM
*   MySQL

### Passo a Passo
1.  **Clonar Repositório**:
    ```bash
    git clone <url-do-repo>
    cd ecommerce-hp
    ```
2.  **Instalar Dependências**:
    ```bash
    composer install
    npm install
    ```
3.  **Configurar Ambiente**:
    ```bash
    cp .env.example .env
    # Configurar DB_DATABASE, DB_USERNAME, DB_PASSWORD no .env
    php artisan key:generate
    ```
4.  **Banco de Dados**:
    ```bash
    php artisan migrate --seed
    ```
5.  **Link de Storage** (Crucial para imagens):
    ```bash
    php artisan storage:link
    ```
6.  **Executar**:
    ```bash
    npm run dev   # Em um terminal
    php artisan serve # Em outro terminal
    ```

---

## 4. 📦 Módulos e Funcionalidades

### 4.1 Gestão de Produtos (`ProductForm`)
O coração do painel administrativo. Foi refatorado para usar abas e partials para melhor organização.

*   **Aba Geral**:
    *   Dados básicos: Categoria, Tipo, Modelo, Material.
    *   Atributos: Cor, Tamanho, Atributo Extra.
    *   *Feature*: O título é gerado automaticamente combinando esses atributos.
*   **Aba Imagens**:
    *   **Upload**: Área de drag-and-drop ou seleção múltipla.
    *   **Preview**: Cards com visualização imediata antes do upload.
    *   **Galeria**: Grid de imagens existentes com opção de definir capa (estrela) e excluir.
*   **Aba Preço & Estoque**:
    *   `price`: Preço de venda.
    *   `compare_at_price`: Preço original (riscado na loja).
    *   `cost_price`: Custo interno (não visível ao cliente).
    *   `sku`: Gerado automaticamente ou editável.
*   **Aba SEO & Marketing**:
    *   `slug`: URL amigável (readonly, gerado do nome).
    *   `description`: Descrição completa com suporte a HTML.

### 4.2 Gestão de Categorias
Sistema hierárquico (Pai > Filho) que permite URLs como `/loja/suplementos/whey-protein`. Inclui campo de descrição rica para SEO da página de categoria.

---

## 5. 📏 Regras de Negócio e Padrões

### 5.1 Padrão de SKU
O SKU deve seguir o formato: `CATEGORIA-TIPO-SEQ-COR-TAM`
*   Exemplo: `FIT-LEG-001-PRETO-M`
*   Objetivo: Identificação rápida visual e rastreabilidade.

### 5.2 Cores (`ColorHelper`)
O sistema não usa inputs de cor livres (color picker) para evitar inconsistências.
*   Usa-se nomes de cores padronizados ("Azul Marinho", "Rosa Choque").
*   O `ColorHelper` converte esses nomes para Hexadecimal na exibição do frontend (bolinhas de cor).

### 5.3 Imagens
*   **Proporção**: Quadrada (1:1) é o padrão recomendado.
*   **Formato**: O sistema converte uploads para WebP para performance.
*   **Limite**: Max 20MB por arquivo (configurável em `livewire.php`).

---

## 6. 🛠️ Guia de Desenvolvimento e Manutenção

### Como adicionar um novo campo ao Produto?
Este é um fluxo comum. Siga estes passos "do início ao final":

1.  **Banco de Dados**: Crie uma migration para adicionar a coluna na tabela `products`.
    ```bash
    php artisan make:migration add_new_field_to_products_table
    ```
2.  **Model**: Adicione o campo ao array `$fillable` em `app/Models/Product.php`.
3.  **Componente Livewire**:
    *   Adicione a propriedade pública em `app/Livewire/Admin/ProductForm.php`.
    *   Adicione a regra de validação no array `$rules`.
    *   Adicione o campo ao array `$data` no método `save()`.
    *   Adicione a atribuição no método `loadProduct()` (para edição).
4.  **View**: Adicione o input HTML no arquivo partial apropriado (ex: `resources/views/livewire/admin/product-form/general.blade.php`).

### Debug de Problemas Comuns
*   **"Multiple root elements detected"**: Todo componente Livewire deve ter **uma única** `<div>` raiz envolvendo tudo.
*   **Imagens não aparecem**: Verifique se `php artisan storage:link` foi rodado e se a pasta `storage/app/public` tem permissões.
*   **Abas não trocam**: Verifique se o `wire:click="$set('activeTab', ...)"` está configurado corretamente nos botões.

---

## 7. 📜 Histórico de Decisões (Log de Arquitetura)

*   **01/12/2025**: Removida funcionalidade de remoção de fundo com IA (Python) devido à complexidade de manutenção. Foco total em upload rápido e crop via JS.
*   **01/12/2025**: Refatoração do `ProductForm` para Abas. O formulário único estava muito longo e difícil de manter.
*   **30/11/2024**: Adoção de `ProductImage` como model separado para permitir múltiplas imagens e ordenação futura.

---

> **Nota Final**: Este documento deve ser a fonte única de verdade. Ao alterar uma regra de negócio ou arquitetura, atualize este arquivo primeiro.
