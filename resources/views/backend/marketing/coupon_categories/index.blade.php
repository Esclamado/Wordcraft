@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Coupon Categories') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('coupon-categories.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Coupon Category') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Coupon Category Information') }}</h5>
        </div>
        <div class="card-body overflow-auto">
            <table class="table aiz-table p-0" id="couponTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Status') }}</th>
                        <th>{{ translate('Description') }}</th>
                        <th>{{ translate('Created at') }}</th>
                        <th>{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupon_categories as $key => $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_status(this)" value="{{ $item->id }}" type="checkbox" {{ $item->status == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>{{ $item->description }}</td>
                            <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                            <td>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('coupon-categories.edit', $item->id) }}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('coupon-categories.destroy', $item->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $coupon_categories->links() }}
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function update_status (el) {
            if (el.checked) {
                var status = 1;
            }

            else {
                var status = 0;
            }

            $.post('{{ route('coupon-categories.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Status updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection