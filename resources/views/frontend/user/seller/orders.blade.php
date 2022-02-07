@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">

                    <div class="card">
                        <form id="sort_orders" action="" method="GET">
                          <div class="card-header row gutters-5">
                            <div class="col text-center text-md-left">
                              <h5 class="mb-md-0 h6">{{ translate('Orders') }}</h5>
                            </div>
                              <div class="col-md-3 ml-auto">
                                  <select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Filter by Payment Status')}}" name="payment_status" onchange="sort_orders()">
                                      <option value="">{{ translate('Filter by Payment Status')}}</option>
                                      <option value="paid" @isset($payment_status) @if($payment_status == 'paid') selected @endif @endisset>{{ translate('Paid')}}</option>
                                      <option value="unpaid" @isset($payment_status) @if($payment_status == 'unpaid') selected @endif @endisset>{{ translate('Un-Paid')}}</option>
                                  </select>
                              </div>

                              <div class="col-md-3 ml-auto">
                                <select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Filter by Payment Status')}}" name="delivery_status" onchange="sort_orders()">
                                    <option value="">{{ translate('Filter by Deliver Status')}}</option>
                                    <option value="order_placed" @isset($delivery_status) @if($delivery_status == 'order_placed') selected @endif @endisset>{{ translate('Order Placed')}}</option>
                                    <option value="confirmed" @isset($delivery_status) @if($delivery_status == 'confirmed') selected @endif @endisset>{{ translate('Confirmed')}}</option>
                                    <option value="processing" @isset($delivery_status) @if($delivery_status == 'processing') selected @endif @endisset>{{ translate('Processing')}}</option>
                                    <option value="partial_release" @isset($delivery_status) @if($delivery_status == 'partial_release') selected @endif @endisset>{{ translate('Partial Release')}}</option>
                                    <option value="ready_for_pickup" @isset($delivery_status) @if($delivery_status == 'ready_for_pickup') selected @endif @endisset>{{ translate('Ready for Pickup')}}</option>
                                    <option value="picked_up" @isset($delivery_status) @if($delivery_status == 'picked_up') selected @endif @endisset>{{ translate('Picked Up')}}</option>
                                </select>
                              </div>
                              <div class="col-md-3">
                                <div class="from-group mb-0">
                                    <input type="text" class="form-control" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                                </div>
                              </div>
                          </div>
                        </form>

                        @if (count($orders) > 0)
                            <div class="card-body p-3">
                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('Order Code')}}</th>
                                            <th data-breakpoints="lg">{{ translate('Num. of Products')}}</th>
                                            <th data-breakpoints="lg">{{ translate('Customer')}}</th>
                                            <th data-breakpoints="md">{{ translate('Amount')}}</th>
                                            <th data-breakpoints="lg">{{ translate('Delivery Status')}}</th>
                                            <th>{{ translate('Payment Status')}}</th>
                                            <th class="text-right">{{ translate('Options')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order_id)
                                            @php
                                                $order = \App\Order::find($order_id->id);
                                            @endphp
                                            @if($order != null)
                                                <tr>
                                                    <td>
                                                        {{ $key+1 }}
                                                    </td>
                                                    <td>
                                                        <a href="#{{ $order->code }}" onclick="show_order_details({{ $order->id }})">{{ $order->code }}</a>
                                                    </td>
                                                    <td>
                                                        {{ count($order->orderDetails->where('seller_id', Auth::user()->id)) }}
                                                    </td>
                                                    <td>
                                                        @if ($order->user_id != null)
                                                            {{ $order->user->name }}
                                                        @else
                                                            Guest ({{ $order->guest_id }})
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ single_price($order->orderDetails->where('seller_id', Auth::user()->id)->sum('price')) }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $status = $order->orderDetails->first()->delivery_status;
                                                        @endphp
                                                        {{ translate(ucfirst(str_replace('_', ' ', $status))) }}
                                                    </td>
                                                    <td>
                                                        @if ($order->orderDetails->where('seller_id', Auth::user()->id)->first()->payment_status == 'paid')
                                                            <span class="badge badge-inline badge-success">{{ translate('Paid')}}</span>
                                                        @else
                                                            <span class="badge badge-inline badge-danger">{{ translate('Unpaid')}}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="javascript:void(0)" class="btn btn-soft-info btn-icon btn-circle btn-sm" onclick="show_order_details({{ $order->id }})" title="{{ translate('Order Details') }}">
                                                            <i class="las la-eye"></i>
                                                        </a>
                                                        <a href="{{ route('seller.invoice.download', $order->id) }}" class="btn btn-soft-warning btn-icon btn-circle btn-sm" title="{{ translate('Download Invoice') }}">
                                                            <i class="las la-download"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="aiz-pagination">
                                	{{ $orders->links() }}
                              	</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('modal')
    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(el){
            $('#sort_orders').submit();
        }
    </script>
@endsection
