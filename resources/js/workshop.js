import {Modal} from "../../public/enmaca/laravel-uxmal/libs/bootstrap/js/bootstrap.esm.min.js";

window.openModal = function (identifier) {
    const element = document.getElementById(identifier);
    if (!element) {
        console.error('No modal found with the given identifier');
        return;
    }
    const modalInstance = new Modal(element);
    modalInstance.show();
    setTimeout(function () {
        window.init_swiper(element);
    }, 500);
}

window.closeModal = function (identifier) {
    const element = document.getElementById(identifier);
    if (!element) {
        console.error('No modal found with the given identifier');
        return;
    }
    const modalInstance = Modal.getInstance(element);
    modalInstance.hide();

}

window.workshopDispatchEvent = (scriptContent) => {
    if (scriptContent.startsWith('livewire::')) {
        // Extract the event name after 'livewire::event'
        const eventName = scriptContent.replace('livewire::', '').trim();

        // Dispatch the Livewire event
        Livewire.dispatch(eventName);
    } else if (scriptContent.startsWith('javascript::')) {
        // Extract the event name after 'javascript::event'
        const eventName = scriptContent.replace('javascript::', '').trim();

        // Create and dispatch the pure JavaScript event
        const event = new Event(eventName);
        document.dispatchEvent(event);
    }
}