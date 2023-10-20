<?php

namespace App\Support\UxmalComponents;


class BaseTomSelect extends \Enmaca\LaravelUxmal\Abstract\SelectTomSelect
{

    protected $Model;
    protected $Options;

    /**
     * @return void
     * @throws \Exception
     */
    public function build(): void
    {
        $uxmal = new \Enmaca\LaravelUxmal\Uxmal();

        $rows = $this->Model::orderBy('created_at', 'desc')->take(25)->get();

        $items = [];

        foreach( $rows as $row )
            $items[$row->hashId] = "{$row->name}";


        $options = $this->Options + [
            'tomselect.options' => $items,
            ];

        $this->_content = $uxmal->component('form.select.tomselect', [
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