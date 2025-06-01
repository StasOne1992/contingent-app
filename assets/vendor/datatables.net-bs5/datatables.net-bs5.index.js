/**
 * Bundled by jsDelivr using Rollup v2.79.2 and Terser v5.39.0.
 * Original file: /npm/datatables.net-bs5@2.3.1/js/dataTables.bootstrap5.mjs
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
import t from"jquery";import e from"datatables.net";export{default}from"datatables.net";
/*! DataTables Bootstrap 5 integration
 * © SpryMedia Ltd - datatables.net/license
 */let n=t;n.extend(!0,e.defaults,{renderer:"bootstrap"}),n.extend(!0,e.ext.classes,{container:"dt-container dt-bootstrap5",search:{input:"form-control form-control-sm"},length:{select:"form-select form-select-sm"},processing:{container:"dt-processing card"},layout:{row:"row mt-2 justify-content-between",cell:"d-md-flex justify-content-between align-items-center",tableCell:"col-12",start:"dt-layout-start col-md-auto me-auto",end:"dt-layout-end col-md-auto ms-auto",full:"dt-layout-full col-md"}}),e.ext.renderer.pagingButton.bootstrap=function(t,e,o,a,r){var l=["dt-paging-button","page-item"];a&&l.push("active"),r&&l.push("disabled");var s=n("<li>").addClass(l.join(" "));return{display:s,clicker:n("<button>",{class:"page-link",role:"link",type:"button"}).html(o).appendTo(s)}},e.ext.renderer.pagingContainer.bootstrap=function(t,e){return n("<ul/>").addClass("pagination").append(e)};
