<?php

return [
    'homepage' => redirect('/'),

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
                'class' => 'form-group mb-0'
            ],
            'textarea' => [
                'group' => 'form-group mb-0',
                'label' => 'text-secondary mb-1',
                'input' => 'form-control',
            ],
            'tooltip' => [
                'color' => 'text-secondary',
                'icon' => 'fas fa-question-circle',
                'position' => 'top',
            ],
        ],
    ],
];
