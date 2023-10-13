<?php

return [
    'home_route' => route('home'),

    'random_id_length' => 15,

    'css' => [
        'form' => [
            'error' => [
                'inline' => [
                    'div' => 'invalid-feedback',
                ],
            ],
            'textarea' => [
                'wrap' => 'form-group mb-0',
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
