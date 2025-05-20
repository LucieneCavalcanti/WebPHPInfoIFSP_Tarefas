# WebPHPInfoIFSP_Tarefas
Projeto de gerenciamento de tarefas com partes geradas pelo V0 Vercel

Texto explicativo gerado:

# Atribuição de Tarefas aos Usuários

Implementei um sistema completo para que os usuários possam selecionar, visualizar e gerenciar suas próprias tarefas. Vamos ver o que foi criado:

## 1. Nova Tabela de Associação

Primeiro, criei uma nova tabela `tarefa_usuario` para associar usuários e tarefas:

## 2. Novas Páginas Criadas

### Para Usuários Comuns:

1. **tarefas_disponiveis.php** - Lista todas as tarefas disponíveis para seleção
2. **visualizar_tarefa.php** - Visualiza detalhes de uma tarefa disponível
3. **selecionar_tarefa.php** - Permite ao usuário selecionar uma tarefa
4. **minhas_tarefas.php** - Lista todas as tarefas selecionadas pelo usuário
5. **visualizar_minha_tarefa.php** - Visualiza detalhes de uma tarefa selecionada
6. **editar_minha_tarefa.php** - Permite editar observações de uma tarefa
7. **concluir_minha_tarefa.php** - Marca uma tarefa como concluída
8. **cancelar_tarefa.php** - Cancela uma tarefa selecionada


### Atualização da Página Inicial:

Também atualizei a página `indexlogado.php` para incluir links para as novas funcionalidades, com cards diferentes para usuários comuns e administradores.

## 3. Funcionalidades Implementadas

### Para Usuários Comuns:

- **Visualizar tarefas disponíveis** - Usuários podem ver todas as tarefas que ainda não foram selecionadas
- **Selecionar tarefas** - Usuários podem escolher tarefas para realizar
- **Adicionar observações** - Ao selecionar ou editar uma tarefa, usuários podem adicionar observações
- **Gerenciar suas tarefas** - Visualizar, editar, concluir ou cancelar tarefas selecionadas
- **Filtrar tarefas** - Filtrar por descrição, categoria ou status


### Para Administradores:

- Todas as funcionalidades dos usuários comuns
- Acesso ao gerenciamento completo de usuários, categorias e tarefas


## 4. Recursos Adicionais

- **Sistema de status** - Tarefas podem estar "Em andamento", "Concluídas" ou "Canceladas"
- **Feedback visual** - Cores diferentes para cada status (amarelo, verde, vermelho)
- **Paginação** - Todas as listagens têm paginação
- **Busca e filtros** - Busca por texto e filtro por status
- **Confirmações** - Confirmações antes de concluir ou cancelar tarefas
- **Validações de segurança** - Verificações para garantir que usuários só acessem suas próprias tarefas


## 5. Fluxo de Trabalho

1. Usuário faz login no sistema
2. Na página inicial, escolhe "Tarefas Disponíveis"
3. Visualiza a lista de tarefas disponíveis e seleciona uma
4. Adiciona observações (opcional) e confirma a seleção
5. A tarefa aparece em "Minhas Tarefas" com status "Em andamento"
6. O usuário pode editar observações, concluir ou cancelar a tarefa
7. Tarefas concluídas ou canceladas permanecem visíveis, mas não podem ser editadas


Este sistema permite que múltiplos usuários trabalhem em diferentes tarefas, mantendo um registro claro de quem está fazendo o quê e o status de cada tarefa.
