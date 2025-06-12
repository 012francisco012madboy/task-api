## TASK API - Laravel

### Configurar o projeto

Clonar o projeto via - `git clone`
Instalar as dependências - `composer install`

Gerar un novo arquivo - `.env`
Criar uma chave via - `php artisan key:generate`

Rodar as migrations via - `php artisan migrate`
Rodar o servidor via - `php artisan serve`

### Testar API
Testar o projeto via insónia (Dexei um arquivo importado do insónia)

### Endpoints
Listar os estados que serão usados no "SELECT"
- GET /apiview-state

Adicionar uma nova tarefa
- POST /api/add-task

Listar todas tarefas de um usuário
- GET /api/show-task/{user_id}

Listar cada tarefas de um usuário
- GET /api/show-task/{user_id}/{task_id}

Filtrar tarefas por estado
- GET /api/filter-task/{user_id}/{state_id}

Atualizar o estado de uma tarefa
- PATCH /api/update-state-task/{user_id}/{state_id}

Eliminar uma tarefa
- DELETE /api/delete-task/{user_id}/{task_id}
