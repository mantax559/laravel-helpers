<?php

return [
    'homepage' => '/',

    'random_id_length' => 15,

    'select2' => [
        'minimum_results_for_search' => 20,
        'data_cache_duration_seconds' => 60,
        'pagination_per_query' => 50,
    ],

    'form' => [
        'checkbox' => [
            'class' => 'form-check-input',
            'label_class' => 'form-check-label',
            'group_class' => 'form-check',
        ],
        'error' => [
            'input_class' => 'is-invalid',
            'message_class' => 'invalid-feedback',
        ],
        'input' => [
            'class' => 'form-control',
            'label_class' => 'input-group-text',
            'group_class' => 'input-group',
        ],
        'input_group' => [
            'append_class' => 'form-text',
        ],
        'label' => [
            'class' => 'text-secondary mb-1',
        ],
        'select' => [
            'class' => 'form-select',
        ],
        'textarea' => [
            'class' => 'form-control',
        ],
        'tooltip' => [
            'class' => 'text-secondary',
            'icon' => 'fas fa-question-circle',
            'position' => 'top',
        ],
    ],
];
