# LosFit E-commerce High-Performance

Plataforma de comércio eletrônico moderna e de alta performance, desenvolvida para a marca LosFit. Focada em modularidade, SEO e experiência do usuário.

## 🚀 Visão Geral

Este projeto é um e-commerce completo construído com **Laravel 12**, utilizando **Livewire 3** para interatividade e **Bootstrap 5** para estilização. O sistema conta com recursos avançados de gestão de produtos, variações, atributos e uma área administrativa robusta.

---

## ✨ Funcionalidades Principais

### 🛍️ Experiência de Compra
- **Catálogo Dinâmico:** Listagem de produtos com filtros e busca rápida.
- **Carrinho Persistente:** Itens do carrinho são salvos no banco de dados para usuários logados, garantindo que não se percam entre sessões.
- **Wishlist (Lista de Desejos):** Salve produtos favoritos para comprar depois.
- **Busca Inteligente:** Barra de pesquisa com sugestões e histórico recente.

### 🔐 Autenticação e Usuários
- **Login Social:** Integração com **Google** e **Facebook** (OAuth 2.0).
- **Cadastro Simplificado:** Registro rápido com email ou redes sociais.
- **Área do Cliente:** Gestão de perfil, endereços e histórico de pedidos.
- **Emails Transacionais:** Sistema automatizado de boas-vindas e notificações.

### 📦 Gestão de Produtos (Admin)
- **SKU Automático:** Geração inteligente de SKUs sequenciais (ex: `CAL-TEN-0001-PRT-42`).
- **Títulos SEO:** Geração automática de títulos otimizados baseados nos atributos.
- **Atributos Dinâmicos:** Gestão completa de Tipos, Materiais, Modelos, Cores e Tamanhos.
- **Otimização de Mídia:** Conversão automática de imagens para WebP e redimensionamento.

### 🔧 Painel Administrativo
- **Dashboard Intuitivo:** Visão geral com métricas e atalhos rápidos.
- **CRUDs Completos:** Gestão total de produtos, categorias e atributos.
- **Design Moderno:** Interface limpa e responsiva, focada na produtividade.

---

## 🛠️ Tecnologias Utilizadas

- **Backend:** PHP 8.2+, Laravel 12
- **Frontend:** Blade, Livewire 3, Alpine.js, Bootstrap 5.3
- **Banco de Dados:** MySQL
- **Build Tool:** Vite
- **Outros:** Intervention Image (Manipulação de imagens), Laravel Socialite (Login Social)

---

## ⚙️ Instalação e Configuração

### Pré-requisitos
- PHP 8.2+ (com extensão GD)
- Composer
- Node.js & NPM
- MySQL

### Passo a Passo

1. **Clone o repositório**
   ```bash
   git clone https://github.com/seu-usuario/losfit-ecommerce.git
   cd losfit-ecommerce
   ```

2. **Instale as dependências**
   ```bash
   composer install
   npm install
   ```

3. **Configure o ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Configure as credenciais do banco de dados no arquivo `.env`.*

4. **Execute as migrações e seeds**
   ```bash
   php artisan migrate --seed
   ```

5. **Compile os assets**
   ```bash
   npm run build
   ```

6. **Inicie o servidor**
   ```bash
   php artisan serve
   ```
   Acesse: `http://localhost:8000`

---

## 📄 Licença

Este projeto é proprietário e desenvolvido exclusivamente para a LosFit. Todos os direitos reservados.
