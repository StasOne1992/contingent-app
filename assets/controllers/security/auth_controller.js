import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        const form = $("#auth-form").get(0);
        const btn_login = $("#login-button").get(0);
        const btn_spinner = $("#login-spinner").get(0);
        const btn_icon = $("#button-icon").get(0);

        form.addEventListener('submit', (e) => {
            e.preventDefault()
            btn_spinner.removeAttribute('hidden');
            btn_icon.setAttribute('hidden', 'hidden');
            btn_login.setAttribute('disabled', 'disabled')
            const formData = new FormData(form);
            const fd_as_arr = Array.from(formData.entries());

            let promise = new Promise(function (resolve, reject) {
                const response = fetch("/api/login/check",
                    {
                        method: "POST",
                        headers: {'Content-Type': 'application/json'},
                        body: `{"username":"${formData.get("_username")}","password":"${formData.get("_password")}"}`
                    }).then(function (response) {

                    if (response.status === 204) {
                        return resolve(response.status);
                    }
                    console.log('Looks like there was a problem. Status Code: ' +
                        response.status);
                    return reject('Looks like there was a problem. Status Code: ' + response.status);

                })
            })
                .then(() => {
                    form.submit();
                }).catch((exp) => {
                    btn_spinner.setAttribute('hidden', 'hidden');
                    btn_icon.removeAttribute('hidden');
                    btn_login.removeAttribute('disabled');
                    alert('Looks like there was a problem. Status Code: ' + exp);
                });

        })
    }


    auth() {
        const form = $("#auth-form").get(0);
        const formData = new FormData(form);
        One.loader('show');
        let promise = this.sign_in(formData.get("_username"), formData.get("_password"))
            .then(d => form.submit())
            .catch(e => {
                alert(e);
                console.log(e)
            })

    }

    async sign_in(username, password) {
        return new Promise(function (resolve, reject) {
            ($.ajax({
                    url: "/api/login/check",
                    method: "POST",
                    headers: {
                        "accept": "application/ld+json",
                        "content-type": "application/ld+json",
                    },
                    dataType: 'json',
                    data: JSON.stringify(
                        {
                            'username': username,
                            'password': password,
                        }),
                    timeout: 20000
                }).done(function (data, textStatus, jqXHR) {
                    if (jqXHR.status !== 204) {
                        reject(jqXHR.status)
                    }
                    resolve(jqXHR.status);
                }).fail(function (data) {
                    reject(data.responseJSON.detail);
                })


            )
        })
    }
}