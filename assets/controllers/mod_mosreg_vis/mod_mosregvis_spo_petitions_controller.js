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
                petitionLoadModalBody.innerHTML = `<p>Доступно для загрузки ${d.length}</p>`;
                console.log(d);
            })
            .catch(e => {
                petitionLoadModalBody.innerText = "Ошибка загрузки из ВИС: " + e.responseText;
                }
            )

    }

    showLoader(elementId = "") {
        let element = document.getElementById('petitionLoadModalBody')
        let spinner = '<div class="spinner-grow spinner-grow-sm text-secondary" role="status">' +
            '                  </div>  <span class="">Загрузка сведений...</span>'
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