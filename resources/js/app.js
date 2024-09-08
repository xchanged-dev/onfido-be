import "./bootstrap";
import "bootstrap";

import jQuery from "jquery";
window.$ = jQuery;

import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
};
