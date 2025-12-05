<?php

return [

    'title' => 'Cadastrar',

    'heading' => 'Criar uma conta',

    'actions' => [

        'login' => [
            'before' => 'ou',
            'label' => 'entre na sua conta',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'E-mail',
        ],

        'name' => [
            'label' => 'Nome',
        ],

        'password' => [
            'label' => 'Senha',
        ],

        'password_confirmation' => [
            'label' => 'Confirmar senha',
        ],

        'actions' => [

            'register' => [
                'label' => 'Cadastrar',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Muitas tentativas de cadastro',
            'body' => 'Por favor, tente novamente em :seconds segundos.',
        ],

    ],

];
