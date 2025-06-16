import {Controller} from '@hotwired/stimulus';
import toastr from 'toastr';

export default class extends Controller {
    static targets = ["username", "password"]

    guid_pattern = /^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$/gi;
    object_class_name = 'mod_mosreg_vis_configuration';
    common_column = document.getElementById('common-column');
    load_info_div = document.getElementById('info-loading-string');
    input_org_id = document.getElementById(`${this.object_class_name}_orgId`)
    api_token = ''
    api_connection
    api_configuration
    password_hashed = false;

    initialize() {
    }

    connect() {
        console.log()
        this.setfordebug()
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

    setfordebug() {
        this['usernameTarget'].value = 'sergachovsv'
        this['passwordTarget'].value = 'xL6pUpZkHNsl'
    }

    get username() {
        return this['usernameTarget'].value;
    }

    get password() {
        return this['passwordTarget'].value
    };


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
        const username = this.username;
        const password = this.password;
        console.log(username);
        console.log(password);
        const hash_data = new TextEncoder().encode(`${username}:${password}`)
        let hash_value = '';
        let hash = crypto.subtle.digest('SHA-256', hash_data).then(hashBuffer => {
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            const hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');
            hash_value = hashHex;
            this.modmosregvis_password = hashHex;
            this.password_hashed = true;
            return hashHex;
        }).catch(e => {
            this.message_error(e)
        })
        Promise.all([hash]).then((d) => {
                let body = JSON.stringify({
                    'username': username,
                    'password': hash_value
                })
            this.message_info('Авторизация в API')
            this.auth_in_api(body)
                .then(d => {
                    this.message_info('Попытка авторизации в API')
                    this.api_connection = JSON.parse(d);
                    this.api_token = this.api_connection.token;
                    if (this.api_token) {
                        this.message_info('Получен ключ доступа к API')
                        this.init_from_api()
                            .then(d => {
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
                                 <p>В системе: ${(isExist) ? "Да" : "Нет"}</p>`;

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
                            } else {
                                document.getElementById('mod_mosreg_vis_configuration_mosregVISCollege').value = organisation.existId;
                            }
                            this.clearLoadInfoDivContent();
                        }).catch(e => {
                            this.message_error(e);
                            this.message_info(e)
                        })
                            })
                            .catch(e => {
                                this.message_error(e);
                            });
                    } else {
                        this.message_error('Ошибка получения ключа доступа к API');
                    }
                })
                .catch(e => {
                    console.debug(e);
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

    message_info(message, type = 'default') {
        if (type === 'default') {
        toastr.info(message);
        this.setInfoDivContent(message);
            console.info(message);
        }
        if (type === 'error') {
            this.message_error(message);
        }
    }

    message_error(message) {
        toastr.error(message);
        this.setErrorDivContent(message);
        console.error(message);
    }
}