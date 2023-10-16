console.log('resources/js/order/root.js Loaded')
window.createOrder = () => {
    console.log('createOrder Executed');
}

window.setValueDE = (selector, value, enable) => {
    let inputE = document.querySelector(selector);
    inputE.value = value;
    inputE.disabled = !enable;
}

window.goToOrder = ( order_id ) => {
    window.location.href = '/orders/' + order_id;
}

window.submitNewOrderFrom = () => {
    document.getElementById('NewOrderFrom').submit();
}

document.getElementById('customerMobileId').addEventListener('change', (event)  => {
    event.preventDefault();
    console.log('inputChange');
});


