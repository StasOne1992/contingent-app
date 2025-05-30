import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["query", "errorMessage", "results"]
    gl

    connect() {
        console.log('group_list_element_controller');
        this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';


        this.init_group_list_object()
            .then(d => {
                    this.gl = d.member;
                    //StudentGroups:GroupListElement message='${JSON.stringify(this.gl)}'></twig:StudentGroups:GroupListElement>`
                    this.element.innerHTML = '<twig:Alert message="I am a success alert!" />';
                    if (this.hasResultsTarget) {
                    }
                }
            )
            .catch(e => console.error(e));
    }


    init_group_list_object() {
        let document_id = this.group_list;
        return Promise.resolve(
            $.ajax({
                url: ` /api/student_groups`,
                method: `GET`,
                headers: {
                    'content-type': 'application/json',
                }
            })
        )
    }
}