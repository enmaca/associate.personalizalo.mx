import {Modal} from "../../../public/enmaca/laravel-uxmal/libs/bootstrap/js/bootstrap.esm.min.js";

console.log('resources/js/order/create.js Loaded')
window.onChangeSelectedProductToAdd = function (value) {
    console.log('onChangeSelectedProductToAdd:', value);
    // let liveWObj = Livewire.getByName();
    // console.log('livewire object:', liveWObj);
    Livewire.dispatch('select-by-digital-art-body::product.changed', { product: value } );
    //element.dispatchEvent(new Event('input'));
    //openModal('selectProductWithDigitalArtId');
}

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

document.addEventListener('livewire:initialized', () => {
    Livewire.on('select-by-digital-art-body::showmodal', (event) => {
        openModal('selectProductWithDigitalArtId');
    });
});