import {Controller} from '@hotwired/stimulus';
import toastr from 'toastr';

export default class extends Controller {
    guid_pattern = /^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$/gi;
    object_class_name = 'mod_mosreg_vis_configuration';
    modmosregvis_username = document.getElementById(`${this.object_class_name}_username`);
    modmosregvis_password = document.getElementById(`${this.object_class_name}_password`);
    common_column = document.getElementById('common-column');
    load_info_div = document.getElementById('info-loading-string');
    input_org_id = document.getElementById(`${this.object_class_name}_orgId`)
    api_token = ''
    api_connection
    api_configuration
    password_hashed = false;

    connect() {
        this.modmosregvis_username.value = 'sergachovsv'
        this.modmosregvis_password.value = 'xL6pUpZkHNsl'
        document.getElementById('auth-button').setAttribute('disabled', 'disabled')
        this.load_info_div.innerHTML =
            '<div class="d-flex align-items-center mt-2">' +
            '<div class="spinner-grow spinner-grow-sm text-primary me-2" role="status">' +
            '<span class="visually-hidden">Loading...</span>' +
            '</div>' +
            '<span class="justify-content-center align-items-center">Загрузка параметров доступа</span> ' +
            '</div>'
        this.api_getApiConfiguration().then(d => {
                this.api_configuration = JSON.parse(d)
                this.load_info_div.innerHTML = '';
                document.getElementById('auth-button').removeAttribute('disabled')
                console.debug(this)
            }
        ).catch(e => this.message_error(e))

    }

    async api_getApiConfiguration() {
        return Promise.resolve($.ajax({
                url: `/mod_mosregvis/api/getConfiguration`,
                method: `GET`,
                headers: {
                    'accept': 'application/ld+json',
                    'content-type': 'application/ld+json',
                }
            })
        )
    }

    auth() {
        const username = this.modmosregvis_username.value
        const password = this.modmosregvis_password.value
        const hash_data = new TextEncoder().encode(`${username}:${password}`)
        let hash_value = '';
        let hash = crypto.subtle.digest('SHA-256', hash_data).then(hashBuffer => {
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            const hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');
            hash_value = hashHex;
            this.modmosregvis_password = hashHex;
            this.password_hashed = true;
            return hashHex;
        }).catch(e => this.message_error(e))
        Promise.all([hash]).then((d) => {
                let body = JSON.stringify({
                    'username': username,
                    'password': hash_value
                })
            this.message_info('Авторизация в API')
                this.auth_in_api(body).then(d => {
                    this.message_info('Выполнена авторизация в API')
                    this.api_connection = JSON.parse(d);
                    this.message_info('Получен ключ доступа к API')
                    this.api_token = this.api_connection.token;
                    this.init_from_api().then(d => {
                        d = JSON.parse(d);
                        if (!d['orgId'].match(this.guid_pattern)) {
                            alert('OrgId is not GUID');
                            throw ('OrgId is not GUID');
                        }

                        this.common_column.removeAttribute('hidden')
                        this.input_org_id.value = d['orgId'];
                        this.message_info('Доступ к API получен')
                        this.message_info('Запрос сведений об организации из ВИС')
                        this.get_org_info(d['orgId']).then(d => {
                            let organisation = JSON.parse(d);
                            localStorage.setItem('organisation', JSON.stringify(organisation))
                            let isExist = organisation['isExist'];
                            $("#org-info").get(0).innerHTML =
                                `<p>Наименование: ${organisation.fullName}</p>
                                 <p>ИНН: ${organisation.inn}</p>
                                 <p>GUID: ${organisation.guid}</p>
                                 <p>В системе: ${isExist}</p>`;
                            if (!isExist) {
                                let button = document.createElement('button');
                                button.setAttribute('data-action', 'mod-mosreg-vis--mod-mosregvis-new#create_org');
                                button.classList.add('btn');
                                button.type = 'button';
                                button.classList.add('btn-primary');
                                button.classList.add('btn-sm');
                                button.setAttribute('data-mod-mosreg-vis--mod-mosregvis-new-org-id-param', organisation.guid);
                                button.innerHTML = '<i class="fa fa-plus"></i>Добавить';
                                $('#org-info').append(button);
                                this.clearLoadInfoDivContent();
                            }
                        }).catch(e => {
                            this.message_error(e);
                            this.message_info(e)
                        })

                    }).catch(e => {
                        this.message_error(e);
                        this.message_info(e)
                    });
                }).catch(e => {
                    this.message_error(e);
                    this.message_info(e)
                })

            }
        )

    }

    async auth_in_api(body) {
        return Promise.resolve($.ajax({
            url: this.api_configuration['url']['login'],
                method: `POST`,
                headers: {
                    'accept': 'application/ld+json',
                    'content-type': 'application/ld+json',
                },
                dataType: 'json',
                data: body
            })
        )
    }

    create_org(event) {
        const params = event.params;
        let organisation = JSON.parse(localStorage.getItem('organisation'));
        if (params.orgId !== organisation.guid) {
            organisation = this.get_org_info(params.orgId).then(d => this.add_org(JSON.parse(d)))
        }
        let college_select = document.getElementById(`${this.object_class_name}_college`);
        if (!college_select.value > 0 || college_select.value == null) {
            alert('Не выбран колледж')
            throw ('Не выбран колледж');
        }
        this.post_new_org(organisation).then(d => console.log(d)).catch(e => this.message_error(e))
    }


    async post_new_org(organisation) {
        organisation.college = `/api/colleges/${document.getElementById(`${this.object_class_name}_college`).value}`;
        return new Promise.resolve($.ajax({
            url: '/api/mod_mosreg_vis__colleges',
            method: 'POST',
            headers: {
                'accept': 'application/ld+json',
                'content-type': 'application/ld+json',
            },
            dataType: '',
            data: JSON.stringify(organisation)
        }))
    }


    async init_from_api() {
        console.debug(this)
        return Promise.resolve($.ajax({
            url: this.api_configuration['url']['initFromApi'],
            method: `GET`,
                headers: {
                    'accept': 'application/json',
                    'content-type': 'application/json',
                    'X-token': this.api_token,
                },
            })
        )
    }

    async get_org_info(org_id, createOrg = false) {
        console.debug(org_id)
        return Promise.resolve($.ajax({
            url: this.api_configuration['url']['getOrgInfo'],
            method: `GET`,
                headers: {
                    'accept': 'application/json',
                    'content-type': 'application/json',
                    'X-org-id': org_id,
                    'X-token': this.api_token,
                    'X-create-org': createOrg
                },
            })
        )
    }

    async add_org(org) {
        console.debug(org)
    }


    setInfoDivContent(message) {
        this.load_info_div.innerHTML =
            '<div class="d-flex align-items-center mt-2">' +
            '<div class="spinner-grow spinner-grow-sm text-primary me-2" role="status">' +
            '<span class="visually-hidden">Loading...</span>' +
            '</div>' +
            '<span class="justify-content-center align-items-center">' + message +
            '</span> ' +
            '</div>'
    }

    setErrorDivContent(message) {
        this.load_info_div.innerHTML =
            '<div className="alert alert-danger d-flex align-items-center justify-content-between" role="alert">' +
            '<div className="flex-grow-1 me-3">' +
            '<p className="mb-0">' +
            message +
            '</p>' +
            '</div>' +
            '<div className="flex-shrink-0">' +
            '<i className="fa fa-fw fa-times-circle"></i>' +
            '</div>' +
            '</div>'
    }

    clearLoadInfoDivContent() {
        this.load_info_div.innerHTML = '';
    }

    message_info(message) {
        toastr.info(message);
        this.setInfoDivContent(message);
        console.info(message);
    }

    message_error(message) {
        toastr.error(message);
        this.setErrorDivContent(message);
        console.error(message);
    }
}