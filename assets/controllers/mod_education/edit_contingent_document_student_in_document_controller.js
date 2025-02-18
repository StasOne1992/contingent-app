import {Controller} from '@hotwired/stimulus';
import 'datatables.net-bs5'
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css'


export default class extends Controller {
    connect() {
        console.log("edit_contingent_document_student_in_document");

        $('#table-student-in-document-list').DataTable({
            ajax: {
                url: '/api/contingent_documents/1',
                dataSrc: 'GroupMemberships'
            },
            paging: true,
            pageLength: 30,
            lengthMenu: [30, 50, 75, 100],
            columns: [
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
}