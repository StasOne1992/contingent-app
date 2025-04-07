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
    'init-swagger-ui' => [
        'path' => './public/bundles/apiplatform/init-swagger-ui.js',
    ],
    'provide_jquery' => [
        'path' => './assets/js/provide_jquery.js',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'datatables.net-bs5' => [
        'version' => '2.2.2',
    ],
    'datatables.net' => [
        'version' => '2.2.2',
    ],
    'datatables.net-bs5/css/dataTables.bootstrap5.min.css' => [
        'version' => '2.2.2',
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
        'version' => '5.3.5',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.5',
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
        'version' => '44.3.0',
    ],
    '@ckeditor/ckeditor5-build-inline' => [
        'version' => '44.3.0',
    ],
    'chart.js' => [
        'version' => '4.4.8',
    ],
    '@kurkle/color' => [
        'version' => '0.3.4',
    ],
    'cropperjs' => [
        'version' => '2.0.0',
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
        'version' => '6.1.17',
    ],
    '@fullcalendar/core/index.js' => [
        'version' => '6.1.17',
    ],
    '@fullcalendar/interaction/index.js' => [
        'version' => '6.1.17',
    ],
    '@fullcalendar/daygrid/index.js' => [
        'version' => '6.1.17',
    ],
    '@fullcalendar/timegrid/index.js' => [
        'version' => '6.1.17',
    ],
    '@fullcalendar/list/index.js' => [
        'version' => '6.1.17',
    ],
    '@fullcalendar/multimonth/index.js' => [
        'version' => '6.1.17',
    ],
    'preact' => [
        'version' => '10.26.5',
    ],
    'preact/compat' => [
        'version' => '10.26.5',
    ],
    '@fullcalendar/core/internal.js' => [
        'version' => '6.1.17',
    ],
    '@fullcalendar/core/preact.js' => [
        'version' => '6.1.17',
    ],
    '@fullcalendar/daygrid/internal.js' => [
        'version' => '6.1.17',
    ],
    'preact/hooks' => [
        'version' => '10.26.5',
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
        'version' => '11.17.2',
    ],
    'vide' => [
        'version' => '0.5.1',
    ],
    'jquery.maskedinput' => [
        'version' => '1.4.1',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    'jquery-mask-plugin' => [
        'version' => '1.14.16',
    ],
    'datatables.net-autofill-bs5' => [
        'version' => '2.7.0',
    ],
    'datatables.net-buttons-bs5' => [
        'version' => '3.2.2',
    ],
    'datatables.net-colreorder-bs5' => [
        'version' => '2.0.4',
    ],
    'datatables.net-datetime' => [
        'version' => '1.5.5',
    ],
    'datatables.net-fixedcolumns-bs5' => [
        'version' => '5.0.4',
    ],
    'datatables.net-fixedheader-bs5' => [
        'version' => '4.0.1',
    ],
    'datatables.net-keytable-bs5' => [
        'version' => '2.12.1',
    ],
    'datatables.net-responsive-bs5' => [
        'version' => '3.0.4',
    ],
    'datatables.net-rowgroup-bs5' => [
        'version' => '1.5.1',
    ],
    'datatables.net-rowreorder-bs5' => [
        'version' => '1.5.0',
    ],
    'datatables.net-scroller-bs5' => [
        'version' => '2.4.3',
    ],
    'datatables.net-searchbuilder-bs5' => [
        'version' => '1.8.2',
    ],
    'datatables.net-searchpanes-bs5' => [
        'version' => '2.3.3',
    ],
    'datatables.net-select-bs5' => [
        'version' => '3.0.0',
    ],
    'datatables.net-staterestore-bs5' => [
        'version' => '1.4.1',
    ],
    'datatables.net-autofill' => [
        'version' => '2.7.0',
    ],
    'datatables.net-buttons' => [
        'version' => '3.2.2',
    ],
    'datatables.net-colreorder' => [
        'version' => '2.0.4',
    ],
    'datatables.net-fixedcolumns' => [
        'version' => '5.0.4',
    ],
    'datatables.net-fixedheader' => [
        'version' => '4.0.1',
    ],
    'datatables.net-keytable' => [
        'version' => '2.12.1',
    ],
    'datatables.net-responsive' => [
        'version' => '3.0.4',
    ],
    'datatables.net-rowgroup' => [
        'version' => '1.5.1',
    ],
    'datatables.net-rowreorder' => [
        'version' => '1.5.0',
    ],
    'datatables.net-scroller' => [
        'version' => '2.4.3',
    ],
    'datatables.net-searchbuilder' => [
        'version' => '1.8.2',
    ],
    'datatables.net-searchpanes' => [
        'version' => '2.3.3',
    ],
    'datatables.net-select' => [
        'version' => '3.0.0',
    ],
    'datatables.net-staterestore' => [
        'version' => '1.4.1',
    ],
    'datatables.net-autofill-bs5/css/autoFill.bootstrap5.min.css' => [
        'version' => '2.7.0',
        'type' => 'css',
    ],
    'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css' => [
        'version' => '3.2.2',
        'type' => 'css',
    ],
    'datatables.net-colreorder-bs5/css/colReorder.bootstrap5.min.css' => [
        'version' => '2.0.4',
        'type' => 'css',
    ],
    'datatables.net-datetime/dist/dataTables.dateTime.min.css' => [
        'version' => '1.5.5',
        'type' => 'css',
    ],
    'datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css' => [
        'version' => '5.0.4',
        'type' => 'css',
    ],
    'datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css' => [
        'version' => '4.0.1',
        'type' => 'css',
    ],
    'datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css' => [
        'version' => '2.12.1',
        'type' => 'css',
    ],
    'datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css' => [
        'version' => '3.0.4',
        'type' => 'css',
    ],
    'datatables.net-rowgroup-bs5/css/rowGroup.bootstrap5.min.css' => [
        'version' => '1.5.1',
        'type' => 'css',
    ],
    'datatables.net-rowreorder-bs5/css/rowReorder.bootstrap5.min.css' => [
        'version' => '1.5.0',
        'type' => 'css',
    ],
    'datatables.net-scroller-bs5/css/scroller.bootstrap5.min.css' => [
        'version' => '2.4.3',
        'type' => 'css',
    ],
    'datatables.net-searchbuilder-bs5/css/searchBuilder.bootstrap5.min.css' => [
        'version' => '1.8.2',
        'type' => 'css',
    ],
    'datatables.net-searchpanes-bs5/css/searchPanes.bootstrap5.min.css' => [
        'version' => '2.3.3',
        'type' => 'css',
    ],
    'datatables.net-select-bs5/css/select.bootstrap5.min.css' => [
        'version' => '3.0.0',
        'type' => 'css',
    ],
    'datatables.net-staterestore-bs5/css/stateRestore.bootstrap5.min.css' => [
        'version' => '1.4.1',
        'type' => 'css',
    ],
    'stimulus-select2' => [
        'version' => '0.0.4',
    ],
    'stimulus' => [
        'version' => '3.2.2',
    ],
    '@stimulus/core' => [
        'version' => '2.0.0',
    ],
    '@stimulus/mutation-observers' => [
        'version' => '2.0.0',
    ],
    '@stimulus/multimap' => [
        'version' => '2.0.0',
    ],
    'lodash' => [
        'version' => '4.17.21',
    ],
    'bootstrap-toaster' => [
        'version' => '5.2.0-beta1.1',
    ],
    '@editorjs/editorjs' => [
        'version' => '2.30.8',
    ],
    '@cropper/utils' => [
        'version' => '2.0.0',
    ],
    '@cropper/elements' => [
        'version' => '2.0.0',
    ],
    '@cropper/element' => [
        'version' => '2.0.0',
    ],
    '@cropper/element-canvas' => [
        'version' => '2.0.0',
    ],
    '@cropper/element-image' => [
        'version' => '2.0.0',
    ],
    '@cropper/element-shade' => [
        'version' => '2.0.0',
    ],
    '@cropper/element-handle' => [
        'version' => '2.0.0',
    ],
    '@cropper/element-selection' => [
        'version' => '2.0.0',
    ],
    '@cropper/element-grid' => [
        'version' => '2.0.0',
    ],
    '@cropper/element-crosshair' => [
        'version' => '2.0.0',
    ],
    '@cropper/element-viewer' => [
        'version' => '2.0.0',
    ],
    'rollup' => [
        'version' => '4.39.0',
    ],
];
