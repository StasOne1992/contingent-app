import {startStimulusApp} from '@symfony/stimulus-bundle';
import jquery from "jquery";
import Select2Controller from 'stimulus-select2'



window.jQuery = jquery;
window.$ = jquery;
import "jquery-mask-plugin";


const app = startStimulusApp();
// register any custom, 3rd party controllers here
app.register("select2", Select2Controller)
