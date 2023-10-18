import {Modal} from "../../../public/enmaca/laravel-uxmal/libs/bootstrap/js/bootstrap.esm.min.js";

console.log('resources/js/order/create.js Loaded')
window.onChangeSelectedProductToAdd = function (value) {
    console.log('onChangeSelectedProductToAdd:', value);
   // Livewire.dispatch('update', { dale: 4 });
    //console.log('-----hdpwiherkjd-------', Livewire.getByName('products.modal.select-by-digital-art-body'));
    var element = document.getElementById('onChangeSelectedProductToAdd');
    element.dispatchEvent(new Event('input'));
    openModal('selectProductWithDigitalArtId');
}

document.addEventListener('DOMContentLoaded', (event) => {
    window.openModal = function (identifier) {
        const element = document.getElementById(identifier);
        if (!element) {
            console.error('No modal found with the given identifier');
            return;
        }
        const modalInstance = new Modal(element);
        modalInstance.show();
    }

    window.closeModal = function (identifier) {
        const element = document.getElementById(identifier);
        if (!element) {
            console.error('No modal found with the given identifier');
            return;
        }
        const modalInstance = new Modal(element);
        modalInstance.show();
    }
});