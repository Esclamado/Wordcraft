@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Defective Items')}}</h1>
		</div>
	</div>
</div>
<div class="card">
    <div class="card-body overflow-auto">
        <table class="table aiz-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Quantity</th>
                    <th>PUP Store</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($defective_list as $defective)
                 <tr>
                    <td>{{ $defective->pname }}</td>
                    <td>{{ $defective->sku }}</td>
                    <td>{{ $defective->defective_qty }}</td>
                    <td>{{ $defective->ppname }}</td>
                </tr> 
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination mb-4 mt-5 d-flex justify-content-center">
            {{ $defective_list->appends(request()->input())->links() }}
        </div>

    </div>
</div>
@endsection