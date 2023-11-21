import {uxmal} from "../create.js";
import {mfg_over_head_form_id} from "../create.js";

export const dynamicCardMFGOverCode = () => {
    uxmal.Modals.on('selectedMfgOverHeadToAddToOrderId', 'shown.bs.modal', function () {
        uxmal.Selects.get('mfgOverHeadSelectedId').tomselect2.setValue('', true);
        uxmal.Cards.setLoading('orderCard', false);
        mfg_over_head_form_id = uxmal.Forms.init(this);
        uxmal.Forms.onChild(mfg_over_head_form_id, '#mfgOverheadQuantityId', 'change', (event) => {
            let mfgQtyEl = event.target;
            let tax_data = Number(mfgQtyEl.getAttribute('data-tax-factor'));
            let uom = Number(mfgQtyEl.getAttribute('data-value'));
            document.getElementById('mfgOverheadSubtotalId').value = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format((mfgQtyEl.value * uom) * (1 + tax_data));
        });
    });
}