@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<h5 class="{{ config('options.styles.card_header') }}">Código de barras - Preparación de etiquetas</h5>
				<div class="card-body">
					<div class="form-group row">
                        <label for="search" class="col-sm-2 col-form-label">Filtro</label>
						<div class="col-sm-8">
                            <input class="form-control form-control-sm" onkeyup="filtro_tabla('table-report')" placeholder="Buscar por Codigo o Descripción" name="search" type="text" value="" id="search">
                        </div>
                        <div class="col-sm-2">
                        	{!! Form::open(['route'=> ['products.codbars_save'], 'method'=>'POST', 'id'=>"form-codbar-save"]) !!}
                            <button type="submit" class="btn btn-sm btn-outline-primary" id="btn-codbar-save">{!! $icons['db'] !!} Guardar</button>
                            {!! Form::close() !!}
                        </div>
                    </div>

					<table class="table table-hover table-sm">
					    <thead>
					        <tr>
					        	<th>Cantidad</th>
					            <th class="text-center">Código</th>
					            <th>Descripcion</th>
					            <th class="text-center">Unidad</th>
					            <th class="text-center">BarCode</th>
					        </tr>
					    </thead>
					    <tbody id="table-report">
							@foreach($models as $model)
							<tr
								style="display: none;"
								data-item_id="{{ $model->item_id }}"
								data-name="{{ $model->name }}"
								data-second_name="{{ $model->second_name }}"
								data-description="{{ $model->description }}"
								data-unit_type_id="{{ $model->unit_type_id }}"
								data-model="{{ $model->model }}"
								data-factory_code="{{ $model->factory_code }}"
								data-barcode="{{ $model->barcode }}"
								data-technical_specifications="{{ $model->technical_specifications }}"
								data-item_type_id="{{ $model->item_type_id }}"
								data-internal_id="{{ $model->internal_id }}"
								data-item_code="{{ $model->item_code }}"
								data-currency_type_id="{{ $model->currency_type_id }}"
								data-sale_unit_price="{{ $model->sale_unit_price }}"
								
								{{-- P1 --}}
							    data-p1_unit_type_id="{{ $model->p1_unit_type_id }}"
							    data-p1_quantity_unit="{{ $model->p1_quantity_unit }}"
							    data-p1_price1="{{ $model->p1_price1 }}"
							    data-p1_price2="{{ $model->p1_price2 }}"
							    data-p1_price3="{{ $model->p1_price3 }}"
							    data-p1_price_default="{{ $model->p1_price_default }}"

							    {{-- P2 --}}
							    data-p2_unit_type_id="{{ $model->p2_unit_type_id }}"
							    data-p2_quantity_unit="{{ $model->p2_quantity_unit }}"
							    data-p2_price1="{{ $model->p2_price1 }}"
							    data-p2_price2="{{ $model->p2_price2 }}"
							    data-p2_price3="{{ $model->p2_price3 }}"
							    data-p2_price_default="{{ $model->p2_price_default }}"

							    {{-- P3 --}}
							    data-p3_unit_type_id="{{ $model->p3_unit_type_id }}"
							    data-p3_quantity_unit="{{ $model->p3_quantity_unit }}"
							    data-p3_price1="{{ $model->p3_price1 }}"
							    data-p3_price2="{{ $model->p3_price2 }}"
							    data-p3_price3="{{ $model->p3_price3 }}"
							    data-p3_price_default="{{ $model->p3_price_default }}"
							>
								<td>
									<input type="number" class="form-control form-control-sm text-cantidad-codbar">
								</td>
					            <td class="text-center text-codigo">{{ $model->internal_id }}</td>
					            <td class="text-description">{{ $model->description }}</td>
								<td class="text-center text-unidad">{{ $model->unit_type_id }}</td>
								<td class="text-center text-unidad">{{ $model->barcode }}</td>
							</tr>
							@endforeach
					    </tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>

<script>

$(document).ready(function () {

    $("#btn-codbar-save").click(function(e) {
        e.preventDefault();

        // Limpia inputs previos
        $("#form-codbar-save .input-excel").remove();

        let i = 0;

        $("#table-report tr.select").each(function() {
            const $tr = $(this);
            const cantidad = parseInt($tr.find(".text-cantidad-codbar").val() || 0);

            if (cantidad <= 0) return;

            const data = {
                cantidad: cantidad,

                item_id: $tr.data("item_id"),
                name: $tr.data("name"),
                second_name: $tr.data("second_name"),
                description: $tr.data("description"),
                unit_type_id: $tr.data("unit_type_id"),
                model: $tr.data("model"),
                factory_code: $tr.data("factory_code"),
                barcode: $tr.data("barcode"),
                technical_specifications: $tr.data("technical_specifications"),
                item_type_id: $tr.data("item_type_id"),
                internal_id: $tr.data("internal_id"),
                item_code: $tr.data("item_code"),
                currency_type_id: $tr.data("currency_type_id"),
                sale_unit_price: $tr.data("sale_unit_price"),

                // P1
                p1_unit_type_id: $tr.data("p1_unit_type_id"),
                p1_quantity_unit: $tr.data("p1_quantity_unit"),
                p1_price1: $tr.data("p1_price1"),
                p1_price2: $tr.data("p1_price2"),
                p1_price3: $tr.data("p1_price3"),
                p1_price_default: $tr.data("p1_price_default"),

                // P2
                p2_unit_type_id: $tr.data("p2_unit_type_id"),
                p2_quantity_unit: $tr.data("p2_quantity_unit"),
                p2_price1: $tr.data("p2_price1"),
                p2_price2: $tr.data("p2_price2"),
                p2_price3: $tr.data("p2_price3"),
                p2_price_default: $tr.data("p2_price_default"),

                // P3
                p3_unit_type_id: $tr.data("p3_unit_type_id"),
                p3_quantity_unit: $tr.data("p3_quantity_unit"),
                p3_price1: $tr.data("p3_price1"),
                p3_price2: $tr.data("p3_price2"),
                p3_price3: $tr.data("p3_price3"),
                p3_price_default: $tr.data("p3_price_default"),
            };

            Object.keys(data).forEach(key => {
                $("#form-codbar-save").append(
                    `<input class="input-excel" type="hidden" name="products[${i}][${key}]" value="${escapeHtml(String(data[key] ?? ''))}">`
                );
            });

            i++;
        });

        $("#form-codbar-save").submit();
    });

    // Event delegation (por si en algún momento cambias cómo renderizas filas)
    $(document).on("change", ".text-cantidad-codbar", function () {
        const $tr = $(this).closest("tr");
        const val = parseFloat($(this).val() || 0);
        $tr.toggleClass("select", val > 0);
    });

});

// Escapar para evitar romper el HTML si hay comillas, etc.
function escapeHtml(str) {
  return str
    .replaceAll("&", "&amp;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;");
}



function filtro_tabla(table_report_warehouse) {
  // Declare variables 
  var input, filter, table, tr, td, i, j, visible;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  size = filter.length
  table = document.getElementById(table_report_warehouse);
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    visible = false;
    /* Obtenemos todas las celdas de la fila, no sólo la primera */
    td = tr[i].getElementsByTagName("td");
    for (j = 0; j < td.length; j++) {
      if (size>3 && td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
        visible = true;
      }
    }
    if (visible === true) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
  }
}


</script>

@endsection