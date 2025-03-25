import { startStimulusApp } from '@symfony/stimulus-bundle';
import jquery from "jquery";

window.jQuery = jquery;
window.$ = jquery;
import "jquery-mask-plugin";

const app = startStimulusApp();
// register any custom, 3rd party controllers here

