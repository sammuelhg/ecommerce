# 🌐 Mapeamento de URLs - losfit.com.br

> **Última atualização:** 2025-12-18
> **Domínio:** https://losfit.com.br

---

## 📍 Legenda de Status

| Ícone | Status | Descrição |
|-------|--------|-----------|
| 🟢 | Ativo | Funcionando corretamente |
| 🟡 | Pendente | Aguardando verificação |
| 🔴 | Erro | Com problemas |
| 🔵 | Novo | Recém implementado |
| ⚪ | Desativado | Temporariamente desativado |
| ⚫ | 404 | Página não encontrada |

---

## 🏠 Rotas Públicas (Loja)

| Status | URL | Descrição | Controller/View |
|--------|-----|-----------|-----------------|
| 🟢 | `https://losfit.com.br/` | Redirect → /loja | `redirect()->route('shop.index')` |
| 🔴 | `https://losfit.com.br/loja` | Página principal da loja | `ShopController@newShopSimple` |
| 🔴 | `https://losfit.com.br/shop` | Loja com regras de grid | `ShopController@newShop` |
| 🔴 | `https://losfit.com.br/loja2` | Loja 2 colunas mobile | `ShopController@newShopB` |
| 🔴 | `https://losfit.com.br/loja/busca` | Busca de produtos | `ShopController@search` |
| 🟢 | `https://losfit.com.br/loja/busca/sugestoes` | Sugestões de busca (AJAX) | `ShopController@suggestions` |
| ⚫ | `https://losfit.com.br/loja/categoria/{slug}` | Categoria de produtos | `ShopController@category` |
| ⚫ | `https://losfit.com.br/loja/categoria/{parent}/{slug}` | Subcategoria | `ShopController@subcategory` |
| ⚫ | `https://losfit.com.br/loja/produto/{slug}` | Página do produto | `ShopController@show` |

---

## 🛒 Rotas do Carrinho

| Status | URL | Método | Descrição |
|--------|-----|--------|-----------|
| 🔴 | `https://losfit.com.br/loja/carrinho/sync` | POST | Sincronizar carrinho |
| 🔴 | `https://losfit.com.br/loja/checkout` | GET | Página de checkout |

---

## 🔐 Autenticação

| Status | URL | Descrição |
|--------|-----|-----------|
| 🔴 | `https://losfit.com.br/login` | Página de login |
| 🔴 | `https://losfit.com.br/register` | Página de registro |
| 🔴 | `https://losfit.com.br/logout` | Logout (GET) |
| 🔴 | `https://losfit.com.br/password/reset` | Recuperação de senha |
| 🔴 | `https://losfit.com.br/auth/{provider}/redirect` | Login social (Google) |
| 🔴 | `https://losfit.com.br/auth/{provider}/callback` | Callback social |

---

## 👤 Área do Cliente (Autenticado)

| Status | URL | Descrição |
|--------|-----|-----------|
| 🔴 | `https://losfit.com.br/conta/perfil` | Editar perfil |
| 🔴 | `https://losfit.com.br/meus-pedidos` | Meus pedidos |
| 🔴 | `https://losfit.com.br/enderecos` | Endereços salvos |
| 🔴 | `https://losfit.com.br/pagamentos` | Métodos de pagamento |
| 🔴 | `https://losfit.com.br/notificacoes` | Notificações |
| 🔴 | `https://losfit.com.br/cupons` | Cupons disponíveis |
| 🔴 | `https://losfit.com.br/indique-amigos` | Programa de indicação |
| 🔴 | `https://losfit.com.br/presentes` | Lista de presentes |
| 🔴 | `https://losfit.com.br/clube` | Clube de vantagens |

---

## 📧 Campanhas/Newsletter

| Status | URL | Descrição |
|--------|-----|-----------|
| 🔴 | `https://losfit.com.br/campaign/v/{id}` | Visualizar campanha |
| 🔴 | `https://losfit.com.br/campaign/email/{email}` | Preview de email |
| 🔴 | `https://losfit.com.br/campaign/unsubscribe/{id}` | Descadastrar (signed) |
| 🔴 | `https://losfit.com.br/campaign/resubscribe/{id}` | Recadastrar |

---

## 🔗 Links e Páginas Estáticas

| Status | URL | Descrição |
|--------|-----|-----------|
| 🔴 | `https://losfit.com.br/links` | Linktree/Bio links |
| 🔴 | `https://losfit.com.br/card` | Cartão digital |
| 🔴 | `https://losfit.com.br/minha-historia` | Landing: História |
| 🔴 | `https://losfit.com.br/pages/{slug}` | Páginas CMS |

---

## 📊 Tracking e API

| Status | URL | Método | Descrição |
|--------|-----|--------|-----------|
| 🔴 | `https://losfit.com.br/pixel/{id}` | GET | Pixel de rastreamento |
| 🔴 | `https://losfit.com.br/t/{campaign}/{lead}/pixel.gif` | GET | Tracking de abertura |
| 🟢 | `https://losfit.com.br/api/stories` | GET | API de stories |
| 🔴 | `https://losfit.com.br/api/leads` | POST | Captura de leads |
| 🔴 | `https://losfit.com.br/api/user` | GET | Dados do usuário (auth) |
| 🔴 | `https://losfit.com.br/api/generate-content` | POST | Geração AI |
| 🔴 | `https://losfit.com.br/contact` | POST | Formulário de contato |

---

## 🔧 Admin Panel (`/admin/*`)

### Dashboard e Geral

| Status | URL | Descrição |
|--------|-----|-----------|
| 🔴 | `https://losfit.com.br/admin` | Dashboard principal |
| 🔴 | `https://losfit.com.br/admin/settings/{tab?}` | Configurações |
| 🔴 | `https://losfit.com.br/admin/integrations` | Integrações |

### Catálogo

| Status | URL | Descrição |
|--------|-----|-----------|
| 🔴 | `https://losfit.com.br/admin/products` | Lista de produtos |
| 🟢 | `https://losfit.com.br/admin/products/create` | Novo produto |
| 🟢 | `https://losfit.com.br/admin/products/{id}` | Editar produto |
| 🟢 | `https://losfit.com.br/admin/categories` | Categorias |
| 🟢 | `https://losfit.com.br/admin/types` | Tipos |
| 🟢 | `https://losfit.com.br/admin/materials` | Materiais |
| 🟢 | `https://losfit.com.br/admin/models` | Modelos |
| 🟢 | `https://losfit.com.br/admin/colors` | Cores |
| 🟢 | `https://losfit.com.br/admin/sizes` | Tamanhos |
| 🟢 | `https://losfit.com.br/admin/flavors` | Sabores |

### Vendas

| Status | URL | Descrição |
|--------|-----|-----------|
| 🟢 | `https://losfit.com.br/admin/orders` | Pedidos |
| 🟢 | `https://losfit.com.br/admin/users` | Usuários |

### Marketing

| Status | URL | Descrição |
|--------|-----|-----------|
| 🟢 | `https://losfit.com.br/admin/marketing` | Dashboard Marketing |
| 🔴 | `https://losfit.com.br/admin/marketing/report/{id}` | Relatório campanha |
| 🟢 | `https://losfit.com.br/admin/marketing/contacts` | Contatos |
| 🟢 | `https://losfit.com.br/admin/marketing/search` | Busca highlights |
| 🟢 | `https://losfit.com.br/admin/campaigns` | Lista campanhas |
| 🟢 | `https://losfit.com.br/admin/campaigns/builder/{id?}` | Builder de campanha |
| 🟢 | `https://losfit.com.br/admin/campaigns/identities` | Identidades/SignCards |
| 🟢 | `https://losfit.com.br/admin/grid` | Gerenciar grid |
| 🟢 | `https://losfit.com.br/admin/sign-cards` | Sign Cards |
| 🟢 | `https://losfit.com.br/admin/links` | Links Bio |

### Leads e Funil

| Status | URL | Descrição |
|--------|-----|-----------|
| 🟢 | `https://losfit.com.br/admin/leads` | Lista de leads |
| 🟢 | `https://losfit.com.br/admin/leads/kanban` | Kanban leads |
| 🟢 | `https://losfit.com.br/admin/funnel` | Funil inteligente |
| 🟢 | `https://losfit.com.br/admin/funnel/automations` | Automações |

### CRM

| Status | URL | Descrição |
|--------|-----|-----------|
| 🟢 | `https://losfit.com.br/admin/crm/audience` | Audiência unificada |
| 🟢 | `https://losfit.com.br/admin/crm/traffic/organic` | Tráfego orgânico |
| 🟢 | `https://losfit.com.br/admin/crm/traffic/paid` | Tráfego pago |
| 🟢 | `https://losfit.com.br/admin/crm/expenses/general` | Despesas gerais |
| 🟢 | `https://losfit.com.br/admin/crm/reports` | Relatórios financeiros |
| 🟢 | `https://losfit.com.br/admin/crm/forms/builder` | Builder de forms |

### CMS

| Status | URL | Descrição |
|--------|-----|-----------|
| 🟢 | `https://losfit.com.br/admin/cms/pages` | Páginas CMS |
| 🟢 | `https://losfit.com.br/admin/cms/pages/builder/{id?}` | Page Builder |
| 🟢 | `https://losfit.com.br/admin/cms/components` | Componentes |
| 🟢 | `https://losfit.com.br/admin/cms/components/builder/{id?}` | Component Builder |

### Stories

| Status | URL | Descrição |
|--------|-----|-----------|
| 🟢 | `https://losfit.com.br/admin/stories` | Lista stories |
| 🔴 | `https://losfit.com.br/admin/stories/{id}/toggle` | Toggle status |

### Emails

| Status | URL | Descrição |
|--------|-----|-----------|
| 🔴 | `https://losfit.com.br/admin/emails/preview` | Dashboard previews |
| 🔴 | `https://losfit.com.br/admin/emails/preview/{type}` | Preview por tipo |

---

## 🛠️ Rotas de Debug (Apenas Local)

| Status | URL | Descrição |
|--------|-----|-----------|
| ⚪ | `/test-email` | Teste de email |
| ⚪ | `/debug-logs` | Ver logs (REMOVER EM PROD) |
| ⚪ | `/force-seed` | Executar seeder (REMOVER EM PROD) |

---

## 📁 Arquivos Estáticos

| Status | URL | Arquivo |
|--------|-----|---------|
| 🔴 | `https://losfit.com.br/robots.txt` | SEO robots |
| 🔴 | `https://losfit.com.br/site.webmanifest` | PWA manifest |
| 🔴 | `https://losfit.com.br/favicon.ico` | Favicon |
| 🟢 | `https://losfit.com.br/logo.png` | Logo principal |
| 🟢 | `https://losfit.com.br/logo.svg` | Logo SVG |

---

## 📈 Resumo

| Categoria | Quantidade |
|-----------|------------|
| Rotas Públicas | 15 |
| Rotas Autenticadas | 11 |
| Rotas Admin | 45+ |
| Rotas API | 5 |
| Total Aproximado | **76 rotas** |
