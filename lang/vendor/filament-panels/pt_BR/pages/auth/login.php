<?php

return [

    'title' => 'Entrar',

    'heading' => 'Entrar na sua conta',

    'actions' => [

        'register' => [
            'before' => 'ou',
            'label' => 'cadastre-se para uma conta',
        ],

        'request_password_reset' => [
            'label' => 'Esqueceu sua senha?',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'E-mail',
        ],

        'password' => [
            'label' => 'Senha',
        ],

        'remember' => [
            'label' => 'Lembrar-me',
        ],

        'actions' => [

            'authenticate' => [
                'label' => 'Entrar',
            ],

        ],

    ],

    'messages' => [

        'failed' => 'Credenciais não correspondem aos nossos registros.',

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Muitas tentativas de login',
            'body' => 'Por favor, tente novamente em :seconds segundos.',
        ],

    ],

];
