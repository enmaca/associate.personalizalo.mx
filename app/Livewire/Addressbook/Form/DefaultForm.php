<?php

namespace App\Livewire\Addressbook\Form;

use App\Models\Order;
use App\Support\Workshop\AddressBook\DefaultForm as AddressBookDefaultForm;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use Exception;

class DefaultForm extends Component
{
    public int $request_id = 0;
    public $order_id;

    public function mount($order_id): void
    {
        $this->order_id = $order_id;
    }

    /**
     * @throws Exception
     */
    #[On('addressbook.form.default-form::reload')]
    public function reload(): void
    {
        $this->request_id++;
    }

    /**
     * @throws Exception
     */
    public function render(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $order_id = Order::keyFromHashId($this->order_id);
        $order_data = Order::with('address')->find($order_id);

        $addres_data = $order_data->toArray();
        $addres_data['shipment_status'] = $order_data->shipment_status ?? '';

        $uxmal = AddressBookDefaultForm::Object(
            values: $addres_data ?? [],
            options: [
                'form.id' => 'deliveryData',
                'form.action' => route('api_put_order_delivery_data', $this->order_id),
                'form.method' => 'put'
            ]
        );

        return view('uxmal::livewire', ['data' => $uxmal->toArray()]);
    }
}
