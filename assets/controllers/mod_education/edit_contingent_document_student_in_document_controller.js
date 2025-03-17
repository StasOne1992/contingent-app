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

            console.log($('#contingent-document-id').val());

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
                {data: data},
            ],
                columnDefs:
                    [
                        {
                            targets: -1,
                            render: function (data, type, row, meta) {
                                let currentID=crypto.randomUUID().substr(24, 8);
                                let btnGroup= document.createElement("div");

                                let groupListSelect = document.createElement("select");
                                let btnSave = document.createElement("button");
                                let btnCancel = document.createElement("button");

                                btnGroup.classList="btn-group";
                                btnGroup.id=currentID;


                                groupListSelect.classList="form-select";
                                groupListSelect.id='select-'+currentID;


                                groupListSelect.setAttribute('studentid',data['Student']['@id']);
                                groupListSelect.setAttribute('groupmembershipid',data['@id']);
                                groupListSelect.add(new Option('Группа не задана',null,true))
                                $.each(studentGroupList, function (key, value) {
                                    let option = new Option(value['Name'], value['@id']);
                                    groupListSelect.add(option);
                                });
                                if (data['StudentGroup']!==undefined )
                                {
                                        groupListSelect.value=data['StudentGroup']['@id'];
                                }

                                btnSave.classList='btn btn-sm btn-success';
                                btnSave.type='button';
                                btnSave.id='btn-save-'+currentID;
                                btnSave.setAttribute('data-source',groupListSelect.id)
                                btnSave.onclick =function (){
                                    console.log('btnSave Click start')
                                    let currentSelect=$(`#${this.getAttribute('data-source')}`);
                                    console.log(currentSelect.val());
                                    console.log('btnSave Click end')
                                }
                                btnSave.innerHTML='<i class="fa fa-save"></i>';
                                btnCancel.classList='btn btn-sm btn-danger';
                                btnCancel.type='button';
                                btnCancel.innerHTML='<i class="fa fa-cancel"></i>';
                                btnCancel.id='btn-cancel-'+currentID;
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
