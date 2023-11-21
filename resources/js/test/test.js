import {Uxmal, UxmalCSRF} from 'laravel-uxmal-npm';
import 'laravel-uxmal-npm/dist/esm/uxmal.css';

const uxmal = new Uxmal();

uxmal.alert('Welcome to Uxmal!');

document.addEventListener("DOMContentLoaded", function () {
    uxmal.init(document);

    let mockAddedFiles = [];

    document.getElementById('addId').onclick = () => {
        //http://127.0.0.1:8000/api/orders/product_dynamic/ord_B95oKAdVmEJMP
        const api_get_order_product_dynamic_url = uxmal.buildRoute('api_get_order_product_dynamic', 'ord_B95oKAdVmEJMP');
        fetch(api_get_order_product_dynamic_url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': UxmalCSRF()
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            if (data.ok) {
                console.log(data);
                // Update the dropzone url
                const DropzoneObj = uxmal.Dropzones.get('dropzone').dropzone
                DropzoneObj.options.url = '/orders/dynamic_detail/ord_B95oKAdVmEJMP/media';
                DropzoneObj.options.headers = {
                    'X-CSRF-TOKEN': UxmalCSRF()
                };
                if (data.result.media.length > 0) {
                    uxmal.Dropzones.addVirtualFiles('dropzone', data.result.media);
                }

                // Set and load mfgAreaSelectedId.

                // Set and load mfgDevicesSelectedId.
            } else if (data.fail) {
                uxmal.alert(data.fail, 'danger');
            } else if (data.warning) {
                uxmal.alert(data.warning, 'warning');
            }
        }).catch(error => {
            uxmal.alert(error.message, 'danger');
        });
    }

    document.getElementById('removeId').onclick = () => {
        uxmal.Dropzones.removeAllFiles('dropzone');
    }
});
setTimeout(() => {
    uxmal.alert(uxmal.buildRoute('order_delete_product_detail_detail', 'opdd_hashed_id'), 'success');
}, 1000);
