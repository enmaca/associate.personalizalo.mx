import {uxmal} from '../create.js';

export const dynamicCardFunctionsInit = () => {
    const updatePaymentPriceData = (price) => {
        const order_payment_amount = parseFloat(uxmal.Inputs.get('orderPaymentAmountId').element.value);
        currentPrice = (parseFloat(price) - order_payment_amount).toFixed(2);
        currentPriceDiv2 = (currentPrice / 2).toFixed(2);
    };

    const checkPayment = () => {
        const order_payment_status = uxmal.Inputs.get('orderPaymentStatusId').element;
        const advance_payment_50 = uxmal.Inputs.get('advance_payment_50Id').element;
        if (order_payment_status.value === 'completed') {
            updateOrderAmount(0);
        } else if (advance_payment_50.checked) {
            updateOrderAmount(currentPriceDiv2);
        } else {
            updateOrderAmount(currentPrice);
        }
    }

    uxmal.Inputs.on('advance_payment_50Id', 'change', () => {
        checkPayment();
    });


    let currentPrice = 0;
    let currentPriceDiv2 = 0;
    const updateOrderAmount = (price) => {
        console.log('updateOrderAmount', price);
        uxmal.Inputs.setValue('amountId', price);
    };

    //// Process the click on payment button
    document.getElementById("addPaymentFormButtonId").onclick = function () {
        if (parseFloat(uxmal.Inputs.get('amountId').element.value) === 0)
            return;

        uxmal.Cards.setLoading('orderCard', true);
        uxmal.Forms.submit('addPaymentForm', {
            order_id: window.order_id,
            customer_id: window.customer_id
        }, () => {
            Livewire.dispatch('order-payment-data.form::reload');
            uxmal.Cards.setLoading('orderCard', false);
        }, (elementName, data) => {
            uxmal.sweetAlert(data.fail, 'warning');
            uxmal.Cards.setLoading('orderCard', false);
        }, (elementName, error) => {
            uxmal.sweetAlert(error.message, 'danger');
            uxmal.Cards.setLoading('orderCard', false);
        });
    };

    //// Listen To Event When Livewire Request Succed on Table OrderPaymentData
    document.addEventListener('livewire:order-payment-data.form:request:succeed', () => {
        setTimeout(() => {
            uxmal.Forms.init(document.querySelector('[data-uxmal-card-name="paymentCard"]'));
            checkPayment();
        }, 500);
    });
}