Livewire.on('order-product-dynamic-details.table.tbody::updated', (data) => {
    console.log('order-product-dynamic-details.table.tbody::updated', data);
    const tableEl = document.querySelector("table[id='orderProductDynamicDetailsId']");
    const oldTfoot = tableEl.querySelector('tfoot');
    if (oldTfoot) {
        oldTfoot.innerHTML = data.tfoot;
    }
});
