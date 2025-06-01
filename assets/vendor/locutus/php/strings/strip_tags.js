/**
 * Bundled by jsDelivr using Rollup v2.79.2 and Terser v5.39.0.
 * Original file: /npm/locutus@2.0.32/php/strings/strip_tags.js
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
var e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},r=function(r){switch(void 0===r?"undefined":e(r)){case"boolean":return r?"1":"";case"string":return r;case"number":return isNaN(r)?"NAN":isFinite(r)?r+"":(r<0?"-":"")+"INF";case"undefined":return"";case"object":return Array.isArray(r)?"Array":null!==r?"Object":"";default:throw new Error("Unsupported value type")}},t=function(e,t){var n=r;t=(((t||"")+"").toLowerCase().match(/<[a-z][a-z0-9]*>/g)||[]).join("");var o=/<\/?([a-z0-9]*)\b[^>]*>?/gi,a=/<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi,u=n(e);for(u="<"===u.substring(u.length-1)?u.substring(0,u.length-1):u;;){var i=u;if(u=i.replace(a,"").replace(o,(function(e,r){return t.indexOf("<"+r.toLowerCase()+">")>-1?e:""})),i===u)return u}};export{t as default};
