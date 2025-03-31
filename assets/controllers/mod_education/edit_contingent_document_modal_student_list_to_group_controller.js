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

    const
    studentListID = 'student-list'
    contingent_document = this.getContingentDocument($('#contingent_document_form_id').val());
    target_student_group = null;

    connect() {
        let studentGroupSelectElement = $("#target_student_group").get(0);
        this.getStudentGroupList().then(data => {
            studentGroupSelectElement.add(new Option('Группа не задана', null, true))
            $.each(data['member'], function (key, value) {
                let option = new Option(value['Name'], value['@id']);
                studentGroupSelectElement.add(option);
            });
            if (data['StudentGroup'] !== undefined) {
                studentGroupSelectElement.value = data['StudentGroup']['@id'];
            }
        });

        $('#student-list').DataTable({
            ajax: {
                url: '/api/students',
                dataSrc: 'member'
            },
            paging: true,
            pageLength: 30,
            lengthMenu: [30, 50, 75, 100],
            columns: [
                {
                    data: '@id',
                    render: DataTable.render.select(),
                },

                {data: 'FirstName'},
                {data: 'LastName'},
                {data: 'MiddleName'},
                {data: 'DocumentSnils'},
            ],
            select: {
                style: 'multi'
            }
        });
    }

    addtodocument(event) {
        let data = $('#student-list').DataTable().rows({selected: true}).data();
        this.target_student_group = $('#target_student_group').val()
        console.log(this);

        if (this.target_student_group !== null) {
            if (data.length > 0) {
                for (const item in data) {
                    if (typeof data[item] === 'object' && '@id' in data[item]) {
                        this.pushToDocument(this.contingent_document, data[item]);
                    }
                }
            }
        } else {
            alert("Необходимо выбрать группу")
        }
    }

    pushToDocument(contingent_document, item) {


        let body = JSON.stringify({
            "@context": "/api/context/GroupMemberShip",
            "@type": "GroupMembership",
            "ContingentDocument": this.contingent_document['@id'],
            "Student": `${item['@id']}`,
            "StudentGroup": this.target_student_group,
            "Active": false,
        });
        console.log(body);

        $.ajax({
            url: `/api/group_memberships`,
            method: `POST`,
            async: false,
            headers: {
                'accept': 'application/ld+json',
                'content-type': 'application/ld+json',
            },
            dataType: 'json',
            data: body,
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
        console.log(body);
    }

    async getStudentGroupList() {
        try {
            return Promise.resolve($.ajax({url: '/api/student_groups'}))
        } catch (error) {
            console.error('error:', error);
        }
    }

    getContingentDocument(document_id) {
        let result;
        $.ajax({
            url: `/api/contingent_documents/${document_id}`,
            method: `GET`,
            async: false,
            headers: {
                'content-type': 'application/json',
            },
            success: function (data) {
                result = data
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
        return result;
    }
}