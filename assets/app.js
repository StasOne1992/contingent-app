import './bootstrap.js';

/**
 * JS import
 */

import 'jquery-mask-plugin'
import "./bundles/oneui_webpack/app";
import "./bundles/oneui_webpack/oneui/app";
//import "./bundles/oneui_webpack/oneui/oneui.app.min.js";
import 'bootstrap-toaster';


/**
 * CSS import
 */


import './bundles/oneui_webpack/css/oneui.css';
import '/node_modules/bootstrap-toaster/dist/css/bootstrap-toaster.css';

/**
 * bootstrap-toaster config
 */
Toast.setPlacement(TOAST_PLACEMENT.BOTTOM_RIGHT);
Toast.setMaxCount(6);
Toast.enableQueue(true);
Toast.enableTimers(TOAST_TIMERS.COUNTDOWN);
Toast.setTheme(TOAST_THEME.DARK);