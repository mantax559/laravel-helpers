<?php

return [
    'validation' => [
        'max_string_length' => 255,
        'max_text_length' => 1000,
        'max_array' => 100,
        'max_file_size' => 4096, // Bytes
        'min_image_dimension' => 200,
        'min_password_length' => 18,
        'accept_image_extensions' => 'apng,avif,gif,jpg,jpeg,jfif,pjpeg,pjp,png,svg,webp',
        'accept_file_extensions' => 'pdf',
    ],

    'redirect' => [
        'homepage' => '/',
    ],

    'select2' => [
        'minimum_results_for_search' => 20,
        'data_cache_duration_seconds' => 60,
        'pagination_per_query' => 50,
    ],

    'component' => [
        'id_length' => 15,
        'checkbox' => [
            'class' => 'form-check-input',
            'label_class' => 'form-check-label',
            'group_class' => 'form-check',
        ],
        'error' => [
            'default_error_bag' => 'default',
            'input_class' => 'is-invalid',
            'message_class' => 'invalid-feedback',
        ],
        'generate_password_button' => [
            'class' => 'btn btn-sm btn-primary',
            'icon' => 'fas fa-key',
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
