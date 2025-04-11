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
import _ from "lodash"
import "bootstrap-toaster"
import Swal from 'sweetalert2'

export default class extends Controller {
    static values = {contingentDocumentId: Number}

    contingent_document_id;
    contingent_document_object;
    contingent_document_member_ship;
    student_group_list;
    student_group_select;
    student_in_document_list = [];
    student_list;


    connect(event) {
        this.contingent_document_id = this.contingentDocumentIdValue;
        let init_contingent_document_object = this.init_contingent_document_object().then(r => {
            $.each(r[['GroupMemberships']], (index, value) => {
                value['uid'] = crypto.randomUUID();
                this.student_in_document_list.push(value['Student']);
            })
            this.contingent_document_object = r;
            this.contingent_document_member_ship = r['GroupMemberships'];
        }).catch((e) => console.error(e));

        Promise.all([
            init_contingent_document_object,
        ]).then(() => {
            this.init_student_table()
            console.log(this)
        })
            .catch
            ((e) => {
                console.error(e)
            })


    }

    init_contingent_document_object() {
        let document_id = this.contingent_document_id;
        return Promise.resolve(
            $.ajax({
                url: ` /api/contingent_documents/${document_id}`,
                method: `GET`,
                headers: {
                    'content-type': 'application/json',
                }
            })
        )
    }

    init_student_table() {
        let headers = ['Фамилия', 'Имя', 'Отчество', 'Группа'];
        $(`#student-list-table`).DataTable({
            data: this.contingent_document_member_ship,
            paging: true,
            pageLength: 20,
            lengthMenu: [20, 50, 75, 100],
            columns: [
                {title: headers[0], data: 'Student.FirstName'},
                {title: headers[1], data: 'Student.LastName'},
                {title: headers[2], data: 'Student.MiddleName'},
                {title: headers[3], data: 'StudentGroup.Name'},
            ],
        });
    }
}