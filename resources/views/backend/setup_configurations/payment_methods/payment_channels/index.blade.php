@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Payment Channels') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('payment-channels.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add new payment channel') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0 h6">{{ translate('All payment channels') }}</h5>
            <div class="pull-right clearfix">
                <form class="" action="" id="sort_payment_channels" method="GET">
                    <div class="box-inline pad-rgt pull-left">
                        <div style="min-width: 200px">
                            <input type="text" class="form-control" id="search" name="search" @isset ($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & enter') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body overflow-auto">
            <table class="table aiz-table mb-0" id="paymentchannelTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th onclick="sortTable(1)" class="c-pointer">
                            <span class="default">
                                <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                    <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                </svg>
                            </span>
                            {{ translate('Payment Method') }}
                        </th>
                        <th onclick="sortTable(2)" class="c-pointer"><span class="default">
                            <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                            </svg>
                        </span>
                        {{ translate('Name') }}
                    </th>
                        <th>{{ translate('Image') }}</th>
                        <th>{{ translate('Value') }}</th>
                        <th>{{ translate('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payment_channels as $key => $value)
                        <tr>
                            <td>{{ ($key + 1) + ($payment_channels->currentPage() - 1) * $payment_channels->perPage() }}</td>
                            <td>{{ $value->payment_method->name }}</td>
                            <td>{{ $value->name }}</td>
                            <td>
                                <img src="{{ uploaded_asset($value->image) }}" height="35" width="35" alt="{{ $value->name }}">
                            </td>
                            <td>{{ $value->value }}</td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
        							<input onchange="update_status(this)" value="{{ $value->id }}" type="checkbox" <?php if($value->status == 1) echo "checked";?> >
        							<span class="slider round"></span>
        						</label>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $payment_channels->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
    function update_status(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('payment_channels.update_status') }}', {_token:'{{ csrf_token() }}', id: el.value, status: status}, function(data) {
            if(data == 1){
                AIZ.plugins.notify('success', '{{ translate('Payment channel status changed') }}');
            }
            else{
                AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
            }
        });
    }

    function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("paymentchannelTable");
            switching = true;
        
            dir = "asc"; 
       
        while (switching) {
            switching = false;
            rows = table.rows;
    
            for (i = 1; i < (rows.length - 1); i++) {
            
            shouldSwitch = false;
            
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
          
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch= true;
                break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
                }
            }
            }
            if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;      
            } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
            }
        }
        }
    </script>
@endsection
