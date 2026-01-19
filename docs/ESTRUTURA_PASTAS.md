# 📁 Estrutura de Pastas - Losfit E-commerce

> **Última atualização:** 2025-12-18
> **Domínio:** losfit.com.br

---

## 📂 Raiz do Projeto (`/ecommerce-hp`)

```
ecommerce-hp/
├── 📁 app/                         # Código principal da aplicação
│   ├── 📁 Actions/                 # Actions (Single Responsibility)
│   ├── 📁 Cms/                     # Sistema CMS
│   ├── 📁 Console/                 # Comandos Artisan
│   ├── 📁 DTOs/                    # Data Transfer Objects
│   ├── 📁 Domains/                 # Domain-Driven Design
│   │   ├── 📁 Admin/               # Domínio Administrativo
│   │   │   ├── 📁 Providers/       # Service Providers
│   │   │   └── 📁 Routes/          # Rotas Admin
│   │   ├── 📁 Catalog/             # Produtos, Categorias, Atributos
│   │   │   ├── 📁 Models/          # Product, Category, etc.
│   │   │   └── 📁 Services/        # CatalogService
│   │   ├── 📁 Content/             # Stories, Páginas CMS
│   │   ├── 📁 Customer/            # Clientes, Wishlist
│   │   ├── 📁 Marketing/           # Campanhas, Leads, Newsletter
│   │   │   ├── 📁 Models/          # Campaign, Lead, Subscriber
│   │   │   └── 📁 Actions/         # SendCampaignAction
│   │   ├── 📁 Sales/               # Pedidos, Carrinho
│   │   └── 📁 Shared/              # Modelos compartilhados
│   ├── 📁 Enums/                   # Enumerações
│   ├── 📁 Events/                  # Event Classes
│   ├── 📁 Helpers/                 # Funções auxiliares
│   ├── 📁 Http/                    # Controllers, Middleware, Requests
│   │   ├── 📁 Controllers/         # Controllers MVC
│   │   │   ├── 📁 Admin/           # Controllers Admin
│   │   │   ├── 📁 Auth/            # Login, Register, Social
│   │   │   ├── 📁 Cms/             # Páginas CMS
│   │   │   ├── 📁 Shop/            # Contato, etc.
│   │   │   ├── 📁 Tracking/        # Pixel tracking
│   │   │   └── 📁 Web/             # Controllers Web
│   │   ├── 📁 Middleware/          # Auth, Admin, etc.
│   │   └── 📁 Requests/            # Form Requests
│   ├── 📁 Interfaces/              # Interfaces/Contracts
│   ├── 📁 Jobs/                    # Queue Jobs
│   ├── 📁 Listeners/               # Event Listeners
│   ├── 📁 Livewire/                # Componentes Livewire
│   │   ├── 📁 Admin/               # Componentes Admin
│   │   │   ├── 📁 Campaign/        # CampaignBuilder, CampaignIndex
│   │   │   ├── 📁 Crm/             # AudienceIndex, ExpenseManager
│   │   │   ├── 📁 Grid/            # GridManager
│   │   │   ├── 📁 Leads/           # LeadManager, LeadKanban
│   │   │   ├── 📁 Marketing/       # MarketingDashboard
│   │   │   ├── 📁 Newsletter/      # ContactManager
│   │   │   ├── 📁 Products/        # ProductForm, ProductTable
│   │   │   └── 📁 SignCard/        # SignCardManager
│   │   ├── 📁 Cms/                 # PageBuilder, ComponentBuilder
│   │   ├── 📁 Customer/            # Profile, etc.
│   │   ├── 📁 Forms/               # FormBuilder
│   │   ├── 📁 Integrations/        # WhatsApp, etc.
│   │   ├── 📁 Landing/             # Landing pages
│   │   └── 📁 Shop/                # Cart, Checkout, etc.
│   ├── 📁 Mail/                    # Mailable Classes
│   ├── 📁 Models/                  # Models Legacy
│   ├── 📁 Notifications/           # Notification Classes
│   ├── 📁 Providers/               # Service Providers
│   ├── 📁 Services/                # Business Services
│   ├── 📁 Settings/                # Settings Classes
│   └── 📁 View/                    # View Composers
│
├── 📁 bootstrap/                   # Bootstrap Laravel
│
├── 📁 config/                      # Configurações
│   ├── app.php                     # Configuração geral
│   ├── auth.php                    # Autenticação
│   ├── database.php                # Banco de dados
│   ├── filesystems.php             # Storage
│   ├── livewire.php                # Livewire config
│   ├── mail.php                    # Email SMTP
│   ├── services.php                # APIs externas
│   └── session.php                 # Sessões
│
├── 📁 database/                    # Banco de dados
│   ├── 📁 factories/               # Model Factories
│   ├── 📁 migrations/              # 86 migrations
│   └── 📁 seeders/                 # 16 seeders
│
├── 📁 lang/                        # Traduções
│   └── 📁 pt_BR/                   # Português Brasil
│
├── 📁 public/                      # Arquivos públicos (DocumentRoot)
│   ├── 📁 build/                   # Assets compilados (Vite)
│   ├── 📁 components/              # Componentes estáticos
│   ├── 📁 css/                     # CSS customizado
│   ├── 📁 deploy_assets/           # Assets de deploy
│   ├── 📁 email-assets/            # Imagens para emails
│   ├── 📁 js/                      # JavaScript customizado
│   ├── 📁 uploads/                 # Uploads de usuários
│   ├── index.php                   # Entry point
│   ├── .htaccess                   # Regras Apache
│   ├── robots.txt                  # SEO
│   └── site.webmanifest            # PWA manifest
│
├── 📁 resources/                   # Resources front-end
│   ├── 📁 css/                     # CSS source
│   ├── 📁 js/                      # JS source
│   ├── 📁 sass/                    # SASS files
│   └── 📁 views/                   # Blade templates
│       ├── 📁 admin/               # Views Admin
│       │   ├── 📁 campaigns/       # Campanhas
│       │   ├── 📁 categories/      # Categorias
│       │   ├── 📁 colors/          # Cores
│       │   ├── 📁 crm/             # CRM
│       │   ├── 📁 emails/          # Preview emails
│       │   ├── 📁 integrations/    # Integrações
│       │   ├── 📁 links/           # Links Bio
│       │   ├── 📁 orders/          # Pedidos
│       │   ├── 📁 products/        # Produtos
│       │   ├── 📁 settings/        # Configurações
│       │   └── 📁 users/           # Usuários
│       ├── 📁 auth/                # Login, Register
│       ├── 📁 cms/                 # Páginas CMS
│       ├── 📁 components/          # Blade Components
│       ├── 📁 emails/              # Templates de email
│       ├── 📁 landing/             # Landing pages
│       ├── 📁 layouts/             # Layouts base
│       ├── 📁 livewire/            # Views Livewire
│       ├── 📁 newsletter/          # Newsletter views
│       ├── 📁 shop/                # Loja Views
│       ├── 📁 user/                # Área do cliente
│       └── 📁 vendor/              # Pacotes terceiros
│
├── 📁 routes/                      # Definição de rotas
│   ├── web.php                     # Rotas públicas
│   ├── api.php                     # Rotas API
│   └── test_web.php                # Rotas de teste
│
├── 📁 storage/                     # Storage Laravel
│   ├── 📁 app/                     # Arquivos da app
│   ├── 📁 framework/               # Cache, sessions, views
│   └── 📁 logs/                    # Logs da aplicação
│
├── 📁 tests/                       # Testes PHPUnit
│
├── 📁 vendor/                      # Dependências Composer
│
├── 📁 .github/                     # GitHub Actions
│   └── 📁 workflows/               # CI/CD workflows
│
├── .env                            # Variáveis de ambiente
├── artisan                         # CLI Laravel
├── composer.json                   # Dependências PHP
├── package.json                    # Dependências Node
└── vite.config.js                  # Configuração Vite
```

---

## 📊 Estatísticas

| Categoria | Quantidade |
|-----------|------------|
| Domains | 7 (Admin, Catalog, Content, Customer, Marketing, Sales, Shared) |
| Migrations | 86 |
| Seeders | 16 |
| Livewire Components | 66 |
| Views (Blade) | 175 |
| Config Files | 11 |

---

## 🏗️ Arquitetura

O projeto segue uma arquitetura **Domain-Driven Design (DDD)** com:

- **Domains**: Módulos isolados por contexto de negócio
- **Actions**: Classes de ação única (Single Responsibility)
- **Services**: Lógica de negócio compartilhada
- **Livewire**: Componentes reativos para UI dinâmica
- **DTOs**: Objetos de transferência de dados tipados
