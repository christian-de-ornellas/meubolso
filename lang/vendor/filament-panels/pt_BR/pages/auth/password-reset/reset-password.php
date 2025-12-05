<?php

return [

    'title' => 'Redefinir senha',

    'heading' => 'Redefinir sua senha',

    'form' => [

        'email' => [
            'label' => 'E-mail',
        ],

        'password' => [
            'label' => 'Senha',
        ],

        'password_confirmation' => [
            'label' => 'Confirmar senha',
        ],

        'actions' => [

            'reset' => [
                'label' => 'Redefinir senha',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Muitas tentativas',
            'body' => 'Por favor, tente novamente em :seconds segundos.',
        ],

        'reset' => [
            'title' => 'Senha redefinida',
            'body' => 'Sua senha foi redefinida com sucesso.',
        ],

    ],

];
