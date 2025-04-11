import {Controller} from '@hotwired/stimulus';


export default class extends Controller {

    const
    modmosregvis_username = $('#modmosregvis_username').get(0);
    const
    modmosregvis_password = $('#modmosregvis_password').get(0);
    let
    api_token = ''
    api_connection

    connect() {

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
                this.auth_in_api(body).then(d => {
                    this.api_connection = JSON.parse(d);
                    this.api_token = `Token: ${JSON.parse(this.api_connection['token'])['token']}`;
                    console.log(this);
                    this.init_from_api().then(d => {
                        $('#modmosregvis_orgId').get(0).value = d['orgId']
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
                    'accept': 'application/json',
                    'content-type': 'application/json',
                },
                dataType: 'json',
                data: body
            })
        )
    }

    async init_from_api() {
        let body = JSON.stringify(this.api_connection);
        return Promise.resolve($.ajax({
                url: `/mod_mosregvis/init_from_api`,
                method: `POST`,
                headers: {
                    'accept': 'application/json',
                    'content-type': 'application/json',
                },
                dataType: 'json',
                data: body
            })
        )
    }


}