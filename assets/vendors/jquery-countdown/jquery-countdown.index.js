/**
 * Bundled by jsDelivr using Rollup v2.79.1 and Terser v5.19.2.
 * Original file: /npm/jquery-countdown@2.2.0/dist/jquery.countdown.js
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
/*!
 * The Final Countdown for jQuery v2.2.0 (http://hilios.github.io/jQuery.countdown/)
 * Copyright (c) 2016 Edson Hilios
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
var t;t=function(t){var e=[],s=[],i={precision:100,elapse:!1,defer:!1};s.push(/^[0-9]*$/.source),s.push(/([0-9]{1,2}\/){2}[0-9]{4}( [0-9]{1,2}(:[0-9]{2}){2})?/.source),s.push(/[0-9]{4}([\/\-][0-9]{1,2}){2}( [0-9]{1,2}(:[0-9]{2}){2})?/.source),s=new RegExp(s.join("|"));var o={Y:"years",m:"months",n:"daysToMonth",d:"daysToWeek",w:"weeks",W:"weeksToMonth",H:"hours",M:"minutes",S:"seconds",D:"totalDays",I:"totalHours",N:"totalMinutes",T:"totalSeconds"};function n(t,e){var s="s",i="";return t&&(1===(t=t.replace(/(:|;|\s)/gi,"").split(/\,/)).length?s=t[0]:(i=t[0],s=t[1])),Math.abs(e)>1?s:i}var a=function(s,o,n){this.el=s,this.$el=t(s),this.interval=null,this.offset={},this.options=t.extend({},i),this.instanceNumber=e.length,e.push(this),this.$el.data("countdown-instance",this.instanceNumber),n&&("function"==typeof n?(this.$el.on("update.countdown",n),this.$el.on("stoped.countdown",n),this.$el.on("finish.countdown",n)):this.options=t.extend({},i,n)),this.setFinalDate(o),!1===this.options.defer&&this.start()};t.extend(a.prototype,{start:function(){null!==this.interval&&clearInterval(this.interval);var t=this;this.update(),this.interval=setInterval((function(){t.update.call(t)}),this.options.precision)},stop:function(){clearInterval(this.interval),this.interval=null,this.dispatchEvent("stoped")},toggle:function(){this.interval?this.stop():this.start()},pause:function(){this.stop()},resume:function(){this.start()},remove:function(){this.stop.call(this),e[this.instanceNumber]=null,delete this.$el.data().countdownInstance},setFinalDate:function(t){this.finalDate=function(t){if(t instanceof Date)return t;if(String(t).match(s))return String(t).match(/^[0-9]*$/)&&(t=Number(t)),String(t).match(/\-/)&&(t=String(t).replace(/\-/g,"/")),new Date(t);throw new Error("Couldn't cast `"+t+"` to a date object.")}(t)},update:function(){if(0!==this.$el.closest("html").length){var e,s=void 0!==t._data(this.el,"events"),i=new Date;e=this.finalDate.getTime()-i.getTime(),e=Math.ceil(e/1e3),e=!this.options.elapse&&e<0?0:Math.abs(e),this.totalSecsLeft!==e&&s&&(this.totalSecsLeft=e,this.elapsed=i>=this.finalDate,this.offset={seconds:this.totalSecsLeft%60,minutes:Math.floor(this.totalSecsLeft/60)%60,hours:Math.floor(this.totalSecsLeft/60/60)%24,days:Math.floor(this.totalSecsLeft/60/60/24)%7,daysToWeek:Math.floor(this.totalSecsLeft/60/60/24)%7,daysToMonth:Math.floor(this.totalSecsLeft/60/60/24%30.4368),weeks:Math.floor(this.totalSecsLeft/60/60/24/7),weeksToMonth:Math.floor(this.totalSecsLeft/60/60/24/7)%4,months:Math.floor(this.totalSecsLeft/60/60/24/30.4368),years:Math.abs(this.finalDate.getFullYear()-i.getFullYear()),totalDays:Math.floor(this.totalSecsLeft/60/60/24),totalHours:Math.floor(this.totalSecsLeft/60/60),totalMinutes:Math.floor(this.totalSecsLeft/60),totalSeconds:this.totalSecsLeft},this.options.elapse||0!==this.totalSecsLeft?this.dispatchEvent("update"):(this.stop(),this.dispatchEvent("finish")))}else this.remove()},dispatchEvent:function(e){var s,i=t.Event(e+".countdown");i.finalDate=this.finalDate,i.elapsed=this.elapsed,i.offset=t.extend({},this.offset),i.strftime=(s=this.offset,function(t){var e,i=t.match(/%(-|!)?[A-Z]{1}(:[^;]+;)?/gi);if(i)for(var a=0,h=i.length;a<h;++a){var l=i[a].match(/%(-|!)?([a-zA-Z]{1})(:[^;]+;)?/),r=(e=void 0,e=l[0].toString().replace(/([.?*+^$[\]\\(){}|-])/g,"\\$1"),new RegExp(e)),c=l[1]||"",f=l[3]||"",u=null;l=l[2],o.hasOwnProperty(l)&&(u=o[l],u=Number(s[u])),null!==u&&("!"===c&&(u=n(f,u)),""===c&&u<10&&(u="0"+u.toString()),t=t.replace(r,u.toString()))}return t.replace(/%%/,"%")}),this.$el.trigger(i)}}),t.fn.countdown=function(){var s=Array.prototype.slice.call(arguments,0);return this.each((function(){var i=t(this).data("countdown-instance");if(void 0!==i){var o=e[i],n=s[0];a.prototype.hasOwnProperty(n)?o[n].apply(o,s.slice(1)):null===String(n).match(/^[$A-Z_][0-9A-Z_$]*$/i)?(o.setFinalDate.call(o,n),o.start()):t.error("Method %s does not exist on jQuery.countdown".replace(/\%s/gi,n))}else new a(this,s[0],s[1])}))}},"function"==typeof define&&define.amd?define(["jquery"],t):t(jQuery);
