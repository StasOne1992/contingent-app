import './bootstrap.js';

/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

/**
 * JS import
 */

const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

import 'jquery-mask-plugin'

import "./bundles/oneui_webpack/app";
import "./bundles/oneui_webpack/oneui/app";


/**
 * CSS import
 */

import '/assets/bundles/OneUI/assets/css/oneui.css'

