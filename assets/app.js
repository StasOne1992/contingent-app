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


import { promises as fsPromises } from 'fs'
import * as path from 'path'

import '/assets/bundles/oneui_webpack/app.js'
import '/assets/bundles/oneui_webpack/oneui/app'
window.One = new App({ darkMode: "system" }); // Default darkMode preference: "on" or "off" or "system"



/**
 * CSS import
 */

import '/assets/bundles/OneUI/assets/css/oneui.min.css'


/*console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');*/
