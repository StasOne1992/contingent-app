import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
    }


    auth() {
        const form = $("#auth-form").get(0);
        const formData = new FormData(form);
        One.loader('show');
        let promise = this.sign_in(formData.get("_username"), formData.get("_password"))
            .then(form.submit())
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