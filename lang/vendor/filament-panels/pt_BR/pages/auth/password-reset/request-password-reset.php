<?php

return [

    'title' => 'Recuperar senha',

    'heading' => 'Esqueceu sua senha?',

    'actions' => [

        'login' => [
            'label' => 'voltar para o login',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'E-mail',
        ],

        'actions' => [

            'request' => [
                'label' => 'Enviar link de recuperação',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Muitas tentativas',
            'body' => 'Por favor, tente novamente em :seconds segundos.',
        ],

        'sent' => [
            'title' => 'E-mail enviado',
            'body' => 'Verifique seu e-mail para instruções sobre como redefinir sua senha.',
        ],

    ],

];
