<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'setTheme' => [
        'path' => './assets/js/setTheme.js',
    ],
    'oneUI' => [
        'path' => './assets/js/oneui.app.js',
    ],
    'init-swagger-ui'=>
    [
        'path' => './public/bundles/apiplatform/init-swagger-ui.js'
    ],
    'provide_jquery' => [
        'path' => './assets/js/provide_jquery.js',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'datatables.net-bs5' => [
        'version' => '2.2.1',
    ],
    'datatables.net' => [
        'version' => '2.2.1',
    ],
    'datatables.net-bs5/css/dataTables.bootstrap5.min.css' => [
        'version' => '2.2.1',
        'type' => 'css',
    ],
    'jquery-countdown' => [
        'version' => '2.2.0',
    ],
    'jquery-sparkline' => [
        'version' => '2.4.0',
    ],
    'jquery-validation' => [
        'version' => '1.21.0',
    ],
    'jquery.appear' => [
        'version' => '1.0.1',
    ],
    'bootstrap' => [
        'version' => '5.3.3',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.3',
        'type' => 'css',
    ],
    'bootstrap-datepicker' => [
        'version' => '1.10.0',
    ],
    'bootstrap-maxlength' => [
        'version' => '2.0.0',
    ],
    'bootstrap-notify' => [
        'version' => '3.1.3',
    ],
    'jszip' => [
        'version' => '3.10.1',
    ],
    '@ckeditor/ckeditor5-build-classic' => [
        'version' => '44.1.0',
    ],
    '@ckeditor/ckeditor5-build-inline' => [
        'version' => '44.1.0',
    ],
    'chart.js' => [
        'version' => '4.4.7',
    ],
    '@kurkle/color' => [
        'version' => '0.3.4',
    ],
    'cropperjs' => [
        'version' => '1.6.2',
    ],
    'cropperjs/dist/cropper.min.css' => [
        'version' => '1.6.2',
        'type' => 'css',
    ],
    'dropzone' => [
        'version' => '6.0.0-beta.2',
    ],
    'just-extend' => [
        'version' => '6.2.0',
    ],
    'easy-pie-chart' => [
        'version' => '2.1.7',
    ],
    'flatpickr' => [
        'version' => '4.6.13',
    ],
    'flatpickr/dist/flatpickr.min.css' => [
        'version' => '4.6.13',
        'type' => 'css',
    ],
    'fullcalendar' => [
        'version' => '6.1.15',
    ],
    '@fullcalendar/core/index.js' => [
        'version' => '6.1.15',
    ],
    '@fullcalendar/interaction/index.js' => [
        'version' => '6.1.15',
    ],
    '@fullcalendar/daygrid/index.js' => [
        'version' => '6.1.15',
    ],
    '@fullcalendar/timegrid/index.js' => [
        'version' => '6.1.15',
    ],
    '@fullcalendar/list/index.js' => [
        'version' => '6.1.15',
    ],
    '@fullcalendar/multimonth/index.js' => [
        'version' => '6.1.15',
    ],
    'preact' => [
        'version' => '10.25.4',
    ],
    'preact/compat' => [
        'version' => '10.25.4',
    ],
    '@fullcalendar/core/internal.js' => [
        'version' => '6.1.15',
    ],
    '@fullcalendar/core/preact.js' => [
        'version' => '6.1.15',
    ],
    '@fullcalendar/daygrid/internal.js' => [
        'version' => '6.1.15',
    ],
    'preact/hooks' => [
        'version' => '10.25.4',
    ],
    'highlightjs' => [
        'version' => '9.16.2',
    ],
    'ion-rangeslider' => [
        'version' => '2.3.1',
    ],
    'pdfmake' => [
        'version' => '0.2.18',
    ],
    'magnific-popup' => [
        'version' => '1.2.0',
    ],
    'magnific-popup/dist/magnific-popup.min.css' => [
        'version' => '1.2.0',
        'type' => 'css',
    ],
    'raty-js' => [
        'version' => '4.3.0',
    ],
    'select2' => [
        'version' => '4.1.0-rc.0',
    ],
    'select2/dist/css/select2.min.css' => [
        'version' => '4.1.0-rc.0',
        'type' => 'css',
    ],
    'simplebar' => [
        'version' => '6.3.0',
    ],
    'simplebar-core' => [
        'version' => '1.3.0',
    ],
    'simplebar/dist/simplebar.min.css' => [
        'version' => '6.3.0',
        'type' => 'css',
    ],
    'lodash/debounce.js' => [
        'version' => '4.17.21',
    ],
    'lodash/throttle.js' => [
        'version' => '4.17.21',
    ],
    'simplebar-core/dist/simplebar.min.css' => [
        'version' => '1.3.0',
        'type' => 'css',
    ],
    'slick-carousel' => [
        'version' => '1.8.1',
    ],
    'sweetalert2' => [
        'version' => '11.15.10',
    ],
    'vide' => [
        'version' => '0.5.1',
    ],
    'jquery.maskedinput' => [
        'version' => '1.4.1',
    ],
];
