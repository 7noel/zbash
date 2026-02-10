<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Barcode;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $models = Product::all();
        return view('products.excel_codbars', compact('models'));
    }

    public function allLinks()
    {
        return [
            'home'          => [],
            'about'         => [],
            'contact-us'    => [],
            'login'         => [],
            'register'      => [],
            'options'       => ['submenu' => [
                                    'about'     => [],
                                    'company'   => []
                                    ],
                                ]
        ];
    }

    public function codbars_save()
    {
        $data = request()->all();
        if (isset($data['products'])) {
            $models = $data['products'];
        } else {
            $models = [];
        }
        $contador = 0;
        Barcode::truncate();
        foreach ($models as $key => $model) {
            $cantidad = (int)($model['cantidad'] ?? 0);
            if ($cantidad <= 0) continue;

            $payload = [
                'item_id' => $model['item_id'] ?? null,
                'name' => $model['name'] ?? null,
                'second_name' => $model['second_name'] ?? null,
                'description' => $model['description'] ?? null,
                'unit_type_id' => $model['unit_type_id'] ?? null,
                'model' => $model['model'] ?? null,
                'factory_code' => $model['factory_code'] ?? null,
                'barcode' => $model['barcode'] ?? null,
                'technical_specifications' => $model['technical_specifications'] ?? null,
                'item_type_id' => $model['item_type_id'] ?? null,
                'internal_id' => $model['internal_id'] ?? null,
                'item_code' => $model['item_code'] ?? null,
            ];

            for ($i = 0; $i < $cantidad; $i++) {
                Barcode::create($payload);
                $contador++;
            }
        }
        return redirect()->route('codbars');
    }

}
