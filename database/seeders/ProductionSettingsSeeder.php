<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\StoreSetting;

class ProductionSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate
        StoreSetting::truncate();

        // Data
        $data = [
            [
                'id' => 1,
                'key' => 'store_address',
                'value' => 'Rua das Academias
Belo Horizonte',
                'type' => 'text',
                'created_at' => '2025-12-02 12:59:07',
                'updated_at' => '2025-12-03 19:57:45',
            ],
            [
                'id' => 2,
                'key' => 'store_cnpj',
                'value' => '125489547562',
                'type' => 'text',
                'created_at' => '2025-12-02 12:59:07',
                'updated_at' => '2025-12-03 19:20:23',
            ],
            [
                'id' => 3,
                'key' => 'color_primary',
                'value' => '#00008a',
                'type' => 'color',
                'created_at' => '2025-12-02 12:59:07',
                'updated_at' => '2025-12-03 01:02:22',
            ],
            [
                'id' => 4,
                'key' => 'color_secondary',
                'value' => '#6c757d',
                'type' => 'color',
                'created_at' => '2025-12-02 12:59:07',
                'updated_at' => '2025-12-02 12:59:07',
            ],
            [
                'id' => 5,
                'key' => 'color_accent',
                'value' => '#ffc107',
                'type' => 'color',
                'created_at' => '2025-12-02 12:59:07',
                'updated_at' => '2025-12-02 12:59:07',
            ],
            [
                'id' => 6,
                'key' => 'color_background',
                'value' => '#ffffff',
                'type' => 'color',
                'created_at' => '2025-12-02 12:59:07',
                'updated_at' => '2025-12-02 13:00:13',
            ],
            [
                'id' => 7,
                'key' => 'store_phone',
                'value' => '31994161000',
                'type' => 'text',
                'created_at' => '2025-12-03 19:57:45',
                'updated_at' => '2025-12-03 19:57:45',
            ],
            [
                'id' => 8,
                'key' => 'google_maps_embed_url',
                'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d607.2810245771751!2d-43.88735253507937!3d-19.842866561251554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa685930a8dac6d%3A0x85f0337143c85000!2sMy%20Mall%20Parque%20Real!5e1!3m2!1spt-BR!2sbr!4v1764791831815!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'type' => 'text',
                'created_at' => '2025-12-03 19:57:45',
                'updated_at' => '2025-12-03 19:57:45',
            ],
            [
                'id' => 9,
                'key' => 'color_category_bar',
                'value' => '#f5f7ff',
                'type' => 'color',
                'created_at' => '2025-12-03 19:57:45',
                'updated_at' => '2025-12-03 22:46:46',
            ],
            [
                'id' => 10,
                'key' => 'ai_image_prompt_template',
                'value' => 'Professional e-commerce product photography of {product_name}, {category} category product, {type} type, {model} model, {size} size, {variant}, {material} style. Studio lighting, clean white background, product centered, front view, label visible and readable, high resolution, professional packshot, 8k quality, photorealistic',
                'type' => 'text',
                'created_at' => '2025-12-03 21:41:54',
                'updated_at' => '2025-12-13 00:12:47',
            ],
            [
                'id' => 11,
                'key' => 'modal_about',
                'value' => 'A Losfit é uma marca criada para quem busca estilo, conforto e autenticidade. Desde o início, nossa missão sempre foi oferecer produtos que combinam qualidade, design moderno e preço justo, conectando pessoas a uma experiência de compra simples, rápida e confiável.

Trabalhamos com curadoria de produtos selecionados, fornecedores certificados e processos rigorosos de qualidade, garantindo que cada item entregue reflita nossos valores: confiança, transparência e compromisso com o cliente.

Hoje, atuamos com foco em inovação, atendimento humanizado e evolução constante. Cada coleção, cada detalhe e cada melhoria no nosso site nasce com um propósito: proporcionar a você uma experiência inesquecível de compra online.',
                'type' => 'text',
                'created_at' => '2025-12-03 21:41:54',
                'updated_at' => '2025-12-03 21:41:54',
            ],
            [
                'id' => 12,
                'key' => 'modal_careers',
                'value' => 'A Losfit está em constante crescimento, e buscamos pessoas apaixonadas por tecnologia, varejo e experiência do cliente. Valorizamos profissionais criativos, responsáveis e comprometidos com o que fazem.

Se você deseja fazer parte de uma equipe dinâmica, colaborativa e focada em resultados, envie seu currículo para:

📧 E-mail para vagas: vagas@losfit.com.br

Assunto: “Trabalhe Conosco – Nome da Vaga”

Áreas que frequentemente abrimos vagas:

Atendimento ao Cliente

Logística & Expedição

Criação & Design

Social Media

Gestão de Produtos

TI & Desenvolvimento

Se não encontrar uma vaga aberta no momento, envie seu currículo mesmo assim! Mantemos um banco de talentos sempre atualizado.',
                'type' => 'text',
                'created_at' => '2025-12-03 21:41:54',
                'updated_at' => '2025-12-03 21:41:54',
            ],
            [
                'id' => 13,
                'key' => 'modal_contact',
                'value' => 'Estamos aqui para ajudar você!
Se tiver dúvidas, sugestões ou precisar de suporte, fale com nossa equipe pelos canais oficiais abaixo:

📱 WhatsApp: (31) 99416-1000
📧 E-mail: contato@losfit.com.br

📍 Horário de atendimento: Segunda a Sexta, das 09h às 18h

Redes Sociais
Siga-nos para acompanhar lançamentos, promoções e novidades exclusivas:

📸 Instagram: @losfit1000',
                'type' => 'text',
                'created_at' => '2025-12-03 21:41:54',
                'updated_at' => '2025-12-03 21:41:54',
            ],
            [
                'id' => 14,
                'key' => 'modal_returns',
                'value' => 'A Losfit trabalha para garantir sua total satisfação. Se o produto recebido não atendeu às suas expectativas, não se preocupe — nossa política de trocas e devoluções é simples e transparente.

✔ Trocas por tamanho ou modelo:
Prazo de até 7 dias corridos após o recebimento.

✔ Devolução por arrependimento:
Prazo de até 7 dias corridos, conforme o Código de Defesa do Consumidor.

✔ Produto com defeito:
Prazo de até 30 dias para solicitar análise e substituição.

Requisitos obrigatórios:

Produto sem sinais de uso

Etiquetas e embalagem original

Nota fiscal ou comprovante de compra

Para solicitar, envie e-mail para:
📧 trocas@losfit.com.br

Assunto: “Troca/Devolução – Nº do Pedido”

Nossa equipe retornará com todas as instruções e o código de postagem grátis (quando aplicável).',
                'type' => 'text',
                'created_at' => '2025-12-03 21:41:54',
                'updated_at' => '2025-12-03 21:41:54',
            ],
            [
                'id' => 15,
                'key' => 'modal_faq',
                'value' => '1️⃣ O produto é original?
Sim! Trabalhamos com fornecedores homologados e produtos 100% originais.

2️⃣ Quanto tempo demora para chegar?
O prazo varia conforme a região, mas normalmente entre 7 e 15 dias úteis. O prazo exato aparece no checkout.

3️⃣ Como acompanho meu pedido?
Assim que o pedido for enviado, você recebe um código de rastreio no e-mail ou WhatsApp.

4️⃣ Posso trocar se não servir?
Claro! Aceitamos trocas por tamanho, modelo ou cor dentro do prazo estabelecido.

5️⃣ É seguro comprar na Losfit?
Sim. Nosso site possui certificado SSL, gateways de pagamento seguros e proteção de dados.

6️⃣ Quais formas de pagamento vocês aceitam?
Pix, cartão de crédito (parcelamento disponível) e boleto bancário.

7️⃣ Como falar com o suporte?
Via e-mail (suporte@losfit.com.br
) ou WhatsApp. Nosso time responde rápido!',
                'type' => 'text',
                'created_at' => '2025-12-03 21:41:54',
                'updated_at' => '2025-12-03 21:41:54',
            ],
            [
                'id' => 16,
                'key' => 'email_sender_name',
                'value' => 'Jacqueline Maria Bergsten',
                'type' => 'text',
                'created_at' => '2025-12-05 15:42:14',
                'updated_at' => '2025-12-05 15:42:14',
            ],
            [
                'id' => 17,
                'key' => 'email_sender_role',
                'value' => 'CEO',
                'type' => 'text',
                'created_at' => '2025-12-05 15:42:14',
                'updated_at' => '2025-12-05 15:42:14',
            ],
            [
                'id' => 18,
                'key' => 'email_instagram',
                'value' => 'losfit1000',
                'type' => 'text',
                'created_at' => '2025-12-05 15:42:14',
                'updated_at' => '2025-12-05 15:42:14',
            ],
            [
                'id' => 19,
                'key' => 'email_website',
                'value' => 'www.losfit.com.br',
                'type' => 'text',
                'created_at' => '2025-12-05 15:42:15',
                'updated_at' => '2025-12-05 15:42:15',
            ],
            [
                'id' => 20,
                'key' => 'email_slogan',
                'value' => 'A Elegância veste o estilo!',
                'type' => 'text',
                'created_at' => '2025-12-05 15:42:15',
                'updated_at' => '2025-12-05 15:42:15',
            ],
            [
                'id' => 21,
                'key' => 'email_card_id',
                'value' => '1',
                'type' => 'text',
                'created_at' => '2025-12-05 17:56:43',
                'updated_at' => '2025-12-05 22:07:40',
            ],
            [
                'id' => 22,
                'key' => 'links_page_title',
                'value' => 'LosFit 1000',
                'type' => 'text',
                'created_at' => '2025-12-05 21:14:28',
                'updated_at' => '2025-12-05 21:14:28',
            ],
            [
                'id' => 23,
                'key' => 'links_page_subtitle',
                'value' => 'A Elegância veste o Estilo',
                'type' => 'text',
                'created_at' => '2025-12-05 21:14:28',
                'updated_at' => '2025-12-07 22:18:28',
            ],
            [
                'id' => 24,
                'key' => 'store_logo',
                'value' => 'http://localhost:8000/storage/uploads/settings/logo.png',
                'type' => 'image',
                'created_at' => '2025-12-07 21:33:54',
                'updated_at' => '2025-12-10 09:03:00',
            ],
            [
                'id' => 25,
                'key' => 'footer_logo',
                'value' => 'http://localhost:8000/storage/uploads/settings/sol.png',
                'type' => 'image',
                'created_at' => '2025-12-07 22:04:13',
                'updated_at' => '2025-12-07 22:04:13',
            ],
            [
                'id' => 26,
                'key' => 'email_logo',
                'value' => 'http://localhost:8000/storage/uploads/settings/logo-email.png',
                'type' => 'image',
                'created_at' => '2025-12-08 22:39:00',
                'updated_at' => '2025-12-13 01:20:04',
            ],
            [
                'id' => 27,
                'key' => 'profile_logo',
                'value' => 'http://localhost:8000/storage/uploads/settings/logo-redonda-trans.png',
                'type' => 'image',
                'created_at' => '2025-12-08 22:39:00',
                'updated_at' => '2025-12-08 22:39:00',
            ],
            [
                'id' => 28,
                'key' => 'favicon',
                'value' => 'http://localhost:8000/storage/uploads/settings/favicon.ico',
                'type' => 'image',
                'created_at' => '2025-12-08 22:41:27',
                'updated_at' => '2025-12-08 22:41:27',
            ],
            [
                'id' => 29,
                'key' => 'security_certificates',
                'value' => '["http:\/\/localhost:8000\/storage\/uploads\/settings\/certificates\/IUyuictBW8Y4zlNroNNPvNrCP7TY77pwJoe577ez.png","http:\/\/localhost:8000\/storage\/uploads\/settings\/certificates\/IUyuictBW8Y4zlNroNNPvNrCP7TY77pwJoe577ez.png","http:\/\/localhost:8000\/storage\/uploads\/settings\/certificates\/ZZzeOLIz0kxKbHdhljPBjRqvOJSMz33lbT0BqYVX.png","http:\/\/localhost:8000\/storage\/uploads\/settings\/certificates\/ZZzeOLIz0kxKbHdhljPBjRqvOJSMz33lbT0BqYVX.png"]',
                'type' => 'json',
                'created_at' => '2025-12-09 02:29:31',
                'updated_at' => '2025-12-09 02:30:40',
            ],
            [
                'id' => 30,
                'key' => 'contact_auto_response_campaign_id',
                'value' => '5',
                'type' => 'text',
                'created_at' => '2025-12-11 00:09:50',
                'updated_at' => '2025-12-11 00:09:50',
            ],
            [
                'id' => 31,
                'key' => 'ai_seo_prompt_template',
                'value' => 'Atue como um Especialista em SEO para E-commerce. Escreva uma meta-descrição persuasiva de no máximo 160 caracteres para o produto abaixo.

Regras:
1. Comece com um verbo de ação.
2. Inclua: {product_name} e {category}.
3. Call to Action no final.

Dados do Produto:
Produto: {product_name}
Categoria: {category}
Modelo/Tipo: {model} / {type}
Variante: {variant}',
                'type' => 'text',
                'created_at' => '2025-12-12 16:12:29',
                'updated_at' => '2025-12-13 00:21:24',
            ],
            [
                'id' => 32,
                'key' => 'ai_description_prompt_template',
                'value' => 'Atue como um Copywriter Sênior de E-commerce. Escreva uma descrição de produto completa e envolvente para a página de vendas em formato HTML.

Estrutura Obrigatória (Use tags HTML):
1. Título: Use <h1> para um título criativo com o nome do produto.
2. Gancho Emocional: Use <p> para 2-3 frases focadas no problema/solução.
3. Benefícios: Use <ul> e <li>. Use <strong> para destacar palavras-chave.
4. Experiência: Use <p> para descrever material ({material}) e variante ({variant}).
5. Regras Finais: NÃO inclua Chamada para Ação (CTA). NÃO use Markdown (** ou ##). Apenas HTML puro.

Dados do Produto:
Nome: {product_name}
Categoria: {category}
Material/Ingredientes: {material}
Detalhes da Variante: {variant}
Tamanho: {size}',
                'type' => 'text',
                'created_at' => '2025-12-12 16:12:29',
                'updated_at' => '2025-12-13 00:31:49',
            ],
            [
                'id' => 33,
                'key' => 'gemini_api_key',
                'value' => 'AIzaSyDirUEcaFW31xX46QZ7J6Hx6ODJDMdHgek',
                'type' => 'text',
                'created_at' => '2025-12-12 16:37:54',
                'updated_at' => '2025-12-12 18:10:33',
            ],
            [
                'id' => 34,
                'key' => 'openai_api_key',
                'value' => null,
                'type' => 'text',
                'created_at' => '2025-12-12 16:37:54',
                'updated_at' => '2025-12-12 16:37:54',
            ],
            [
                'id' => 35,
                'key' => 'deepseek_api_key',
                'value' => null,
                'type' => 'text',
                'created_at' => '2025-12-12 16:37:54',
                'updated_at' => '2025-12-12 16:37:54',
            ],
            [
                'id' => 36,
                'key' => 'ai_provider',
                'value' => 'gemini',
                'type' => 'text',
                'created_at' => '2025-12-12 16:37:54',
                'updated_at' => '2025-12-12 16:37:54',
            ],
        ];

        foreach ($data as $item) {
            StoreSetting::create($item);
        }

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
