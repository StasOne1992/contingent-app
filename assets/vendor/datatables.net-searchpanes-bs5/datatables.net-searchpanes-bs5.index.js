/**
 * Bundled by jsDelivr using Rollup v2.79.2 and Terser v5.39.0.
 * Original file: /npm/datatables.net-searchpanes-bs5@2.3.3/js/searchPanes.bootstrap5.mjs
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
import e from"jquery";import t from"datatables.net-bs5";export{default}from"datatables.net-bs5";import"datatables.net-searchpanes";
/*! Bootstrap 5 integration for DataTables' SearchPanes
 * © SpryMedia Ltd - datatables.net/license
 */
let s=e;s.extend(!0,t.SearchPane.classes,{buttonGroup:"btn-group",disabledButton:"disabled",narrow:"col",pane:{container:"table"},paneButton:"btn btn-subtle",pill:"badge rounded-pill bg-secondary",search:"form-control search",table:"table table-sm table-borderless",topRow:"dtsp-topRow"}),s.extend(!0,t.SearchPanes.classes,{clearAll:"dtsp-clearAll btn btn-subtle",collapseAll:"dtsp-collapseAll btn btn-subtle",container:"dtsp-searchPanes",disabledButton:"disabled",panes:"dtsp-panes dtsp-panesContainer",search:t.SearchPane.classes.search,showAll:"dtsp-showAll btn btn-subtle",title:"dtsp-title",titleRow:"dtsp-titleRow"});
