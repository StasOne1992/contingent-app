/**
 * Bundled by jsDelivr using Rollup v2.79.2 and Terser v5.39.0.
 * Original file: /npm/datatables.net-rowgroup@1.5.1/js/dataTables.rowGroup.mjs
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
import t from"jquery";import r from"datatables.net";export{default}from"datatables.net";
/*! RowGroup 1.5.1
 * © SpryMedia Ltd - datatables.net/license
 */let e=t;
/**
 * @summary     RowGroup
 * @description RowGrouping for DataTables
 * @version     1.5.1
 * @author      SpryMedia Ltd (www.sprymedia.co.uk)
 * @contact     datatables.net
 * @copyright   SpryMedia Ltd.
 *
 * This source file is free software, available under the following license:
 *   MIT license - http://datatables.net/license/mit
 *
 * This source file is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the license files for details.
 *
 * For details please refer to: http://www.datatables.net
 */var n=function(t,o){if(!r.versionCheck||!r.versionCheck("1.11"))throw"RowGroup requires DataTables 1.11 or newer";this.c=e.extend(!0,{},r.defaults.rowGroup,n.defaults,o),this.s={dt:new r.Api(t)},this.dom={};var s=this.s.dt.settings()[0],a=s.rowGroup;if(a)return a;s.rowGroup=this,this._constructor()};e.extend(n.prototype,{dataSrc:function(t){if(void 0===t)return this.c.dataSrc;var r=this.s.dt;return this.c.dataSrc=t,e(r.table().node()).triggerHandler("rowgroup-datasrc.dt",[r,t]),this},disable:function(){return this.c.enable=!1,this},enable:function(t){return!1===t?this.disable():(this.c.enable=!0,this)},enabled:function(){return this.c.enable},_constructor:function(){var t=this,r=this.s.dt,e=r.settings()[0];r.on("draw.dtrg",(function(r,n){t.c.enable&&e===n&&t._draw()})),r.on("column-visibility.dt.dtrg responsive-resize.dt.dtrg",(function(){t._adjustColspan()})),r.on("destroy",(function(){r.off(".dtrg")}))},_adjustColspan:function(){e("tr."+this.c.className,this.s.dt.table().body()).find("th:visible, td:visible").attr("colspan",this._colspan())},_colspan:function(){return this.s.dt.columns().visible().reduce((function(t,r){return t+r}),0)},_draw:function(){var t=this.s.dt,r=this._group(0,t.rows({page:"current"}).indexes());this._groupDisplay(0,r)},_group:function(t,e){var n,o,s,a,i=Array.isArray(this.c.dataSrc)?this.c.dataSrc:[this.c.dataSrc],d=r.util.get(i[t]),u=this.s.dt,c=[];for(s=0,a=e.length;s<a;s++){var l=e[s];null==(n=d(u.row(l).data(),t))&&(n=this.c.emptyDataGroup),void 0!==o&&n===o||(c.push({dataPoint:n,rows:[]}),o=n),c[c.length-1].rows.push(l)}if(void 0!==i[t+1])for(s=0,a=c.length;s<a;s++)c[s].children=this._group(t+1,c[s].rows);return c},_groupDisplay:function(t,r){for(var e,n=this.s.dt,o=0,s=r.length;o<s;o++){var a,i=r[o],d=i.dataPoint,u=i.rows;this.c.startRender&&(e=this.c.startRender.call(this,n.rows(u),d,t),(a=this._rowWrap(e,this.c.startClassName,t))&&a.insertBefore(n.row(u[0]).node())),this.c.endRender&&(e=this.c.endRender.call(this,n.rows(u),d,t),(a=this._rowWrap(e,this.c.endClassName,t))&&a.insertAfter(n.row(u[u.length-1]).node())),i.children&&this._groupDisplay(t+1,i.children)}},_rowWrap:function(t,r,n){return null!==t&&""!==t||(t=this.c.emptyDataGroup),null==t?null:("object"==typeof t&&t.nodeName&&"tr"===t.nodeName.toLowerCase()?e(t):t instanceof e&&t.length&&"tr"===t[0].nodeName.toLowerCase()?t:e("<tr/>").append(e("<th/>").attr("colspan",this._colspan()).attr("scope","row").append(t))).addClass(this.c.className).addClass(r).addClass("dtrg-level-"+n)}}),n.defaults={className:"dtrg-group",dataSrc:0,emptyDataGroup:"No group",enable:!0,endClassName:"dtrg-end",endRender:null,startClassName:"dtrg-start",startRender:function(t,r){return r}},n.version="1.5.1",e.fn.dataTable.RowGroup=n,e.fn.DataTable.RowGroup=n,r.Api.register("rowGroup()",(function(){return this})),r.Api.register("rowGroup().disable()",(function(){return this.iterator("table",(function(t){t.rowGroup&&t.rowGroup.enable(!1)}))})),r.Api.register("rowGroup().enable()",(function(t){return this.iterator("table",(function(r){r.rowGroup&&r.rowGroup.enable(void 0===t||t)}))})),r.Api.register("rowGroup().enabled()",(function(){var t=this.context;return!(!t.length||!t[0].rowGroup)&&t[0].rowGroup.enabled()})),r.Api.register("rowGroup().dataSrc()",(function(t){return void 0===t?this.context[0].rowGroup.dataSrc():this.iterator("table",(function(r){r.rowGroup&&r.rowGroup.dataSrc(t)}))})),e(document).on("preInit.dt.dtrg",(function(t,o,s){if("dt"===t.namespace){var a=o.oInit.rowGroup,i=r.defaults.rowGroup;if(a||i){var d=e.extend({},i,a);!1!==a&&new n(o,d)}}}));
