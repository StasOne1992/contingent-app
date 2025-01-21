/**
 * Bundled by jsDelivr using Rollup v2.79.1 and Terser v5.19.2.
 * Original file: /npm/just-extend@6.2.0/index.mjs
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
var r=function r(){var t=[].slice.call(arguments),a=!1;"boolean"==typeof t[0]&&(a=t.shift());var o=t[0];if(e(o))throw new Error("extendee must be an object");for(var n=t.slice(1),c=n.length,l=0;l<c;l++){var f=n[l];for(var i in f)if(Object.prototype.hasOwnProperty.call(f,i)){var y=f[i];if(a&&(s=y,Array.isArray(s)||"[object Object]"=={}.toString.call(s))){var p=Array.isArray(y)?[]:{};o[i]=r(!0,Object.prototype.hasOwnProperty.call(o,i)&&!e(o[i])?o[i]:p,y)}else o[i]=y}}var s;return o};function e(r){return!r||"object"!=typeof r&&"function"!=typeof r}export{r as default};
