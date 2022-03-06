<?php

return [
    // Base Layout
    'js' => [
        'breakpoints' => [
            'sm' => 576,
            'md' => 768,
            'lg' => 992,
            'xl' => 1200,
            'xxl' => 1200
        ],
        'colors' => [
            'theme' => [
                'base' => [
                    'white' => '#ffffff',
                    'primary' => '#6993FF',
                    'secondary' => '#E5EAEE',
                    'success' => '#1BC5BD',
                    'info' => '#8950FC',
                    'warning' => '#FFA800',
                    'danger' => '#F64E60',
                    'light' => '#F3F6F9',
                    'dark' => '#212121'
                ],
                'light' => [
                    'white' => '#ffffff',
                    'primary' => '#E1E9FF',
                    'secondary' => '#ECF0F3',
                    'success' => '#C9F7F5',
                    'info' => '#EEE5FF',
                    'warning' => '#FFF4DE',
                    'danger' => '#FFE2E5',
                    'light' => '#F3F6F9',
                    'dark' => '#D6D6E0'
                ],
                'inverse' => [
                    'white' => '#ffffff',
                    'primary' => '#ffffff',
                    'secondary' => '#212121',
                    'success' => '#ffffff',
                    'info' => '#ffffff',
                    'warning' => '#ffffff',
                    'danger' => '#ffffff',
                    'light' => '#464E5F',
                    'dark' => '#ffffff'
                ]
            ],
            'gray' => [
                'gray-100' => '#F3F6F9',
                'gray-200' => '#ECF0F3',
                'gray-300' => '#E5EAEE',
                'gray-400' => '#D6D6E0',
                'gray-500' => '#B5B5C3',
                'gray-600' => '#80808F',
                'gray-700' => '#464E5F',
                'gray-800' => '#1B283F',
                'gray-900' => '#212121'
            ]
        ],
        'font-family' => 'Poppins'
    ],

    // Demo Assets
    'resources' => [
        'fonts' => [
            'google' => [
                'families' => [
                    'Poppins:300,400,500,600,700'
                ]
            ]
        ],
        'css' => [
            'metronic/assets/plugins/global/plugins.bundle.css',
            'metronic/assets/css/style.bundle.css',
            'vendor/select2/dist/css/select2.min.css',
            'vendor/intTelInput/build/css/intlTelInput.css',
            'vendor/fontawesome/css/all.min.css',
            'vendor/fontawesomepro/css/all.min.css',
            'vendor/toastr/toastr.min.css',
        ],
        'js' => [
            'js/jQuery.min.js',
            'metronic/assets/plugins/global/plugins.bundle.js',
            'metronic/assets/js/scripts.bundle.js',
            'vendor/toastr/toastr.min.js',
            'vendor/block-ui/jquery.blockUI.js',
            'vendor/select2/dist/js/select2.min.js',
            'vendor/intTelInput/build/js/intlTelInput.js',
        ],
    ],

];
