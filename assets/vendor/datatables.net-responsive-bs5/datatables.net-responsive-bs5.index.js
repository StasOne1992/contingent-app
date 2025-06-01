/**
 * Bundled by jsDelivr using Rollup v2.79.2 and Terser v5.39.0.
 * Original file: /npm/datatables.net-responsive-bs5@3.0.4/js/responsive.bootstrap5.mjs
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
import d from"jquery";import t from"datatables.net-bs5";export{default}from"datatables.net-bs5";import"datatables.net-responsive";
/*! Bootstrap 5 integration for DataTables' Responsive
 * © SpryMedia Ltd - datatables.net/license
 */
let a=d;var e,o=t.Responsive.display,n=o.modal,i=a('<div class="modal fade dtr-bs-modal" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"/></div></div></div>'),r=window.bootstrap;t.Responsive.bootstrap=function(d){r=d},o.modal=function(d){if(!e&&r.Modal){let d=function(){let d=t.use("bootstrap");if(d)return d;if(r)return r;throw new Error("No Bootstrap library. Set it with `DataTable.use(bootstrap);`")}();e=new d.Modal(i[0])}return function(t,o,r,s){if(e){var l=r();if(!1===l)return!1;if(o){if(!a.contains(document,i[0])||t.index()!==i.data("dtr-row-idx"))return null;i.find("div.modal-body").empty().append(l)}else{if(d&&d.header){var m=i.find("div.modal-header"),p=m.find("button").detach();m.empty().append('<h4 class="modal-title">'+d.header(t)+"</h4>").append(p)}i.find("div.modal-body").empty().append(l),i.data("dtr-row-idx",t.index()).one("hidden.bs.modal",s).appendTo("body"),e.show()}return!0}return n(t,o,r,s)}};
