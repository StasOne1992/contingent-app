import { startStimulusApp } from '@symfony/stimulus-bundle';

import jquery from "jquery";

window.jQuery = jquery;
window.$ = jquery;
import "jquery-mask-plugin";

import Select2Controller from 'stimulus-select2'


const app = startStimulusApp();
// register any custom, 3rd party controllers here
app.register("select2", Select2Controller)
