import {Modal} from "../../../public/enmaca/laravel-uxmal/libs/bootstrap/js/bootstrap.esm.min.js";

console.log('resources/js/order/create.js Loaded')
window.onChangeSelectedProductToAdd = function (value) {
    console.log('onChangeSelectedProductToAdd:', value);
    // let liveWObj = Livewire.getByName();
    // console.log('livewire object:', liveWObj);
    uxmalSetCardLoading('productCard', true);
    Livewire.dispatch('select-by-digital-art-body::product.changed', {product: value});
    //element.dispatchEvent(new Event('input'));
    //openModal('selectProductWithDigitalArtId');
}

window.onChangeSelectedLaborCostByName = function (value) {
    console.log('onChangeSelectedLaborCostByName:', value);
}

window.onChangeSelectedMaterialByNameSkuDesc = function (value) {
    console.log('onChangeSelectedMaterialByNameSkuDesc:', value);
}

window.onChangeSelectedMfgAreaByName = function (value) {
    console.log('onChangeSelectedMfgAreaByName:', value);
}

window.onChangeSelectedMfgDeviceByName = function (value) {
    console.log('onChangeSelectedMfgDeviceByName:', value);
}

window.onChangeSelectedMfgOverHeadByName = function (value) {
    console.log('onChangeSelectedMfgOverHeadByName:', value);
}

document.addEventListener('livewire:initialized', () => {
    Livewire.on('select-by-digital-art-body::showmodal', (event) => {
        openModal('selectProductWithDigitalArtId');
        uxmalSetCardLoading('productCard', false);
    });
});



window.openModal = function (identifier) {
    const element = document.getElementById(identifier);
    if (!element) {
        console.error('No modal found with the given identifier');
        return;
    }
    const modalInstance = new Modal(element);
    modalInstance.show();
    setTimeout(function () {
        let swiperEl = element.querySelector('[data-swiper]');
        if (swiperEl) window.init_swiper_elem(swiperEl)
    }, 500);
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