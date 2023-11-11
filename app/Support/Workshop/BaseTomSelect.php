<?php

namespace App\Support\Workshop;

use Enmaca\LaravelUxmal\Abstract\SelectTomSelectBlock;
use Enmaca\LaravelUxmal\UxmalComponent;

class BaseTomSelect extends SelectTomSelectBlock
{

    protected string $Model;
    protected array $Options;

    /**
     * @return void
     * @throws \Exception
     */
    public function build(): void
    {
        $rows = $this->Model::orderBy('created_at', 'desc')->take(25)->get();

        $items = [];

        foreach( $rows as $row )
            $items[$row->hashId] = "{$row->name}";


        $options = $this->Options + [
            'tomselect.options' => $items,
            ];

        $this->_content = UxmalComponent::Make('form.select.tomselect', [
            'options' => $options
        ]);
    }
    /**
     * @param string $query
     * @return array
     */
    public function search(string $query): array
    {
        $rows = $this->Model::query()
            ->where('name', 'like', "%{$query}%")
            ->select([
                'id',
                'name'
            ])
            ->get();

        $items = [];

        foreach ( $rows as $row ){
            $items[] = [
                'value' => $row->hashId,
                'label' => "{$row->name}"
            ];
        }

        return [
            'incomplete_results' => false,
            'items' => $items,
            'total_count' => count($items)
        ];
    }

    /**
     * @param mixed $data
     * @return void
     */
    public function create(mixed $data): void
    {
    }
}