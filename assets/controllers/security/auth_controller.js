import {Controller} from '@hotwired/stimulus';


//TODO: Сделать реакцию на нажатие на кнопку Enter

export default class extends Controller {
    static targets = ["_username", "_password"]

    connect() {
    }


    auth() {
        const form = $("#auth-form").get(0);
        const formData = new FormData(form);
        One.loader('show');
        let promise = this.sign_in(this.username, this.password)
            .then(d => {

                    if (d === 204) {
                        form.submit();
                    } else {
                        One.loader('hide');
                        let toast = {
                            title: "Title",
                            icon:"si si-bubble",
                            message: d.message,
                            status: TOAST_STATUS.DANGER
                        }
                        Toast.create(toast);
                    }
                }
            )
            .catch(e => {
                One.loader('hide');
                console.error(e.message);
                let toast = {
                    title: "Title",
                    icon:"si si-bubble",
                    message: ""+e.message,
                    status: TOAST_STATUS.DANGER,
                    content: "SSS"
                }
                Toast.create(toast);
            })
    }

    get username() {
        return this["_usernameTarget"].value;
    }

    get password() {
        return this["_passwordTarget"].value;
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
                    if (jqXHR.status === 204) {
                        resolve(jqXHR.status);
                    }
                    reject(textStatus);
                }).fail(function (xhr) {
                    reject(JSON.parse(xhr.responseText));
                })
            )
        })
    }
}