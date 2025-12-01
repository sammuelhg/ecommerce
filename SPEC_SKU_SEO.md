# 📝 Especificação para SKU e Títulos de Produtos

## 1. 🛠️ Definição e Geração do SKU (Stock Keeping Unit)

**Objetivo:** Criar um código único, consistente e rastreável para gestão de estoque.

### Estrutura do SKU:
$$\text{<CÓDIGO\_CATEG> - <CÓDIGO\_TIPO> - <CÓDIGO\_MOD> - <CÓDIGO\_COR> - <CÓDIGO\_TAM>}$$

| Atributo | Código de Formato | Regra de Padronização | Exemplo |
| :---: | :---: | :---: | :---: |
| **Categoria** | 3 letras MAIÚSCULAS | Utilizar código *lookup* (ex: ROU, CAL). | **CAL** |
| **Tipo** | 3 letras MAIÚSCULAS | Utilizar código *lookup* (ex: TEN, CAM). | **TEN** |
| **Modelo** | 3 a 5 caracteres (alfanuméricos) | Código interno do design ou lote. | **2005A** |
| **Cor** | 3 letras MAIÚSCULAS | Utilizar código *lookup* (ex: PRT, AZM). | **PRT** |
| **Tamanho** | 2 a 3 caracteres | Padronizar numérico (40) ou alfabético (P, GG). | **40** |

**Exemplo Final do SKU:** `CAL-TEN-2005A-PRT-40`

---

## 2. ✍️ Regras para Títulos de Produto (SEO)

**Objetivo:** Criar títulos descritivos e amigáveis, priorizando as palavras-chave de maior volume de busca.

### Fórmula do Título:
$$\text{<TIPO> + <MODELO/NOME ESPECÍFICO> + <MATERIAL> + <COR> + <TAMANHO>}$$

**Regras:**
1.  **Tipo e Modelo:** Início do título.
2.  **Material:** Adicionar de forma fluida (ex: "em Couro").
3.  **Variação:** Cor e Tamanho no final.
4.  **Marca:** Antes do Tipo se for relevante.

**Exemplo:** *Tênis Glide Pro 5 em Mesh Respirável – Preto, Tamanho 42*

---

## 3. 💡 Modelagem e Busca (DB)

### A. Modelagem
1.  **Tabela de Variações:** `product_skus` (ou `product_variations`) com SKU como chave única.
2.  **Indexação:** `sku`, `modelo`, `titulo`.
3.  **Lookup:** Tabelas ou Enums para padronização (Categoria -> CAL).

### B. Busca
1.  **Principal:** `titulo` e `modelo`.
2.  **Interna/Filtro:** `sku`.
3.  **Filtros Facetados:** Colunas separadas para Categoria, Tipo, Cor, Tamanho.
