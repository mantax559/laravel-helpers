<?php

return [
    'homepage' => '/',

    'random_id_length' => 15,

    'css' => [
        'form' => [
            'error' => [
                'inline' => [
                    'input' => 'is-invalid',
                    'div' => 'invalid-feedback',
                ],
            ],
            'input-group' => [
                'class' => 'mb-0',
                'append' => 'form-text'
            ],
            'label' => [
                'class' => 'text-secondary mb-1',
            ],
            'textarea' => [
                'class' => 'form-control',
            ],
            'tooltip' => [
                'color' => 'text-secondary',
                'icon' => 'fas fa-question-circle',
                'position' => 'top',
            ],
        ],
    ],
];
