<?php

return [

    'builder' => [

        'actions' => [

            'clone' => [
                'label' => 'Clonar',
            ],

            'add' => [
                'label' => 'Adicionar a :label',
            ],

            'add_between' => [
                'label' => 'Inserir',
            ],

            'delete' => [
                'label' => 'Excluir',
            ],

            'reorder' => [
                'label' => 'Mover',
            ],

            'move_down' => [
                'label' => 'Mover para baixo',
            ],

            'move_up' => [
                'label' => 'Mover para cima',
            ],

            'collapse' => [
                'label' => 'Recolher',
            ],

            'expand' => [
                'label' => 'Expandir',
            ],

            'collapse_all' => [
                'label' => 'Recolher todos',
            ],

            'expand_all' => [
                'label' => 'Expandir todos',
            ],

        ],

    ],

    'key_value' => [

        'actions' => [

            'add' => [
                'label' => 'Adicionar linha',
            ],

            'delete' => [
                'label' => 'Excluir linha',
            ],

            'reorder' => [
                'label' => 'Reordenar linha',
            ],

        ],

        'fields' => [

            'key' => [
                'label' => 'Chave',
            ],

            'value' => [
                'label' => 'Valor',
            ],

        ],

    ],

    'markdown_editor' => [

        'toolbar_buttons' => [
            'attach_files' => 'Anexar arquivos',
            'blockquote' => 'Citação',
            'bold' => 'Negrito',
            'bullet_list' => 'Lista com marcadores',
            'code_block' => 'Bloco de código',
            'heading' => 'Título',
            'italic' => 'Itálico',
            'link' => 'Link',
            'ordered_list' => 'Lista numerada',
            'redo' => 'Refazer',
            'strike' => 'Tachado',
            'table' => 'Tabela',
            'undo' => 'Desfazer',
        ],

    ],

    'repeater' => [

        'actions' => [

            'add' => [
                'label' => 'Adicionar a :label',
            ],

            'delete' => [
                'label' => 'Excluir',
            ],

            'clone' => [
                'label' => 'Clonar',
            ],

            'reorder' => [
                'label' => 'Mover',
            ],

            'move_down' => [
                'label' => 'Mover para baixo',
            ],

            'move_up' => [
                'label' => 'Mover para cima',
            ],

            'collapse' => [
                'label' => 'Recolher',
            ],

            'expand' => [
                'label' => 'Expandir',
            ],

            'collapse_all' => [
                'label' => 'Recolher todos',
            ],

            'expand_all' => [
                'label' => 'Expandir todos',
            ],

        ],

    ],

    'rich_editor' => [

        'dialogs' => [

            'link' => [

                'actions' => [
                    'link' => 'Link',
                    'unlink' => 'Remover link',
                ],

                'label' => 'URL',

                'placeholder' => 'Digite uma URL',

            ],

        ],

        'toolbar_buttons' => [
            'attach_files' => 'Anexar arquivos',
            'blockquote' => 'Citação',
            'bold' => 'Negrito',
            'bullet_list' => 'Lista com marcadores',
            'code_block' => 'Bloco de código',
            'h1' => 'Título',
            'h2' => 'Subtítulo',
            'h3' => 'Seção',
            'italic' => 'Itálico',
            'link' => 'Link',
            'ordered_list' => 'Lista numerada',
            'redo' => 'Refazer',
            'strike' => 'Tachado',
            'underline' => 'Sublinhado',
            'undo' => 'Desfazer',
        ],

    ],

    'select' => [

        'actions' => [

            'create_option' => [

                'modal' => [

                    'heading' => 'Criar',

                    'actions' => [

                        'create' => [
                            'label' => 'Criar',
                        ],

                        'create_another' => [
                            'label' => 'Criar e criar outro',
                        ],

                    ],

                ],

            ],

            'edit_option' => [

                'modal' => [

                    'heading' => 'Editar',

                    'actions' => [

                        'save' => [
                            'label' => 'Salvar',
                        ],

                    ],

                ],

            ],

        ],

        'boolean' => [
            'true' => 'Sim',
            'false' => 'Não',
        ],

        'loading_message' => 'Carregando...',

        'max_items_message' => 'Apenas :count podem ser selecionados.',

        'no_search_results_message' => 'Nenhuma opção corresponde à sua pesquisa.',

        'placeholder' => 'Selecione uma opção',

        'searching_message' => 'Pesquisando...',

        'search_prompt' => 'Comece a digitar para pesquisar...',

    ],

    'tags_input' => [
        'placeholder' => 'Nova tag',
    ],

    'file_upload' => [

        'editor' => [

            'actions' => [

                'cancel' => [
                    'label' => 'Cancelar',
                ],

                'drag_crop' => [
                    'label' => 'Modo de arrastar "cortar"',
                ],

                'drag_move' => [
                    'label' => 'Modo de arrastar "mover"',
                ],

                'flip_horizontal' => [
                    'label' => 'Inverter imagem horizontalmente',
                ],

                'flip_vertical' => [
                    'label' => 'Inverter imagem verticalmente',
                ],

                'move_down' => [
                    'label' => 'Mover imagem para baixo',
                ],

                'move_left' => [
                    'label' => 'Mover imagem para a esquerda',
                ],

                'move_right' => [
                    'label' => 'Mover imagem para a direita',
                ],

                'move_up' => [
                    'label' => 'Mover imagem para cima',
                ],

                'reset' => [
                    'label' => 'Resetar',
                ],

                'rotate_left' => [
                    'label' => 'Girar imagem para a esquerda',
                ],

                'rotate_right' => [
                    'label' => 'Girar imagem para a direita',
                ],

                'set_aspect_ratio' => [
                    'label' => 'Definir proporção para :ratio',
                ],

                'save' => [
                    'label' => 'Salvar',
                ],

                'zoom_100' => [
                    'label' => 'Ampliar imagem para 100%',
                ],

                'zoom_in' => [
                    'label' => 'Ampliar',
                ],

                'zoom_out' => [
                    'label' => 'Reduzir',
                ],

            ],

            'fields' => [

                'height' => [
                    'label' => 'Altura',
                    'unit' => 'px',
                ],

                'rotation' => [
                    'label' => 'Rotação',
                    'unit' => 'graus',
                ],

                'width' => [
                    'label' => 'Largura',
                    'unit' => 'px',
                ],

                'x_position' => [
                    'label' => 'X',
                    'unit' => 'px',
                ],

                'y_position' => [
                    'label' => 'Y',
                    'unit' => 'px',
                ],

            ],

            'aspect_ratios' => [

                'label' => 'Proporções',

                'no_fixed' => [
                    'label' => 'Livre',
                ],

            ],

        ],

    ],

    'wizard' => [

        'actions' => [

            'previous_step' => [
                'label' => 'Voltar',
            ],

            'next_step' => [
                'label' => 'Próximo',
            ],

        ],

    ],

];
