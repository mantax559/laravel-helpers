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
        'error' => [
            'input_class' => 'is-invalid',
            'message_class' => 'invalid-feedback',
        ],
        'input_group' => [
            'class' => 'mb-0',
            'append_class' => 'form-text'
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
