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
import  '@editorjs/editorjs';


export default class extends Controller {
    const
    contingent_document_id;
    contingent_document_object;
    contingent_document_member_ship;
    student_group_list;
    student_group_select;
    student_in_document_list = [];
    student_list;
    editor = new EditorJS();


    connect() {

        this.contingent_document_id = $("#contingent_document_form_id").val();
        let init_contingent_document_object = this.init_contingent_document_object().then(r => {
            $.each(r[['GroupMemberships']], (index, value) => {
                value['uid'] = crypto.randomUUID();
                this.student_in_document_list.push(value['Student']);
            })
            this.contingent_document_object = r;
            this.contingent_document_member_ship = r['GroupMemberships'];
        }).catch((e) => console.error(e));
        let init_student_group_list = this.init_student_group_list().then(r => {
            this.student_group_list = r['member'];
            this.student_group_select = this.init_student_group_select(r['member']);
        }).catch(e => console.error(e));

        let student_list = this.init_student_list().then((r) => {
            this.student_list = r['member'];
        }).catch((e) => console.log(e))
        Promise.all([
            init_contingent_document_object,
            init_student_group_list,
            student_list,
        ])
            .then(() => {
                    this.update_student_list()
                    this.init_datatable_group_membership()
                    console.log(this)
                }
            ).catch((e) => console.error(e))
    }


    update_student_list() {
        this.init_student_list().then((r) => {
            this.student_list = r['member']
            this.student_list = _.differenceBy(this.student_list, this.student_in_document_list, '@id')
        })

    }

    init_student_list() {
        return Promise.resolve(
            $.ajax({
                url: '/api/students',
                method: "GET"
            }))
    }

    init_student_group_select(data) {
        let selectElement = document.createElement("select");
        selectElement.add(new Option("---", '', true, true))
        $.each(data, function (key, value) {
                let option = new Option(value['Name'], value['@id']);
                selectElement.add(option);
            }
        )
        return selectElement;
    }

    init_datatable_group_membership() {
        const select = this.student_group_select;
        const dat = this.contingent_document_object;
        const table = $('#table-student-in-document-list');
        if ($.fn.dataTable.isDataTable(table)) {

            table.destroy();
        } else {
            table.DataTable({
                data: dat['GroupMemberships'],
                rowId: "uid",
                columns: [
                    {data: 'Student.FirstName'},
                    {data: 'Student.LastName'},
                    {data: 'Student.MiddleName'},
                    {data: 'StudentGroup.Name', defaultContent: '<small>Группа не задана</small>'},
                    {data: 'Student'},
                ],
                columnDefs:
                    [
                        {
                            render: function (data, type, row, meta) {
                                let currentID = row['uid'];
                                let form = document.createElement('form');
                                let groupListSelect = select.cloneNode(true);
                                let btnGroup = document.createElement("div");
                                let btnSave = document.createElement("button");
                                let btnEdit = document.createElement("button");
                                let btnCancel = document.createElement("button");
                                let btnDelete = document.createElement("button");

                                groupListSelect.classList = 'form-select';
                                groupListSelect.id = 'select-' + currentID;
                                groupListSelect.setAttribute('data-controller', 'select2')
                                groupListSelect.setAttribute('data-action', 'change->mod-education--contingent-document-form-edit#on_change_select_group')
                                groupListSelect.setAttribute('data-mod-education--contingent-document-form-edit-prevent-group-param', '')
                                groupListSelect.setAttribute('data-mod-education--contingent-document-form-edit-group-membership-id-param', row['@id'])
                                groupListSelect.setAttribute('data-mod-education--contingent-document-form-edit-current-group-param', '')
                                groupListSelect.setAttribute('data-mod-education--contingent-document-form-edit-select-id-param', groupListSelect.id)
                                groupListSelect.setAttribute('data-mod-education--contingent-document-form-edit-is-changed-param', false)
                                groupListSelect.setAttribute('data-mod-education--contingent-document-form-edit-student-id-param', row['Student']['@id'])
                                groupListSelect.setAttribute('data-mod-education--contingent-document-form-edit-current-id-param', currentID)
                                groupListSelect.setAttribute('data-mod-education--contingent-document-form-edit-group-is-set-param', false);

                                if (row.hasOwnProperty('StudentGroup')) {
                                    groupListSelect.setAttribute('data-mod-education--contingent-document-form-edit-prevent-group-param', row['StudentGroup']['@id']);
                                    groupListSelect.value = row['StudentGroup']['@id'];
                                    groupListSelect.setAttribute('data-mod-education--contingent-document-form-edit-group-is-set-param', true);
                                    groupListSelect.setAttribute('disabled', 'disabled')
                                    btnSave.setAttribute('hidden', "hidden")
                                    btnCancel.setAttribute('hidden', "hidden")
                                } else {
                                    groupListSelect.setAttribute('group_membership_id', null);
                                    btnEdit.setAttribute('hidden', "hidden")
                                }

                                btnGroup.append(groupListSelect)
                                btnGroup.append(btnEdit);
                                btnGroup.append(btnSave);
                                btnGroup.append(btnCancel);
                                btnGroup.append(btnDelete)
                                form.append(btnGroup);


                                form.setAttribute('current-id', currentID)

                                form.id = `form-${currentID}`;


                                btnEdit.setAttribute('current-id', currentID)
                                btnEdit.id = `btn-edit-${currentID}`;
                                btnEdit.classList = 'btn btn-sm btn-primary'
                                btnEdit.type = 'button';
                                btnEdit.setAttribute('data-action', 'click->mod-education--contingent-document-form-edit#group_select_edit')
                                btnEdit.setAttribute('data-mod-education--contingent-document-form-edit-current-id-param', currentID)
                                btnEdit.innerHTML = '<i class="fa fa-pen"></i>'


                                btnSave.setAttribute('current-id', currentID)
                                btnSave.id = `btn-save-${currentID}`;
                                btnSave.classList = 'btn btn-sm btn-success';
                                btnSave.type = 'button';
                                btnSave.setAttribute('data-action', 'click->mod-education--contingent-document-form-edit#change_group')
                                btnSave.setAttribute('data-mod-education--contingent-document-form-edit-current-id-param', currentID)
                                btnSave.setAttribute('data-mod-education--contingent-document-form-edit-select-id-param', groupListSelect.id)
                                btnSave.innerHTML = '<i class="fa fa-save"></i>';

                                btnCancel.setAttribute('current-id', currentID)
                                btnCancel.id = `btn-cancel-${currentID}`;
                                btnCancel.classList = 'btn btn-sm btn-danger';
                                btnCancel.type = 'button';
                                btnCancel.setAttribute('data-action', 'click->mod-education--contingent-document-form-edit#group_edit_cancel')
                                btnCancel.setAttribute('data-mod-education--contingent-document-form-edit-current-id-param', currentID)
                                btnCancel.innerHTML = '<i class="fa fa-close"></i>';

                                btnDelete.setAttribute('current-id', currentID)
                                btnDelete.id = `btn-delete-${currentID}`;
                                btnDelete.classList = 'btn btn-sm btn-danger';
                                btnDelete.type = 'button';
                                btnDelete.setAttribute('data-action', 'click->mod-education--contingent-document-form-edit#member_ship_delete')
                                btnDelete.setAttribute('data-mod-education--contingent-document-form-edit-current-id-param', currentID)
                                btnDelete.innerHTML = '<i class="fa fa-trash-alt"></i>';


                                btnGroup.setAttribute('current-id', currentID)
                                btnGroup.id = `btn-group-${currentID}`;
                                btnGroup.classList = "btn-group w-100";


                                return form;
                            },
                            targets: -1
                        },
                    ]
            })
        }
    }

    change_group(event) {
        const params = event.params;
        const select = $(`#select-${params.currentId}`).get(0);
        params ['selectId'] = select.id;
        this.save_group_changes(params['currentId'])
            .then(r => {
                console.log('success');
                this.disable_edit_group(event)
            }).catch(e => {
            console.error(e);
            alert(e);
        })
    }

    on_change_select_group(event) {
        const params = event.params;
        let select = $(`#${params['selectId']}`).get(0)
        if (typeof select.value !== 'undefined') {
            const group_id = select.value
            const auto_save = $('#auto-save-changes').is(":checked")
            const student_id = params['studentId']
            const is_set_group = params['groupIsSet']
            select.setAttribute('data-mod-education--contingent-document-form-edit-current-group-param', group_id)
            select.setAttribute('data-mod-education--contingent-document-form-edit-is-changed-param', true)
            if (auto_save) {
                this.save_group_changes(params['currentId']).then(r => {
                    console.log('success');
                    this.disable_edit_group(event)
                }).catch(e => {
                    console.error(e);
                    alert(e);
                })
            }
        }
    }

    save_group_changes(current_id) {
        const contingent_document = this.contingent_document_object;
        const select = $(`#select-${current_id}`).get(0);
        const student_id = select.getAttribute('data-mod-education--contingent-document-form-edit-student-id-param');
        const group_id = select.value;
        let method = "PATCH"
        let body = JSON.stringify({
            "@context": "/api/context/GroupMemberShip",
            "@type": "GroupMembership",
            "studentGroup": `${group_id}`,
        });
        return Promise.resolve(
            $.ajax({
                url: `${select.getAttribute('data-mod-education--contingent-document-form-edit-group-membership-id-param')}`,
                method: `${method}`,
                headers: {
                    'accept': 'application/ld+json',
                    'content-type': 'application/merge-patch+json',
                },
                dataType: 'json',
                data: body,
            })
        )
    }

    delete_group_membership(current_id) {
        const contingent_document = this.contingent_document_object;
        const select = $(`#select-${current_id}`).get(0);
        const student_id = select.getAttribute('data-mod-education--contingent-document-form-edit-student-id-param');
        const group_id = select.value;
        let method = "DELETE"
        let body = JSON.stringify({
            "@context": "/api/context/GroupMemberShip",
            "@type": "GroupMembership",
            "studentGroup": `${group_id}`,
        });
        return Promise.resolve(
            $.ajax({
                url: `${select.getAttribute('data-mod-education--contingent-document-form-edit-group-membership-id-param')}`,
                method: `${method}`,
                headers: {
                    'accept': 'application/ld+json',
                    'content-type': 'application/merge-patch+json',
                },
                dataType: 'json',
                data: body,
            })
        )
    }

    group_edit_cancel(event) {
        const params = event.params;
        const select = $(`#select-${params['currentId']}`).get(0);
        const btn_edit = $(`#btn-edit-${params['currentId']}`).get(0);
        const btn_save = $(`#btn-save-${params['currentId']}`).get(0);
        const btn_cancel = $(`#btn-cancel-${params['currentId']}`).get(0);
        if (!select.getAttribute("data-mod-education--contingent-document-form-edit-is-changed-param")) {
            $(`#${select.id}`).val([]);
            select.value = select.getAttribute("data-mod-education--contingent-document-form-edit-prevent-group-param");

        } else {
            $(`#${select.id}`).val([]);
            select.value = select.getAttribute("data-mod-education--contingent-document-form-edit-prevent-group-param");
            this.disable_edit_group(event)
        }

    }

    group_select_edit(event) {
        const params = event.params
        this.activate_edit_group(event)
    }

    member_ship_delete(event) {
        const params = event.params;
        this.delete_group_membership(params['currentId'])
            .then((r) => {
                    const row = $(`tr#${params['currentId']}`).get(0);
                    row.parentNode.removeChild(row)
                }
            ).catch(e => console.error(e))
    }

    activate_edit_group(event) {
        const params = event.params;
        const select = $(`#select-${params['currentId']}`).get(0);
        const btn_delete = $(`#btn-delete-${params['currentId']}`).get(0);
        const btn_edit = $(`#btn-edit-${params['currentId']}`).get(0);
        const btn_save = $(`#btn-save-${params['currentId']}`).get(0);
        const btn_cancel = $(`#btn-cancel-${params['currentId']}`).get(0);
        select.removeAttribute('disabled')
        btn_edit.setAttribute('hidden', 'hidden')
        btn_delete.setAttribute('hidden', 'hidden')
        btn_save.removeAttribute('hidden')
        btn_cancel.removeAttribute('hidden')
    }

    disable_edit_group(event) {
        const params = event.params;
        const select = $(`#select-${params['currentId']}`).get(0);
        const btn_edit = $(`#btn-edit-${params['currentId']}`).get(0);
        const btn_delete = $(`#btn-delete-${params['currentId']}`).get(0);
        const btn_save = $(`#btn-save-${params['currentId']}`).get(0);
        const btn_cancel = $(`#btn-cancel-${params['currentId']}`).get(0);
        select.setAttribute('disabled', 'disabled')
        btn_edit.removeAttribute('hidden')
        btn_delete.removeAttribute('hidden')
        btn_save.setAttribute('hidden', 'hidden')
        btn_cancel.setAttribute('hidden', 'hidden')
    }

    reload_datatable_group_membership() {
        const table = $('#table-student-in-document-list');
        if ($.fn.dataTable.isDataTable(table)) {
            table.innerHTML = '';
            table.destroy();
        }
        this.init_datatable_group_membership();
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

    init_student_group_list() {
        try {
            return Promise.resolve($.ajax({url: '/api/student_groups'}))
        } catch (error) {
            console.error('error:', error);
        }
    }

    init_modal_student_add(event) {
        const params = event.params
        const modal = new bootstrap.Modal($('#modal-student-list').get(0));
        const modal_content = $('#modal-student-list-content')
        const modal_buttons = $('#modal-student-list-content-buttons');
        modal_content.empty();
        modal_buttons.empty();
        let table = document.createElement('table')
        table.classList.add('table');
        table.id = "student-list-table";
        const label = document.createElement('label');
        label.innerHTML = 'Группа'
        label.setAttribute('for', 'target-student-group')
        const group_list = this.student_group_select.cloneNode(true);
        group_list.id = 'target-student-group'
        group_list.classList.add('form-select')


        modal_content.append(label, group_list, table)
        const btn_save = document.createElement('button')
        const btn_cancel = document.createElement('button')

        btn_save.innerHTML = '<i class="fa fa-plus-circle me-1"></i> Добавить в приказ'
        btn_save.type = "button"
        btn_save.setAttribute('data-action', 'mod-education--contingent-document-form-edit#add_to_document')
        btn_save.setAttribute('data-mod-education--contingent-document-form-edit-group-mode-param', false)
        btn_save.setAttribute('data-mod-education--contingent-document-form-edit-group-field-id-param', 'target-student-group')

        btn_cancel.innerHTML = '<i class="fa fa-window-close me-1"></i> Закрыть'
        btn_cancel.type = "button"


        modal_buttons.append(btn_save, btn_cancel)


        let headers = ['Фамилия', 'Имя', 'Отчество', 'СНИЛС'];
        $(`#student-list-table`).DataTable({
            data: this.student_list,
            paging: true,
            pageLength: 20,
            lengthMenu: [30, 50, 75, 100],
            columns: [
                {
                    data: '@id',
                    render: DataTable.render.select(),
                },

                {title: headers[0], data: 'FirstName'},
                {title: headers[1], data: 'LastName'},
                {title: headers[2], data: 'MiddleName'},
                {title: headers[3], data: 'DocumentSnils'},
            ],
            select: {
                style: 'multi'
            }
        });

        if (params['groupMode']) {
            btn_save.setAttribute('data-mod-education--contingent-document-form-edit-group-mode-param', true)
            label.removeAttribute('hidden')
            group_list.removeAttribute('hidden')
        } else {
            btn_save.setAttribute('data-mod-education--contingent-document-form-edit-group-mode-param', false)
            label.setAttribute('hidden', 'hidden')
            group_list.setAttribute('hidden', 'hidden')
        }

        modal.show()
    }

    add_to_document(event) {
        const params = event.params
        const table = $('#student-list-table')
        const groupMode = params['groupMode']
        const groupField = $(`#${params['groupFieldId']}`)
        const contingent_document = this.contingent_document_object;


        let data = table.DataTable().rows({selected: true}).data();
        if (data.length > 0) {
            for (const item in data) {
                if (typeof data[item] === 'object' && '@id' in data[item]) {
                    console.log(data[item])
                    let body = {
                            "@context": "/api/context/GroupMemberShip",
                            "@type": "GroupMembership",
                            "ContingentDocument": `${contingent_document['@id']}`,
                            "Student": `${data[item]['@id']}`,
                            "Active": false,
                        }
                    ;
                    if (groupMode) {
                        body['studentGroup'] = groupField.val()
                    }


                    this.push_to_document(body).then()

                    //this.addToDocument(contingent_document, data[item]);
                }
            }
        }


    }

    async push_to_document(body) {
        return Promise.resolve($.ajax({
                url: `/api/group_memberships`,
                method: `POST`,
                headers: {
                    'accept': 'application/ld+json',
                    'content-type': 'application/ld+json',
                },
                dataType: 'json',
                data: JSON.stringify(body)
            })
        )
    }


}