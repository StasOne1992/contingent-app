import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        const form = $("#auth-form").get(0);
        form.addEventListener('submit', (e) => {
            e.preventDefault()
            One.loader('show');
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
                    e.submit();
                })
                .catch(alert);
            One.loader('hide');
        })
    }


}