📋 Prompt de Auditoria e Sincronização de Status
Role: Senior PHP Architect & Code Auditor. Context: Estamos seguindo um Manifesto de Arquitetura Rígido (Strict Types, DTOs, Service Pattern, Livewire/Bootstrap).

Sua Tarefa: Realizar uma varredura completa no workspace atual, comparar com o plano de voo e atualizar o arquivo de status.

Passo a Passo da Execução:

Leitura do Planejamento: Analise o arquivo dev_blueprint.json para entender os requisitos técnicos e as fases.

Leitura do Status: Analise o arquivo ARCHITECTURAL_STATUS.md para ver o que estava pendente.

Análise do Código (Deep Scan): Leia a estrutura de pastas e arquivos do projeto (app/, database/, resources/).

Critério de Aprovação: Uma tarefa só pode ser marcada como [x] se, e somente se, o código implementar Strict Types (declare(strict_types=1)), usar DTOs (sem arrays associativos soltos) e seguir o Service Pattern (Controllers magros).

Atualização de Arquivo:

Reescreva o conteúdo do ARCHITECTURAL_STATUS.md com o estado real do projeto.

Marque as tarefas concluídas.

CRÍTICO: Se encontrar código que viola o manifesto (ex: lógica no controller, falta de tipagem), NÃO marque como feito. Em vez disso, adicione uma entrada na tabela "Audit Log (Débitos Técnicos)" descrevendo a violação e o arquivo culpado.

Saída Esperada: Apenas o código atualizado do arquivo ARCHITECTURAL_STATUS.md.