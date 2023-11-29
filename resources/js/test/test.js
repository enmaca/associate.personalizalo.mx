import {Uxmal, UxmalCSRF} from 'laravel-uxmal-npm';
const uxmal = new Uxmal();


document.addEventListener("DOMContentLoaded", function () {
    uxmal.init(document);
    uxmal.alert('Welcome to Uxmal!');
});
