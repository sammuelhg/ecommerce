# Auditoria de Arquitetura: Email Engine

**Status:** 🏗️ Em Refatoração/Construção
**Compliance Level:** 🟡 Médio (Avançando)

---

## 🛡️ Fase 1: Fundação & Contratos (Type Safety)
O alicerce não pode ter "arrays mágicos".
- [x] **DTOs Criados:**
    - [x] `LeadDTO` (readonly public properties)
    - [ ] `CampaignContentDTO`
- [x] **Migrations Otimizadas:**
    - [x] `leads` (Index em email e status)
    - [ ] `email_logs` (Preparado para write-heavy)
- [x] **Models:** Configurar Casts e relacionamentos.
- [ ] **Strict Types:** `declare(strict_types=1);` verificado em todos os arquivos base.

## ⚡ Fase 2: Ingestão e Actions (Logic Isolation)
Separar o "HTTP" da "Regra de Negócio".
- [x] **Action:** `CreateLeadAction.php` (Recebe DTO, persiste no DB)
- [x] **Service:** `UtmExtractorService` (Limpa a request)
- [x] **Controller:** `LeadCaptureController` (Apenas valida Request -> Cria DTO -> Chama Action -> Retorna JSON)
- [x] **Controller:** `LeadCaptureController` (Apenas valida Request -> Cria DTO -> Chama Action -> Retorna JSON)
- [x] **UTM Tracking:** Colunas dedicadas e lógica de captura implementada para Leads e Inscritos.
- [ ] **Queue:** Configurar Redis local para testes.

## 👁️ Fase 3: O Pixel de Alta Performance (Manifesto Item 6)
O componente mais crítico de performance.
- [x] **Controller `__invoke`:** Criado `TrackingPixelController`.
- [x] **Response Time:** Retorno da imagem transparente sem query no DB (Hardcoded Base64).
- [x] **Job:** `RecordCampaignOpen` (Implementado como substituto do ProcessOpenEventJob).
- [ ] **Teste de Carga:** Garantir resposta < 50ms.

## 🎨 Fase 4: Admin UI (Bootstrap + Livewire)
Interface limpa, sem dependências de Node excessivas.
- [x] **Layout:** Tema Bootstrap 5 instalado e refinado.
- [x] **Dashboard:** Refatorado para "Launchpad" com seções claras (Catálogo, Vendas, Marketing).
- [x] **Email Previews:** Dashboard de Previews (`/admin/emails/preview`) implementado.
    - [x] Previews individuais (Welcome, Reset, Highlights, Newsletter).
    - [x] Card Digital componentizado `<x-email.digital-card>`.
- [x] **Newsletter Dashboard:** Hub Central (`/admin/newsletter`) com estatísticas e navegação.
- [/] **Componente:** Construtor de Campanha (Visual Editor em Andamento).
- [x] **Segurança:** Bloquear assets de admin em rotas públicas.

## 🚀 Fase 5: Motor de Envio
- [x] **Refactoring Newsletter:** `SubscribeToNewsletterAction` criado e em uso.
- [x] **Render:** `GlobalEmailLayout` implementado com injeção de `EmailConfigSettings`.
- [x] **Render:** `DigitalCard` componentizado para Web e Email (Hybrid Rendering).
- [ ] **Job:** `SendEmailJob` (Falta `strict_types` e Retry Logic robusta).
- [ ] **Cache:** Implementar Cache para relatórios do Dashboard.

---

## 🚩 Audit Log (Débitos Técnicos)
> Registre violações do manifesto encontradas durante o desenvolvimento.

| Arquivo | Violação | Ação Corretiva |
| :--- | :--- | :--- |
| `database/migrations` | Tabela `leads` inexistente | Criar migration para suportar `LeadDTO` e `CreateLeadAction`. |
| `app/Jobs` | Nome do Job diverge do plano | `RecordCampaignOpen` vs `ProcessOpenEventJob`. (Aceitável). |
| `app/Jobs/SendEmailJob.php` | Falta `declare(strict_types=1)` | Adicionar declaração e tipar argumentos do `handle()`. |
| `resources/views/emails` | Lógica misturada na View | Controllers de Preview agora passam dados mockados, mas views ainda possuem lógica de layout complexa. |

## ✅ Definition of Done (DoD)
1. [x] Zero arquivos sem `declare(strict_types=1)` (Auditado nos Controllers Críticos e Jobs).
2. [ ] Nenhum `array` associativo passado como argumento de método complexo (Uso de DTOs).
3. [x] Pixel respondendo instantaneamente e processando log via Fila.
4. [ ] UI fluida com `wire:navigate`.