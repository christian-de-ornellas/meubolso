<x-filament-panels::page>
    <div x-data="{
        openSections: {},
        search: '',
        toggle(key) { this.openSections[key] = !this.openSections[key] },
        isOpen(key) { return this.openSections[key] === true },
        matches(title) {
            if (!this.search) return true;
            return title.toLowerCase().includes(this.search.toLowerCase());
        },
        groupHasMatch(keys, titles) {
            if (!this.search) return true;
            return titles.some(t => t.toLowerCase().includes(this.search.toLowerCase()));
        }
    }">

        {{-- Hero --}}
        <div style="position: relative; overflow: hidden; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.07); padding: 2rem 1.75rem;"
             class="bg-white dark:bg-gray-800">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #f59e0b, #d97706);"></div>
            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                <div style="width: 2.75rem; height: 2.75rem; border-radius: 0.75rem; background: rgba(245,158,11,0.12); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    @svg('heroicon-o-academic-cap', 'fi-icon', ['style' => 'width:1.5rem;height:1.5rem;color:#f59e0b'])
                </div>
                <div>
                    <h2 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.25rem;" class="text-gray-900 dark:text-white">Como usar o MeuBolso</h2>
                    <p style="font-size: 0.875rem; line-height: 1.5;" class="text-gray-500 dark:text-gray-400">
                        Guia completo com instruções de cada módulo. Expanda as seções para aprender a usar cada funcionalidade.
                    </p>
                </div>
            </div>

            {{-- Search --}}
            <div style="margin-top: 1.25rem; position: relative;">
                <div style="position: absolute; left: 0.875rem; top: 50%; transform: translateY(-50%); pointer-events: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 1.125rem; height: 1.125rem;" class="text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <input
                    type="text"
                    x-model="search"
                    placeholder="Buscar módulo..."
                    style="width: 100%; padding: 0.625rem 0.875rem 0.625rem 2.5rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1); font-size: 0.875rem; outline: none; background: rgba(255,255,255,0.03);"
                    class="text-gray-900 dark:text-white"
                />
            </div>
        </div>

        @php
            $groups = [
                [
                    'label' => 'Visão Geral',
                    'color' => '#f59e0b',
                    'colorBg' => 'rgba(245,158,11,0.10)',
                    'sections' => [
                        [
                            'key' => 'dashboard',
                            'icon' => 'heroicon-o-chart-bar',
                            'title' => 'Dashboard',
                            'desc' => 'Tela principal com visão geral das finanças',
                            'intro' => 'O Dashboard oferece uma visão completa das suas finanças através de <strong>4 abas</strong>:',
                            'items' => [
                                ['label' => 'Receitas', 'color' => '#16a34a', 'text' => 'Resumo das receitas do mês, gráfico por categoria, comparativo mensal e últimas receitas variáveis.'],
                                ['label' => 'Despesas', 'color' => '#dc2626', 'text' => 'Resumo das despesas, gráfico por categoria, despesas fixas próximas, variáveis recentes e progresso do orçamento.'],
                                ['label' => 'Comparativo', 'color' => '#d97706', 'text' => 'Balanço geral, gráfico de barras mensal, tendência de saldo, tabela resumo e progresso das metas.'],
                                ['label' => 'Projeção', 'color' => '#7c3aed', 'text' => 'Fluxo de caixa futuro, saldo das contas, uso dos cartões de crédito e custo das assinaturas.'],
                            ],
                            'footer' => 'Use as abas para navegar entre as diferentes visões e acompanhar sua saúde financeira.',
                        ],
                    ],
                ],
                [
                    'label' => 'Contas & Cartões',
                    'color' => '#3b82f6',
                    'colorBg' => 'rgba(59,130,246,0.10)',
                    'sections' => [
                        [
                            'key' => 'contas',
                            'icon' => 'heroicon-o-building-library',
                            'title' => 'Contas Bancárias',
                            'desc' => 'Cadastro e acompanhamento de saldos',
                            'items' => [
                                ['label' => 'Cadastro', 'text' => 'Adicione suas contas informando nome, banco, tipo (corrente, poupança, etc.) e saldo inicial.'],
                                ['label' => 'Saldo', 'text' => 'O saldo é atualizado automaticamente conforme você registra receitas, despesas e transferências.'],
                                ['label' => 'Visão geral', 'text' => 'Acompanhe o saldo de cada conta diretamente na listagem.'],
                            ],
                        ],
                        [
                            'key' => 'cartoes',
                            'icon' => 'heroicon-o-credit-card',
                            'title' => 'Cartões de Crédito',
                            'desc' => 'Limite, fatura e uso mensal',
                            'items' => [
                                ['label' => 'Cadastro', 'text' => 'Informe o nome do cartão, bandeira, limite total e dia de fechamento/vencimento da fatura.'],
                                ['label' => 'Limite', 'text' => 'O sistema calcula automaticamente o limite disponível com base nas despesas vinculadas ao cartão.'],
                                ['label' => 'Uso mensal', 'text' => 'Visualize quanto do limite já foi utilizado no mês corrente na aba de Projeção do Dashboard.'],
                            ],
                        ],
                        [
                            'key' => 'transferencias',
                            'icon' => 'heroicon-o-arrows-right-left',
                            'title' => 'Transferências',
                            'desc' => 'Movimentação entre contas',
                            'items' => [
                                ['label' => 'Como transferir', 'text' => 'Selecione a conta de origem, a conta de destino e o valor. A data é registrada automaticamente.'],
                                ['label' => 'Impacto nos saldos', 'text' => 'O saldo da conta de origem é debitado e o da conta de destino é creditado automaticamente.'],
                                ['label' => 'Histórico', 'text' => 'Todas as transferências ficam registradas para consulta.'],
                            ],
                        ],
                    ],
                ],
                [
                    'label' => 'Despesas & Pagamentos',
                    'color' => '#ef4444',
                    'colorBg' => 'rgba(239,68,68,0.10)',
                    'sections' => [
                        [
                            'key' => 'categorias',
                            'icon' => 'heroicon-o-rectangle-stack',
                            'title' => 'Categorias',
                            'desc' => 'Organização por cores e ícones',
                            'items' => [
                                ['label' => 'Criação', 'text' => 'Crie categorias com nome, cor e ícone para facilitar a identificação visual.'],
                                ['label' => 'Tipo', 'text' => 'Defina se a categoria é para despesas, receitas ou ambas.'],
                                ['label' => 'Gráficos', 'text' => 'As categorias são usadas nos gráficos do Dashboard para mostrar a distribuição das suas finanças.'],
                                ['label' => 'Orçamento', 'text' => 'Vincule categorias ao módulo de Orçamento para definir limites de gastos.'],
                            ],
                        ],
                        [
                            'key' => 'despesas',
                            'icon' => 'heroicon-o-banknotes',
                            'title' => 'Despesas',
                            'desc' => 'Fixas, variáveis e vinculação com conta/cartão',
                            'items' => [
                                ['label' => 'Fixas vs Variáveis', 'text' => 'Despesas fixas se repetem todo mês (aluguel, plano de saúde). Variáveis são pontuais (supermercado, restaurante).'],
                                ['label' => 'Cadastro', 'text' => 'Informe descrição, valor, categoria, data de vencimento e se é fixa ou variável.'],
                                ['label' => 'Vinculação', 'text' => 'Vincule a despesa a uma conta bancária ou cartão de crédito para controle do saldo/limite.'],
                                ['label' => 'Recorrência', 'text' => 'Despesas fixas geram automaticamente os pagamentos mensais no checklist.'],
                            ],
                        ],
                        [
                            'key' => 'pagamentos',
                            'icon' => 'heroicon-o-clipboard-document-check',
                            'title' => 'Pagamentos (Checklist)',
                            'desc' => 'Controle mensal do que já foi pago',
                            'items' => [
                                ['label' => 'Checklist mensal', 'text' => 'Todo mês, um checklist é gerado automaticamente com todas as suas despesas fixas e variáveis pendentes.'],
                                ['label' => 'Marcar como pago', 'text' => 'Ao pagar uma conta, marque-a como paga. O saldo da conta vinculada é atualizado automaticamente.'],
                                ['label' => 'Badge de pendentes', 'text' => 'O menu lateral mostra um badge com a quantidade de pagamentos pendentes para o mês.'],
                                ['label' => 'Filtros', 'text' => 'Filtre por status (pago/pendente), conta ou período para facilitar o controle.'],
                            ],
                        ],
                        [
                            'key' => 'parcelamentos',
                            'icon' => 'heroicon-o-credit-card',
                            'title' => 'Parcelamentos',
                            'desc' => 'Compras parceladas e parcelas automáticas',
                            'items' => [
                                ['label' => 'Cadastro', 'text' => 'Informe a descrição, valor total, número de parcelas e o cartão de crédito utilizado.'],
                                ['label' => 'Parcelas automáticas', 'text' => 'O sistema gera automaticamente todas as parcelas com os valores e datas corretas.'],
                                ['label' => 'Acompanhamento', 'text' => 'Visualize quantas parcelas já foram pagas e quantas ainda restam.'],
                                ['label' => 'Impacto no limite', 'text' => 'Cada parcela impacta o limite do cartão de crédito no mês correspondente.'],
                            ],
                        ],
                    ],
                ],
                [
                    'label' => 'Receitas & Recebimentos',
                    'color' => '#22c55e',
                    'colorBg' => 'rgba(34,197,94,0.10)',
                    'sections' => [
                        [
                            'key' => 'receitas',
                            'icon' => 'heroicon-o-currency-dollar',
                            'title' => 'Receitas',
                            'desc' => 'Fixas, variáveis e fontes de renda',
                            'items' => [
                                ['label' => 'Fixas vs Variáveis', 'text' => 'Receitas fixas se repetem todo mês (salário, aluguel recebido). Variáveis são pontuais (freelance, vendas).'],
                                ['label' => 'Cadastro', 'text' => 'Informe descrição, valor, categoria e data de recebimento esperada.'],
                                ['label' => 'Recorrência', 'text' => 'Receitas fixas geram automaticamente os recebimentos mensais no checklist de recebimentos.'],
                            ],
                        ],
                        [
                            'key' => 'recebimentos',
                            'icon' => 'heroicon-o-clipboard-document-check',
                            'title' => 'Recebimentos (Checklist)',
                            'desc' => 'Controle mensal do que já foi recebido',
                            'items' => [
                                ['label' => 'Checklist mensal', 'text' => 'Semelhante ao checklist de pagamentos, mas focado nas receitas esperadas para o mês.'],
                                ['label' => 'Marcar como recebido', 'text' => 'Ao receber um valor, marque-o como recebido. O saldo da conta vinculada é atualizado.'],
                                ['label' => 'Acompanhamento', 'text' => 'Veja rapidamente quais receitas ainda estão pendentes de recebimento.'],
                            ],
                        ],
                    ],
                ],
                [
                    'label' => 'Planejamento',
                    'color' => '#8b5cf6',
                    'colorBg' => 'rgba(139,92,246,0.10)',
                    'sections' => [
                        [
                            'key' => 'orcamento',
                            'icon' => 'heroicon-o-calculator',
                            'title' => 'Orçamento',
                            'desc' => 'Limites de gastos por categoria',
                            'items' => [
                                ['label' => 'Limites por categoria', 'text' => 'Defina um valor máximo de gasto para cada categoria (ex: Alimentação R$ 800, Lazer R$ 300).'],
                                ['label' => 'Progresso', 'text' => 'Visualize em tempo real quanto já foi gasto em relação ao limite definido.'],
                                ['label' => 'Alertas', 'text' => 'O sistema alerta quando você está próximo de exceder ou já excedeu o limite de uma categoria.'],
                                ['label' => 'Dashboard', 'text' => 'O progresso do orçamento aparece na aba de Despesas do Dashboard.'],
                            ],
                        ],
                        [
                            'key' => 'metas',
                            'icon' => 'heroicon-o-flag',
                            'title' => 'Metas Financeiras',
                            'desc' => 'Objetivos com milestones de progresso',
                            'items' => [
                                ['label' => 'Cadastro', 'text' => 'Crie metas com nome, valor alvo, valor atual e prazo final.'],
                                ['label' => 'Progresso', 'text' => 'Acompanhe a evolução com barra de progresso visual.'],
                                ['label' => 'Milestones', 'text' => 'O sistema celebra marcos importantes: 25%, 50%, 75% e 100% da meta alcançada.'],
                                ['label' => 'Dashboard', 'text' => 'O progresso das metas aparece na aba Comparativo do Dashboard.'],
                            ],
                        ],
                        [
                            'key' => 'assinaturas',
                            'icon' => 'heroicon-o-arrow-path',
                            'title' => 'Assinaturas',
                            'desc' => 'Serviços recorrentes e próximas cobranças',
                            'items' => [
                                ['label' => 'Cadastro', 'text' => 'Registre serviços como Netflix, Spotify, academia, informando nome, valor e ciclo de cobrança.'],
                                ['label' => 'Ciclos', 'text' => 'O sistema suporta diferentes ciclos: semanal, mensal, trimestral, semestral e anual.'],
                                ['label' => 'Próxima cobrança', 'text' => 'Visualize quando será a próxima cobrança de cada assinatura.'],
                                ['label' => 'Custo total', 'text' => 'Veja o custo total mensal de todas as assinaturas na aba de Projeção do Dashboard.'],
                            ],
                        ],
                    ],
                ],
                [
                    'label' => 'Organização',
                    'color' => '#64748b',
                    'colorBg' => 'rgba(100,116,139,0.10)',
                    'sections' => [
                        [
                            'key' => 'tags',
                            'icon' => 'heroicon-o-tag',
                            'title' => 'Tags',
                            'desc' => 'Etiquetas para classificação extra',
                            'items' => [
                                ['label' => 'Etiquetas personalizadas', 'text' => 'Crie tags como "viagem", "emergência", "investimento" para marcar despesas e receitas.'],
                                ['label' => 'Múltiplas tags', 'text' => 'Uma mesma despesa ou receita pode ter várias tags simultaneamente.'],
                                ['label' => 'Filtros', 'text' => 'Use tags para filtrar e encontrar transações específicas rapidamente.'],
                            ],
                        ],
                        [
                            'key' => 'notificacoes',
                            'icon' => 'heroicon-o-bell',
                            'title' => 'Notificações',
                            'desc' => 'Alertas automáticos do sistema',
                            'items' => [
                                ['label' => 'Vencimentos', 'text' => 'Alerta quando uma despesa está próxima do vencimento e ainda não foi paga.'],
                                ['label' => 'Orçamento excedido', 'text' => 'Notificação quando o gasto de uma categoria ultrapassa o limite definido.'],
                                ['label' => 'Metas alcançadas', 'text' => 'Celebração quando você atinge um milestone da sua meta financeira.'],
                                ['label' => 'Sino de notificações', 'text' => 'Acesse todas as notificações pelo ícone de sino no canto superior direito.'],
                            ],
                        ],
                    ],
                ],
            ];

            // Pre-compute JS arrays for group matching and empty state
            foreach ($groups as &$g) {
                $titles = [];
                foreach ($g['sections'] as $s) {
                    $titles[] = "'" . $s['title'] . "'";
                }
                $g['titlesList'] = implode(',', $titles);
            }
            unset($g);

            $allTitles = [];
            foreach ($groups as $g) {
                foreach ($g['sections'] as $s) {
                    $allTitles[] = "'" . $s['title'] . "'";
                }
            }
            $allTitlesJs = implode(',', $allTitles);
        @endphp

        @foreach ($groups as $group)
            {{-- Group --}}
            <div
                x-show="groupHasMatch([], [{{ $group['titlesList'] }}])"
                style="margin-top: 1.5rem;"
            >
                {{-- Group header --}}
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.625rem; padding-left: 0.25rem;">
                    <div style="width: 0.5rem; height: 0.5rem; border-radius: 50%; background: {{ $group['color'] }}; flex-shrink: 0;"></div>
                    <span style="font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;" class="text-gray-500 dark:text-gray-400">{{ $group['label'] }}</span>
                </div>

                {{-- Grouped card --}}
                <div style="border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.07); overflow: hidden;"
                     class="bg-white dark:bg-gray-800">
                    @foreach ($group['sections'] as $index => $section)
                        <div
                            x-show="matches('{{ $section['title'] }}')"
                            @if ($index > 0) style="border-top: 1px solid rgba(255,255,255,0.05);" @endif
                        >
                            {{-- Accordion header --}}
                            <button
                                type="button"
                                @click="toggle('{{ $section['key'] }}')"
                                style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 0.875rem 1.25rem; text-align: left; cursor: pointer; background: none; border: none; font: inherit; color: inherit; gap: 1rem;"
                            >
                                <span style="display: flex; align-items: center; gap: 0.75rem; min-width: 0;">
                                    <span style="width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; background: {{ $group['colorBg'] }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        @svg($section['icon'], 'fi-icon', ['style' => 'width:1.125rem;height:1.125rem;color:' . $group['color'] . ';flex-shrink:0'])
                                    </span>
                                    <span style="min-width: 0;">
                                        <span style="font-weight: 600; font-size: 0.875rem; display: block;" class="text-gray-900 dark:text-white">{{ $section['title'] }}</span>
                                        @if (!empty($section['desc']))
                                            <span style="font-size: 0.75rem; display: block; margin-top: 0.0625rem;" class="text-gray-400 dark:text-gray-500">{{ $section['desc'] }}</span>
                                        @endif
                                    </span>
                                </span>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    style="flex-shrink: 0;"
                                    class="text-gray-400"
                                    x-bind:style="isOpen('{{ $section['key'] }}') ? 'width:1rem;height:1rem;transform:rotate(180deg);transition:transform 0.2s ease' : 'width:1rem;height:1rem;transition:transform 0.2s ease'"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>

                            {{-- Accordion body --}}
                            <div x-show="isOpen('{{ $section['key'] }}')" x-collapse>
                                <div style="padding: 0 1.25rem 1.125rem 4.25rem; font-size: 0.8125rem; line-height: 1.6;" class="text-gray-600 dark:text-gray-400">
                                    @if (!empty($section['intro']))
                                        <p style="margin-bottom: 0.625rem;">{!! $section['intro'] !!}</p>
                                    @endif
                                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                        @foreach ($section['items'] as $item)
                                            <div style="display: flex; gap: 0.625rem; align-items: baseline;">
                                                <span style="width: 0.375rem; height: 0.375rem; border-radius: 50%; background: {{ $item['color'] ?? $group['color'] }}; flex-shrink: 0; margin-top: 0.375rem;"></span>
                                                <span><strong style="color: {{ $item['color'] ?? 'inherit' }};">{{ $item['label'] }}:</strong> {{ $item['text'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if (!empty($section['footer']))
                                        <p style="margin-top: 0.75rem; font-style: italic;" class="text-gray-500 dark:text-gray-500">{{ $section['footer'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Empty state --}}
        <div
            x-show="search && ![{{ $allTitlesJs }}].some(t => t.toLowerCase().includes(search.toLowerCase()))"
            style="text-align: center; padding: 3rem 1rem;"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 2.5rem; height: 2.5rem; margin: 0 auto 0.75rem;" class="text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <p style="font-size: 0.875rem; font-weight: 500;" class="text-gray-500 dark:text-gray-400">Nenhum módulo encontrado</p>
            <p style="font-size: 0.8125rem; margin-top: 0.25rem;" class="text-gray-400 dark:text-gray-500">Tente buscar por outro termo</p>
        </div>
    </div>
</x-filament-panels::page>
