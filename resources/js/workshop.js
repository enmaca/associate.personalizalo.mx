import {Uxmal, UxmalCSRF} from "laravel-uxmal-npm";
import Echo from '@ably/laravel-echo';
import * as Ably from 'ably';

window.Ably = Ably;
window.Echo = new Echo({
    broadcaster: 'ably',
});

window.Echo.connector.ably.connection.on((stateChange) => {
    console.log("LOGGER:: Connection event :: ", stateChange);
    if (stateChange.current === 'disconnected' && stateChange.reason?.code === 40142) { // key/token status expired
        console.log("LOGGER:: Connection token expired https://help.ably.io/error/40142");
    }
});


document.addEventListener('livewire:initialized', () => {
    Livewire.hook('request', ({uri, options, succeed}) => {
        succeed(({status, json}) => {
            if (status === 200 && json.components) {
                Array.from(json.components).forEach((item) => {
                    const component = JSON.parse(item.snapshot);
                    if (!window.livewireEvents.get(component.checksum)) {
                        window.livewireEvents.set(component.checksum, true);
                        console.log('workshop.js Dispatch ===> ', 'livewire:' + component.memo.name + ':request:succeed')
                        document.dispatchEvent(new CustomEvent('livewire:' + component.memo.name + ':request:succeed', {detail: component.memo}))
                    }
                })
            }
        })
    });
});

/**
 * @param order_id
 * @param data
 * @param onsuccess_callback
 * @param onfail_callback
 * @param onwarning_callback
 */
export const apiPutOrder = (order_id, data, onsuccess_callback = (data) => {
    uxmal.alert(data.ok, 'success');
}, onfail_callback = (data) => {
    uxmal.alert(data.fail, 'danger');
}, onwarning_callback = (data) => {
    uxmal.alert(data.warning, 'warning');
}) => {
    const api_put_order_url = uxmal.buildRoute('api_put_order', order_id);
    fetch(api_put_order_url, {
        method: 'PUT', // or 'PUT' if you're updating
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': UxmalCSRF()
        },
        body: JSON.stringify(data),
    }).then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    }).then(data => {
        if (data.ok) {
            onsuccess_callback(data);
        } else if (data.fail) {
            onfail_callback(data);
        } else if (data.warning) {
            onwarning_callback(data);
        }
    }).catch(error => {
        onfail_callback({fail: error.message});
    });
};

/**
 *
 * @param order_id
 * @param opd_id
 * @param data
 * @param onsuccess_callback
 * @param onwarning_callback
 * @param onfail_callback
 */
export const apiPutOrderProductDynamic = (order_id, opd_id, data, onsuccess_callback = (data) => {
    uxmal.alert(data.ok, 'success');
}, onwarning_callback = (data) => {
    uxmal.alert(data, 'warning');
}, onfail_callback = (data) => {
    uxmal.alert(data, 'danger');
}) => {
    const api_put_order_product_dynamic_url = uxmal.buildRoute('api_put_order_product_dynamic', order_id, opd_id);
    fetch(api_put_order_product_dynamic_url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': UxmalCSRF()
        },
        body: JSON.stringify(data),
    }).then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    }).then(data => {
        if (data.ok) {
            onsuccess_callback(data);
        } else if (data.fail) {
            onfail_callback(data);
        } else if (data.warning) {
            onwarning_callback(data);
        }
    }).catch(error => {
        onfail_callback({fail: error.message});
    });
};

/**
 *
 * @param length
 * @returns {string}
 */
export function generateRandomString(length) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

export const uxmal = new Uxmal();

window.livewireEvents = new Map();

