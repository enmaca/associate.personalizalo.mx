import { UxmalCSRF } from "../../public/enmaca/laravel-uxmal/js/uxmal.js";

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

/**
 *
 * @param order_id
 * @param data
 * @param onsuccess_callback
 * @param onerror_callback
 * @param onwarning_callback
 */
export const updateOrder = (order_id, data, onsuccess_callback = (data) => {
    console.log(data)
}, onerror_callback = (data) => {
    console.error(data);
}, onwarning_callback = (data) => {
    console.warn(data);
}) => {
    fetch('/orders/' + order_id , {
        method: 'PUT', // or 'PUT' if you're updating
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': UxmalCSRF()
        },
        body: JSON.stringify(data), // Convert data object to JSON string
    }).then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Parse JSON response into JavaScript object
    }).then(data => {
        if (data.ok) {
            onsuccess_callback(data.ok);
        } else if (data.error) {
            onerror_callback(data.error);
        } else if (data.warning) {
            onwarning_callback(data.warning);
        }
    }).catch(error => {
        onerror_callback(error);
    });
};