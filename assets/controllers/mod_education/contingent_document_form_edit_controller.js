import {Controller} from '@hotwired/stimulus';
import DataTable from 'datatables.net-bs5'

import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css'
import "jszip"
import "pdfmake"
import "datatables.net-autofill-bs5"
import "datatables.net-buttons-bs5"
import "datatables.net-colreorder-bs5"
import "datatables.net-datetime"
import "datatables.net-fixedcolumns-bs5"
import "datatables.net-fixedheader-bs5"
import "datatables.net-keytable-bs5"
import "datatables.net-responsive-bs5"
import "datatables.net-rowgroup-bs5"
import "datatables.net-rowreorder-bs5"
import "datatables.net-scroller-bs5"
import "datatables.net-searchbuilder-bs5"
import "datatables.net-searchpanes-bs5"
import "datatables.net-select-bs5"
import "datatables.net-staterestore-bs5"


export default class extends Controller {

    contingent_document_id = $("#contingent_document_form_id").val();
    contingent_document_object = this.getContingentDocument(this.contingent_document_id);
    student_group_list = this.getStudentGroupList().then((result) => {
        return result['member']
    });

    connect()
    {
        console.log(this)
    }

    async getContingentDocument(document_id) {
        try {
            return Promise.resolve(
                $.ajax({
                    url: `/api/contingent_documents/${document_id}`,
                    method: `GET`,
                    headers: {
                        'content-type': 'application/json',
                    }
                })
            )
        } catch (error) {
            console.error('error:', error);
        }


    }

    async getStudentGroupList() {
        try {
            return Promise.resolve($.ajax({url: '/api/student_groups'}))
        } catch (error) {
            console.error('error:', error);
        }
    }

}