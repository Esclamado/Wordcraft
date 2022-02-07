@extends('backend.layouts.app')

@section('content')
  <div class="card">
    <form class="" action="" method="GET" id="sortorders">
      <div class="card-header row gutters-5">
        <div class="col-12">
          <ul class="nav fs-16 fw-600" style="font-style: normal">
            <li class="nav-item">
              <a class="nav-link {{ areActiveRoutes(['cashier.orders'])}}" aria-current="page" href="{{ route('cashier.orders') }}">All Orders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ areActiveRoutes(['cashier.orders.revised'])}}" href="{{ route('cashier.orders.revised') }}">Revised Orders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ areActiveRoutes(['cashier.orders.refunds'])}}" href="{{ route('cashier.orders.refunds') }}">Refunds & Cancellation Requests</a>
            </li>
          </ul>
        </div>

        <div class="d-flex justify-content-center mt-3 mb-3">
          <div class="d-md-flex flex-md-column flex-lg-row">
            <div class="ml-2 mt-2">
                <select select name="payment_status" id="payment_status" class="aiz-selectpicker mb-2 mb-md-0" onchange="sort_orders()">
                    <option value="">{{ translate('Filter by Payment Status') }}</option>
                    <option value="paid" {{ $payment_status == "paid" ? 'selected' : '' }}>{{ translate('Paid') }}</option>
                    <option value="unpaid" {{ $payment_status == "unpaid" ? 'selected' : '' }}>{{ translate('Unpaid') }}</option>
                </select>
            </div>
            <div class="ml-2 mt-2">
                <select select name="request_status" id="request_status" class="aiz-selectpicker mb-2 mb-md-0" onchange="sort_orders()">
                    <option value="">{{ translate('Filter by Request Status') }}</option>
                    <option value="pending" {{ $request_status == "pending" ? 'selected' : '' }}>{{ translate('Pending') }}</option>
                    <option value="approved" {{ $request_status == "approved" ? 'selected' : '' }}>{{ translate('Approved') }}</option>
                </select>
            </div>
            <div class="ml-2 mt-2">
                <select select name="payment_type" id="payment_type" class="aiz-selectpicker mb-2 mb-md-0" onchange="sort_orders()">
                    <option value="">{{ translate('Filter by Payment Method') }}</option>
                    <option value="cash" {{ $payment_type == "cash" ? 'selected' : '' }}>{{ translate('Cash') }}</option>
                    <option value="bank_transfer" {{ $payment_type == "bank_transfer" ? 'selected' : '' }}>{{ translate('Bank Transfer') }}</option>
                </select>
            </div>
          </div>
          <div class="ml-2 mt-2">
              <div class="form-group mb-0" style="width: 300px">
                  <input type="text" class="form-control" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Enter Customer Name or Order ID') }}" oninput="sort_orders()">
              </div>
          </div>
        </div>
      </div>
    </form>

    <div style="padding-right: 28px; padding-left: 28px">
      <table class="table aiz-table" id="allordersTable">
        <thead>
            <tr>
                <th>
                    {{ translate('Order ID') }}
                </th>
                <th>
                    {{ translate('Name') }}
                </th>
                <th>
                    {{ translate('Total') }}
                </th>
                <th>
                    {{ translate('No. of items') }}
                </th>
                <th>
                    {{ translate('Payment Method') }}
                </th>
               <th>
                    {{ translate('Payment Status') }}
                </th>
                <th>
                    {{ translate('Order Status') }}
                </th>
                <th>
                    {{ translate('Request Status') }}
                </th>
                <th>
                    {{ translate('Action') }}
                </th>
            </tr>
        </thead>
        <tbody>
          @foreach ($orders as $key => $order)
              <tr>
                  <td>
                      {{ ($key+1) + ($orders->currentPage() - 1)*$orders->perPage() }}
                  </td>
                  <td>
                      {{ $order->name }}  (<strong>{{ ucfirst($order->user_type) }}</strong>)
                  </td>
                  <td>
                      {{ single_price($order->grand_total) }}
                  </td>
                  <td>
                      {{ \App\OrderDetail::where('order_id', $order->id)->count() }} item/s
                  </td>
                  <td>
                      {{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}
                  </td>
                  <td>
                      @if ($order->payment_status == 'unpaid')
                          <span class="badge-unverfied">{{translate('Unpaid')}}</span>
                      @elseif ($order->payment_status == 'paid')
                          <span class="badge-verified">{{translate('Paid')}}</span>
                      @endif
                  </td>
                  <td>
                        <span class="badge-unverfied">{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</span>
                  </td>
                  <td>
                      @if ($order->request_status == 'pending')
                          <span class="badge-unverfied">{{translate('Pending')}}</span>
                      @elseif ($order->request_status == 'approved')
                          <span class="badge-verified">{{translate('Approved')}}</span>
                      @else
                          <span class="badge-unverfied">{{translate('Pending')}}</span>
                      @endif
                  </td>
                  <td>
                        <a href="{{route('cashier.order.view', encrypt($order->id))}}">
                            {{translate('View Order')}}
                        </a>
                  </td>
              </tr>
          @endforeach
        </tbody>
      </table>
      <div class="aiz-pagination mb-4 mt-5 d-flex justify-content-center">
          {{ $orders->appends(request()->input())->links() }}
      </div>
    </div>
  </div>
@endsection


@section('script')
    <script type="text/javascript">
        function sort_orders(){
            $('#sortorders').submit();
        }
    </script>
@endsection