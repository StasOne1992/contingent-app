import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    petitionLoadModal;

    connect() {
        console.log('hello')
        this.petitionLoadModal = new bootstrap.Modal(document.getElementById('petitionLoadModal'), {
            keyboard: false
        })
        console.log(this)
    }

    showModal() {
        this.petitionLoadModal.show()
    }

    getSpoPetitions() {
        let petitionLoadModalBody = document.getElementById('petitionLoadModalBody')
        this.showLoader('petitionLoadModalBody')
        this.getSpoPetitionFromApi()
            .then(d => {
                d = JSON.parse(d);

                petitionLoadModalBody.innerHTML = `Доступно для загрузки ${d.length}`;

                console.log(d);
            })
            .catch(e => {
                    petitionLoadModalBody.innerText = "Ошибка загрузки из ВИС." + e
                }
            )

    }

    showLoader(elementId = "") {
        let element = document.getElementById('petitionLoadModalBody')
        let spinner = "<div id=\"petitionLoadModalBodySpinner\" class=\"spinner-grow text-primary\" role=\"status\">\n" +
            "                    <span class=\"visually-hidden\">Loading...</span>\n" +
            "                  </div>"
        element.innerHTML = spinner;
    }

    async getSpoPetitionFromApi() {
        return Promise.resolve($.ajax({
                url: '/mod_mosregvis/api/getSpoPetitions',
                method: `GET`,
                headers: {
                    'accept': 'application/json',
                    'content-type': 'application/json',
                },
            })
        )
    }
}