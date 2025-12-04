<?php

return [

    'column' => [

        'boolean' => [
            'true' => 'Sim',
            'false' => 'Não',
        ],

    ],

    'actions' => [

        'modal' => [

            'actions' => [

                'cancel' => [
                    'label' => 'Cancelar',
                ],

                'confirm' => [
                    'label' => 'Confirmar',
                ],

                'submit' => [
                    'label' => 'Enviar',
                ],

            ],

        ],

        'delete' => [
            'label' => 'Excluir',
        ],

        'edit' => [
            'label' => 'Editar',
        ],

        'view' => [
            'label' => 'Visualizar',
        ],

        'replicate' => [
            'label' => 'Replicar',
        ],

    ],

    'bulk_actions' => [

        'label' => 'Ações em massa',

        'modal' => [

            'actions' => [

                'cancel' => [
                    'label' => 'Cancelar',
                ],

                'confirm' => [
                    'label' => 'Confirmar',
                ],

            ],

        ],

        'messages' => [

            'delete' => [
                'count' => 'registro|registros',
            ],

        ],

    ],

    'filters' => [

        'actions' => [

            'remove' => [
                'label' => 'Remover filtro',
            ],

            'remove_all' => [
                'label' => 'Remover todos os filtros',
                'tooltip' => 'Remover todos os filtros',
            ],

            'reset' => [
                'label' => 'Resetar',
            ],

        ],

        'multi_select' => [
            'placeholder' => 'Todos',
        ],

        'select' => [
            'placeholder' => 'Todos',
        ],

        'trashed' => [

            'label' => 'Registros excluídos',

            'only_trashed' => 'Apenas registros excluídos',

            'with_trashed' => 'Com registros excluídos',

            'without_trashed' => 'Sem registros excluídos',

        ],

    ],

    'grouping' => [

        'fields' => [

            'group' => [
                'label' => 'Agrupar por',
                'placeholder' => 'Agrupar por',
            ],

            'direction' => [

                'label' => 'Direção do agrupamento',

                'options' => [
                    'asc' => 'Crescente',
                    'desc' => 'Decrescente',
                ],

            ],

        ],

    ],

    'reorder_indicator' => 'Arrastar e soltar registros em ordem',

    'selection_indicator' => [

        'selected_count' => '1 registro selecionado|:count registros selecionados',

        'actions' => [

            'select_all' => [
                'label' => 'Selecionar todos :count',
            ],

            'deselect_all' => [
                'label' => 'Desmarcar todos',
            ],

        ],

    ],

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => 'Ordenar por',
            ],

            'direction' => [

                'label' => 'Direção da ordenação',

                'options' => [
                    'asc' => 'Crescente',
                    'desc' => 'Decrescente',
                ],

            ],

        ],

    ],

];
