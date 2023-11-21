<?php

namespace App\Http\Controllers;

use Enmaca\LaravelUxmal\Components\Livewire;
use Enmaca\LaravelUxmal\Components\Ui\Dropzone;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Support\Helpers\BuildRoutesHelper;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\LivewireOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\DropzoneOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;

class Test extends Controller
{
    //

    /**
     * @throws \Exception
     */
    public function test()
    {


        $deleteButton = new ButtonOptions(
            name: 'delete'.bin2hex(random_bytes(3)),
            style: 'danger',
            type: 'icon',
            appendAttributes: [
                'data-workshop-opd-delete' => true
            ],
            remixIcon: 'delete-bin-5-line'
        );

        dd($deleteButton->toArray());

        View::startPush('scripts', '<script src="' . Vite::asset('resources/js/test/test.js', 'workshop') . '" type="module"></script>');


        return view('uxmal::simple-default', [
            'uxmal_data' => $uxmal->toArray()
        ])->extends('uxmal::layout.simple');
    }

}