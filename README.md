# Sistema de Gestão Financeira Pessoal

Sistema completo de gestão financeira pessoal desenvolvido com **Laravel 12** e **Filament 4**, permitindo controle total de despesas fixas, variáveis e categorias personalizadas.

## Tecnologias Utilizadas

- **Laravel 12** - Framework PHP moderno
- **Filament 4** - Painel administrativo com interface moderna
- **SQLite** - Banco de dados leve e eficiente
- **PHP 8.3+** - Versão mais recente do PHP

## Funcionalidades

### 1. Gestão de Categorias
- Criar, editar, visualizar e excluir categorias
- Campos personalizáveis: nome, descrição, cor e ícone
- Relacionamento com despesas fixas e variáveis
- Isolamento por usuário (cada usuário gerencia apenas suas categorias)

### 2. Gestão de Despesas Fixas
- Cadastro completo de despesas fixas recorrentes
- Cálculo automático da data de término baseado nos meses de validade
- Campos:
  - Descrição da despesa
  - Categoria (com opção de criar nova categoria inline)
  - Valor em reais (R$)
  - Data de início
  - Quantidade de meses de validade
  - Status (ativa/inativa)
- Filtros avançados:
  - Por categoria
  - Por status (ativa/inativa)
  - Despesas vencendo em breve (próximos 30 dias)
- Indicadores visuais para despesas próximas do vencimento
- Formatação de moeda em BRL (R$)
- Visualização detalhada com Infolists

### 3. Gestão de Despesas Variáveis
- Cadastro de despesas não programadas
- Campos:
  - Descrição da despesa
  - Categoria (com opção de criar nova categoria inline)
  - Valor em reais (R$)
  - Data da despesa
  - Observações (opcional)
- Badge visual identificando como "Não Programada"
- Filtros por categoria e período
- Ordenação por data (mais recentes primeiro)
- Visualização detalhada com Infolists

### 4. Recursos de Segurança
- Autenticação completa via Filament
- Policies implementadas para todos os modelos
- Global Scopes para isolamento automático de dados por usuário
- Soft Deletes em todas as tabelas principais
- Validações robustas em todos os formulários

### 5. Experiência do Usuário
- Interface moderna e responsiva
- Formatação brasileira (datas em d/m/Y, moeda em R$)
- Badges coloridos para categorias (usando cores personalizadas)
- Ícones personalizáveis para categorias
- Filtros e busca em tempo real
- Ações em lote (bulk actions)
- Visualizações detalhadas com seções colapsáveis

## Estrutura do Projeto

### Models
- **Category** - Categorias de despesas
- **FixedExpense** - Despesas fixas recorrentes
- **VariableExpense** - Despesas variáveis (não programadas)

Todos os models incluem:
- Relationships (BelongsTo, HasMany)
- Global Scopes (filtro automático por user_id)
- Casts apropriados (decimal, date, boolean)
- Scopes úteis para consultas
- Soft Deletes

### Filament Resources
- **CategoryResource** - Gerenciamento de categorias
- **FixedExpenseResource** - Gerenciamento de despesas fixas
- **VariableExpenseResource** - Gerenciamento de despesas variáveis

Cada Resource possui:
- Form Schema (formulário de criação/edição)
- Table Schema (listagem com colunas, filtros e ações)
- Infolist Schema (visualização detalhada)
- Navegação organizada em grupo "Gestão Financeira"

### Observers
- **FixedExpenseObserver** - Calcula automaticamente a data de término das despesas fixas

### Policies
- **CategoryPolicy**
- **FixedExpensePolicy**
- **VariableExpensePolicy**

Todas as policies garantem que usuários só acessem seus próprios dados.

### Seeders
- **CategorySeeder** - 9 categorias padrão (Moradia, Alimentação, Transporte, Saúde, Educação, Lazer, Vestuário, Serviços, Outros)
- **FixedExpenseSeeder** - 6 exemplos de despesas fixas
- **VariableExpenseSeeder** - 8 exemplos de despesas variáveis

## Instalação e Configuração

### Pré-requisitos
- PHP 8.3 ou superior
- Composer
- SQLite (já incluído no PHP)

### Passo a Passo

1. **Clone o repositório** (ou já está no diretório do projeto)
   ```bash
   cd /Users/christianpossidonio/Herd/gfpersonal
   ```

2. **Instale as dependências**
   ```bash
   composer install
   ```

3. **Configure o ambiente**
   - O arquivo `.env` já está configurado para usar SQLite
   - O banco de dados SQLite já foi criado

4. **Execute as migrations e seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

   Isso irá:
   - Criar todas as tabelas necessárias
   - Criar um usuário de teste
   - Popular o banco com categorias e despesas de exemplo

5. **Inicie o servidor**
   ```bash
   php artisan serve
   ```

   Ou se estiver usando Laravel Herd, acesse:
   ```
   http://gfpersonal.test/admin
   ```

6. **Acesse o painel administrativo**
   - URL: `http://localhost:8000/admin` (ou http://gfpersonal.test/admin)
   - Email: `test@example.com`
   - Senha: `password`

## Estrutura de Navegação

Após fazer login, você verá o menu organizado da seguinte forma:

**Gestão Financeira**
1. Categorias
2. Despesas Fixas
3. Despesas Variáveis

## Dados de Exemplo

O sistema vem com dados de exemplo pré-carregados:

### Categorias
- Moradia (azul) 🏠
- Alimentação (verde) 🛒
- Transporte (laranja) 🚚
- Saúde (vermelho) ❤️
- Educação (roxo) 🎓
- Lazer (rosa) ✨
- Vestuário (ciano) 🛍️
- Serviços (cinza) 📡
- Outros (cinza escuro) ⋯

### Despesas Fixas
- Aluguel (R$ 1.500,00)
- Condomínio (R$ 350,00)
- Plano de Saúde (R$ 450,00)
- Internet (R$ 99,90)
- Netflix (R$ 55,90)
- Academia (R$ 120,00) - Inativa

### Despesas Variáveis
- Supermercado Extra (R$ 350,50)
- Restaurante Italiano (R$ 180,00)
- Uber (R$ 35,50)
- Farmácia (R$ 87,90)
- Cinema (R$ 90,00)
- Livro Técnico (R$ 75,00)
- Combustível (R$ 250,00)
- Roupas (R$ 320,00)

## Recursos Avançados

### Cálculo Automático de Data de Término
As despesas fixas calculam automaticamente a data de término com base na data de início e quantidade de meses de validade. Isso é feito através do **FixedExpenseObserver** que escuta o evento `saving`.

### Indicador de Vencimento Próximo
Despesas fixas que vencem nos próximos 30 dias são destacadas visualmente com:
- Cor de aviso (warning)
- Ícone de alerta

### Filtros Inteligentes
- **Despesas Fixas**: Filtro "Vencendo em Breve" mostra apenas despesas que expiram nos próximos 30 dias
- **Por Categoria**: Todos os recursos permitem filtrar por categoria
- **Por Status**: Despesas fixas podem ser filtradas por ativa/inativa

### Multi-Tenancy por Usuário
Todos os dados são automaticamente filtrados pelo usuário logado através de Global Scopes. Isso garante total isolamento de dados entre usuários.

## Comandos Úteis

```bash
# Resetar banco de dados e recarregar dados de exemplo
php artisan migrate:fresh --seed

# Criar novo usuário (via tinker)
php artisan tinker
> User::factory()->create(['email' => 'seu@email.com', 'name' => 'Seu Nome'])

# Limpar cache
php artisan optimize:clear
```

## Customização

### Adicionar Novas Categorias
1. Acesse o painel admin
2. Vá em "Gestão Financeira" > "Categorias"
3. Clique em "Novo"
4. Preencha os campos e salve

### Modificar Cores e Ícones Padrão
Edite o arquivo `database/seeders/CategorySeeder.php` e altere os arrays de categorias.

### Ajustar Período de Alerta de Vencimento
No arquivo `app/Models/FixedExpense.php`, método `isExpiringSoon()`, altere o valor padrão de `30` dias para o período desejado.

## Próximos Passos (Melhorias Futuras)

- [ ] Dashboard com widgets de estatísticas
- [ ] Gráficos de despesas por categoria (Donut Chart)
- [ ] Widget de despesas próximas do vencimento
- [ ] Comparativo mensal (Line Chart)
- [ ] Exportação de relatórios em PDF/Excel
- [ ] Notificações de despesas vencendo
- [ ] Controle de receitas
- [ ] Planejamento de orçamento
- [ ] Metas financeiras

## Suporte e Documentação

- [Laravel 12 Documentation](https://laravel.com/docs)
- [Filament 4 Documentation](https://filamentphp.com/docs)
- [Laravel Brasil Community](https://github.com/laravelbrasil)

## Licença

Este projeto é open-source e está disponível sob a licença MIT.

---

**Desenvolvido com ❤️ usando Laravel 12 + Filament 4**
