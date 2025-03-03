import {Controller} from '@hotwired/stimulus';
import 'datatables.net-bs5'
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css'



export default class extends Controller {
    studentGroupList;
    studentGroupSelect;
    connect() {
        let select;

        this.getStudentGroupList().then(data => {
            this.studentGroupList = data['member'];
            let studentGroupList=this.studentGroupList;
            this.studentGroupSelect = this.generateSelectGroupList();
            select = this.studentGroupSelect;


            $('#table-student-in-document-list').DataTable({
            ajax: {
                url: '/api/contingent_documents/1',
                dataSrc: 'GroupMemberships'
            },
            columns: [
                {data: 'Student.FirstName'},
                {data: 'Student.LastName'},
                {data: 'Student.MiddleName'},
                {data: 'StudentGroup.Name',     defaultContent: '<small>Группа не задана</small>'},
                {data: 'StudentGroup'},
            ],
                columnDefs:
                    [
                        {
                            targets: -1,
                            render: function (data, type, row, meta) {
                                let groupListSelect = document.createElement("select");
                                let btnGroup= document.createElement("div");
                                btnGroup.classList="btn-group";
                                groupListSelect.id = 'student:';
                                console.log(data);
                                $.each(studentGroupList, function (key, value) {
                                    let option = new Option(value['Name'], value['@id']);
                                    groupListSelect.add(option);
                                });
                                let btnSave = document.createElement("button");
                                btnSave.classList='btn btn-sm btn-success';
                                btnSave.type='button';
                                btnSave.onclick =function (){
                                    console.log('btnSave Click')

                                }
                                btnSave.innerHTML='<i class="fa fa-save"></i>';
                                let btnCancel = document.createElement("button");
                                btnCancel.classList='btn btn-sm btn-danger';
                                btnCancel.type='button';
                                btnCancel.innerHTML='<i class="fa fa-cancel"></i>';
                                btnGroup.append(groupListSelect);
                                btnGroup.append(btnSave);
                                btnGroup.append(btnCancel);
                                return btnGroup;
                            }
                        },
                    ]
        });

        });
    }


    async getStudentGroupList() {
        try {
            return Promise.resolve($.ajax({url: '/api/student_groups'}))
        } catch (error) {
            console.error('error:', error);
        }
    }

    generateSelectGroupList() {
        let groupListSelect = document.createElement("select");
        this.getStudentGroupList().then(data => {


        })
        return groupListSelect;
    }

}
