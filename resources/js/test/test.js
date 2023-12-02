import {Uxmal, UxmalCSRF} from 'laravel-uxmal-npm';
const uxmal = new Uxmal();


document.addEventListener("DOMContentLoaded", function () {
    uxmal.init(document);
    uxmal.alert('Welcome to Uxmal!');
});

document.querySelectorAll('.uxmal-debug-container').forEach((elContainer) => {
    const activator = elContainer.querySelector(':scope > .uxmal-block-debug');

    activator.addEventListener('mouseover', (e) => {
        elContainer.style.outline = '1px dashed ' + (activator.dataset.debugColor ?? 'red');
        activator.querySelector('small').classList.remove('d-none');
    });
    activator.addEventListener('mouseout', (e) => {
        elContainer.style.outline = null;
        activator.querySelector('small').classList.add('d-none');
    });
});
