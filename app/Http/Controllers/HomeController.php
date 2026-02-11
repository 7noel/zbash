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
        $sql = "SELECT
  i.id                       AS item_id,
  i.name,
  i.second_name,
  i.description,
  i.unit_type_id,
  i.model,
  i.factory_code,
  i.barcode,
  i.technical_specifications,
  i.item_type_id,
  i.internal_id,
  i.item_code,
  i.currency_type_id,
  i.sale_unit_price,

  p1.unit_type_id            AS p1_unit_type_id,
  p1.quantity_unit           AS p1_quantity_unit,
  p1.price1                  AS p1_price1,
  p1.price2                  AS p1_price2,
  p1.price3                  AS p1_price3,
  p1.price_default           AS p1_price_default,

  p2.unit_type_id            AS p2_unit_type_id,
  p2.quantity_unit           AS p2_quantity_unit,
  p2.price1                  AS p2_price1,
  p2.price2                  AS p2_price2,
  p2.price3                  AS p2_price3,
  p2.price_default           AS p2_price_default,

  p3.unit_type_id            AS p3_unit_type_id,
  p3.quantity_unit           AS p3_quantity_unit,
  p3.price1                  AS p3_price1,
  p3.price2                  AS p3_price2,
  p3.price3                  AS p3_price3,
  p3.price_default           AS p3_price_default

FROM items i
LEFT JOIN (
  SELECT t.* FROM (
    SELECT iut.*,
           ROW_NUMBER() OVER (PARTITION BY iut.item_id ORDER BY iut.factor_default DESC, iut.id ASC) AS rn
    FROM item_unit_types iut
  ) t
  WHERE t.rn = 1
) p1 ON p1.item_id = i.id
LEFT JOIN (
  SELECT t.* FROM (
    SELECT iut.*,
           ROW_NUMBER() OVER (PARTITION BY iut.item_id ORDER BY iut.factor_default DESC, iut.id ASC) AS rn
    FROM item_unit_types iut
  ) t
  WHERE t.rn = 2
) p2 ON p2.item_id = i.id
LEFT JOIN (
  SELECT t.* FROM (
    SELECT iut.*,
           ROW_NUMBER() OVER (PARTITION BY iut.item_id ORDER BY iut.factor_default DESC, iut.id ASC) AS rn
    FROM item_unit_types iut
  ) t
  WHERE t.rn = 3
) p3 ON p3.item_id = i.id;
";

        $models = \DB::connection('facturador')->select($sql);

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

            //Calculando precio a imprimir
            $itemUnit = (string)($model['unit_type_id'] ?? '');
            $printPrice = null;

            foreach ([1, 2, 3] as $p) {

                $pUnit = $model["p{$p}_unit_type_id"] ?? null;

                if (empty($pUnit) || (string)$pUnit !== $itemUnit) {
                    continue;
                }

                $def = (int)($model["p{$p}_price_default"] ?? 1);
                if ($def < 1 || $def > 3) $def = 1;

                $price = $model["p{$p}_price{$def}"] ?? null;

                if ($price !== null && $price !== '' && is_numeric($price)) {
                    $printPrice = (float)$price;
                    break; // ya encontramos precio válido
                }
            }

            if ($printPrice === null) {
                $fallback = $model['sale_unit_price'] ?? null;
                $printPrice = (is_numeric($fallback) ? (float)$fallback : null);
            }

            $payload = [
                'item_id' => $model['item_id'] ?? null,
                'name' => mb_strtoupper($model['name'], 'UTF-8') ?? null,
                'second_name' => mb_strtoupper($model['second_name'], 'UTF-8') ?? null,
                'description' => mb_strtoupper($model['description'], 'UTF-8') ?? null,
                'unit_type_id' => $model['unit_type_id'] ?? null,
                'model' => mb_strtoupper($model['model'], 'UTF-8') ?? null,
                'factory_code' => mb_strtoupper($model['factory_code'], 'UTF-8') ?? null,
                'barcode' => $model['barcode'], 'UTF-8' ?? null,
                'technical_specifications' => $model['technical_specifications'] ?? null,
                'item_type_id' => $model['item_type_id'] ?? null,
                'internal_id' => $model['internal_id'] ?? null,
                'item_code' => $model['item_code'] ?? null,
                'tienda_url' => env('TIENDA_URL').$model['item_id'],
                'currency_type_id' => $model['currency_type_id'] ?? null,
                'sale_unit_price' => $model['sale_unit_price'] ?? null,

                // P1
                'p1_unit_type_id' => $model['p1_unit_type_id'] ?? null,
                'p1_quantity_unit' => $model['p1_quantity_unit'] ?? null,
                'p1_price1' => $model['p1_price1'] ?? null,
                'p1_price2' => $model['p1_price2'] ?? null,
                'p1_price3' => $model['p1_price3'] ?? null,
                'p1_price_default' => $model['p1_price_default'] ?? null,

                // P2
                'p2_unit_type_id' => $model['p2_unit_type_id'] ?? null,
                'p2_quantity_unit' => $model['p2_quantity_unit'] ?? null,
                'p2_price1' => $model['p2_price1'] ?? null,
                'p2_price2' => $model['p2_price2'] ?? null,
                'p2_price3' => $model['p2_price3'] ?? null,
                'p2_price_default' => $model['p2_price_default'] ?? null,

                // P3
                'p3_unit_type_id' => $model['p3_unit_type_id'] ?? null,
                'p3_quantity_unit' => $model['p3_quantity_unit'] ?? null,
                'p3_price1' => $model['p3_price1'] ?? null,
                'p3_price2' => $model['p3_price2'] ?? null,
                'p3_price3' => $model['p3_price3'] ?? null,
                'p3_price_default' => $model['p3_price_default'] ?? null,
                'print_price' => $printPrice,
            ];

            for ($i = 0; $i < $cantidad; $i++) {
                Barcode::create($payload);
                $contador++;
            }
        }
        return redirect()->route('codbars');
    }

}
