@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">

        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Other payment methods bank details') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('bank_lists.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Create new bank detail') }}</span>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('All other payment methods bank details') }}</h5>
            </div>
            <div class="card-body overflow-auto">
                <table class="table aiz-table mb-0" id="paymentmethodbankdetailTable">
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
                                {{ translate('Parent ID') }}
                            </th>
                            <th>{{ translate('Pickup Point Location') }}</th>
                            <th>{{ translate('Bank Image') }}</th>
                            <th onclick="sortTable(3)" class="c-pointer">
                                 <span class="default">
                                    <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                        <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                    </svg>
                                </span>{{ translate('Bank Name') }}
                            </th>
                            <th onclick="sortTable(4)" class="c-pointer">
                                 <span class="default">
                                    <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                        <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                                    </svg>
                                </span>{{ translate('Bank Account Name') }}
                            </th>
                            <th>{{ translate('Bank Account Number') }}</th>
                            <th>{{ translate('status') }}</th>
                            <th class="text-right">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bank_details as $key => $value)
                            <tr>
                                <td>
                                    {{ ($key + 1) + ($bank_details->currentPage() - 1) * $bank_details->perPage() }}
                                </td>
                                <td>
                                    {{ $value->other_payment_method->name }}
                                </td>
                                <td>
                                    {{ $value->pickup_point->name ?? "N\A" }}
                                </td>
                                <td>
                                    <img src="{{ uploaded_asset($value->bank_image) }}" class="img-fluid" style="height: 40px;" alt="" max-width="100%">
                                </td>
                                <td>
                                    {{ $value->bank_name }}
                                </td>
                                <td>
                                    {{ $value->bank_acc_name }}
                                </td>
                                <td>
                                    {{ $value->bank_acc_number }}
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
        								<input onchange="update_status(this)" value="{{ $value->id }}" type="checkbox" <?php if($value->status == 1) echo "checked";?> >
        								<span class="slider round"></span>
        							</label>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('bank_lists.edit', encrypt($value->id)) }}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('bank_lists.destroy', $value->id) }}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="pull-right">
                        {{ $bank_details->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
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
            $.post('{{ route('bank_lists.update_bank_status') }}', {_token:'{{ csrf_token() }}', id: el.value, status: status}, function(data) {
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Other payment method status updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("paymentmethodbankdetailTable");
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
