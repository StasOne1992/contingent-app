import {Controller} from '@hotwired/stimulus';
import toastr from 'toastr';

export default class extends Controller {
    guid_pattern = /^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$/gi;


    modmosregvis_username = $('#modmosregvis_username').get(0);

    modmosregvis_password = $('#modmosregvis_password').get(0);
    load_info_div = $('#info-loading-string').get(0);
    api_token = ''
    api_connection
    console

    connect() {
        toastr.info('Are you the 6 fingered man?')
        this.modmosregvis_username.value = 'sergachovsv'
        this.modmosregvis_password.value = 'xL6pUpZkHNsl'
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
            return hashHex;
        }).catch(e => console.error(e))
        Promise.all([hash]).then((d) => {
                let body = JSON.stringify({
                    'username': username,
                    'password': hash_value
                })
            this.load_info('Авторизация в API')
                this.auth_in_api(body).then(d => {
                    this.load_info('Выполнена авторизация в API')
                    this.api_connection = JSON.parse(d);
                    this.api_token = `Token ${JSON.parse(this.api_connection['token'])['token']}`;
                    this.init_from_api().then(d => {
                        d = JSON.parse(d);
                        if (!d['orgId'].match(this.guid_pattern)) {
                            alert('OrgId is not GUID');
                            throw ('OrgId is not GUID');
                        }
                        $('#modmosregvis_orgId').get(0).value = d['orgId'];
                        this.load_info('Доступ к API получен')

                        this.load_info('Запрос сведений об организации из ВИС')
                        this.get_org_info(d['orgId']).then(d => {
                            let organisation = JSON.parse(d);
                            console.debug('organisation:', organisation);
                            localStorage.setItem('organisation', JSON.stringify(organisation))
                            let isExist = organisation['isExist'];
                            console.debug('isExist:', isExist);

                            $('#org-info').get(0).innerHTML =
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
                                $('#org-info').append(button)
                            }
                        }).catch(e => console.error(e))

                    }).catch(e => console.log(e));
                }).catch(e => console.error(e))

            }
        )

    }

    async auth_in_api(body) {
        return Promise.resolve($.ajax({
                url: `/mod_mosregvis/api_auth`,
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
        console.debug(params);
        let organisation = JSON.parse(localStorage.getItem('organisation'));
        this.load_info(organisation);

        if (params.orgId !== organisation.guid) {
            organisation = this.get_org_info(params.orgId).then(d => this.add_org(JSON.parse(d)))
        }

        if (!$('#modmosregvis_college').value > 0) {
            alert('Не выбран колледж')
            throw ('Не выбран колледж');
        }
        this.post_new_org(organisation).then(d => console.log(d)).catch(e => console.error(e))
    }


    async post_new_org(organisation) {
        let body = {
            'college': $('#modmosregvis_college').value,
            'context': '',
        };

        return new Promise.resolve($.ajax({

            url: '/api/mosreg_v_i_s_colleges',
            method: 'POST',
            headers: {
                'accept': 'application/ld+json',
                'content-type': 'application/ld+json',
            },
            dataType: '',
            data: JSON.stringify(body)
        }))
    }


    async init_from_api() {
        return Promise.resolve($.ajax({
                url: `/mod_mosregvis/init_from_api`,
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
                url: `/mod_mosregvis/get_org_info`,
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


    load_info(message) {
        toastr.info(message);
        console.info(message);
    }
}