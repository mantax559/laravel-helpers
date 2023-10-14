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
        'modal' => [
            'class' => 'modal fade',
            'dialog_class' => 'modal-dialog',
            'content_class' => 'modal-content shadow',
            'header_class' => 'modal-header',
            'title_class' => 'modal-title',
            'body_class' => 'modal-body py-0 mb-2',
            'footer_class' => 'modal-footer btn-group',
            'close_button_class' => 'btn btn-lg btn-default',
            'submit_button_class' => 'btn btn-lg',
        ],
        'modal_button' => [
            'class' => 'btn btn-primary',
        ],
        'select' => [
            'class' => 'form-select',
        ],
        'tabs' => [
            'name' => 'tab',
            'class' => 'nav nav-tabs',
            'item_class' => 'nav-item',
            'link_class' => 'nav-link',
            'content_class' => 'tab-content',
            'panel_class' => 'tab-pane fade',
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
