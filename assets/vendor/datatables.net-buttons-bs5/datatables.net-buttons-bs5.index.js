/**
 * Bundled by jsDelivr using Rollup v2.79.2 and Terser v5.39.0.
 * Original file: /npm/datatables.net-buttons-bs5@3.2.3/js/buttons.bootstrap5.mjs
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
import t from"jquery";import o from"datatables.net-bs5";export{default}from"datatables.net-bs5";import"datatables.net-buttons";
/*! Bootstrap integration for DataTables' Buttons
 * © SpryMedia Ltd - datatables.net/license
 */
let n=t;n.extend(!0,o.Buttons.defaults,{dom:{container:{className:"dt-buttons btn-group flex-wrap"},button:{className:"btn btn-secondary",active:"active",dropHtml:"",dropClass:"dropdown-toggle"},collection:{container:{tag:"div",className:"dropdown-menu dt-button-collection"},closeButton:!1,button:{tag:"a",className:"dt-button dropdown-item",active:"dt-button-active",disabled:"disabled",spacer:{className:"dropdown-divider",tag:"hr"}}},split:{action:{tag:"a",className:"btn btn-secondary dt-button-split-drop-button",closeButton:!1},dropdown:{tag:"button",className:"btn btn-secondary dt-button-split-drop dropdown-toggle-split",closeButton:!1,align:"split-left",splitAlignClass:"dt-button-split-left"},wrapper:{tag:"div",className:"dt-button-split btn-group",closeButton:!1}}},buttonCreated:function(t,o){return t.buttons?n('<div class="btn-group"/>').append(o):o}}),o.ext.buttons.collection.rightAlignClassName="dropdown-menu-right";
