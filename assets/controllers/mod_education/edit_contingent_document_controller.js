import {Controller} from '@hotwired/stimulus';
import 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';


export default class extends Controller {
    connect() {
        $('#table-student-list').DataTable({
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

    addtodocument() {
        let data = $('#table-student-list').DataTable().rows({selected: true}).data();

        if (data.length > 0) {
            const contingent_document_id = $('#contingent-document-id').val();
            const contingent_document = this.getContingentDocument(contingent_document_id);
            for (const item in data) {
                if (typeof data[item] === 'object' && '@id' in data[item]) {
                    console.log(item, data[item])
                    this.addToDocument(contingent_document, data[item]);
                }
            }
        }
    }

    addToDocument(contingent_document, item) {

        let body = JSON.stringify({
            "@context": "/api/context/GroupMemberShip",
            "@type": "GroupMembership",
            "ContingentDocument": `${contingent_document['@id']}`,
            "Student": `${item['@id']}`,
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