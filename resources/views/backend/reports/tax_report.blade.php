@extends('backend.layouts.app')

@section('content')
<div class="card">
    <form class="" action="" method="GET" id="sortorders">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Taxes') }}</h5>
            </div>
           
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
        </div>
    </form>
    <div class="card-body overflow-auto">
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="totaltax" onclick="toggleNav('totaltax')">
                    <p class="text-title-thin text-uppercase">Total Tax</p>
                    <div>
                        <span class="fw-600 fs-18">₱0.00</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="ordertax" onclick="toggleNav('ordertax')">
                    <p class="text-title-thin text-uppercase">Order Tax</p>
                    <div>
                        <span class="fw-600 fs-18">₱0.00</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="shippingtax" onclick="toggleNav('shippingtax')">
                    <p class="text-title-thin text-uppercase">Shipping Tax</p>
                    <div>
                        <span class="fw-600 fs-18">₱0.00</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="p-4 lightgray-bg rounded shadow-sm overflow-hidden mw-100 text-left mb-3" id="orders" onclick="toggleNav('orders')">
                    <p class="text-title-thin text-uppercase">Orders</p>
                    <div>
                        <span class="fw-600 fs-18">0</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="totaltax-content">
            <div class="card-header">
                 <span class="fw-600">
                    Total Tax
                 </span>
            </div>
             <div class="card-body overflow-auto">
                <canvas id="totaltaxChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
        </div>
        <div class="card" id="ordertax-content">
            <div class="card-header">
                <span class="fw-600">
                    Order Tax
                </span>
            </div>
            <div class="card-body overflow-auto">
                <canvas id="ordertaxChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
            </div>
        </div>
 
        <div class="card" id="shippingtax-content">
             <div class="card-header">
                 <span class="fw-600">
                     Shipping Tax
                 </span>
             </div>
             <div class="card-body overflow-auto">
                <canvas id="shippingtaxChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
             </div>
         </div>

         <div class="card" id="orders-content">
            <div class="card-header">
                <span class="fw-600">
                    Orders
                </span>
            </div>
            <div class="card-body overflow-auto">
                <canvas id="orderChart" class="d-flex justify-content-center w-100" width="1000" height="500">
                </canvas>
            </div>
        </div>

        <table class="table aiz-table mb-0" id="allordersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tax Code</th>
                    <th>Rate</th>
                    <th>Total Tax</th>
                    <th>Order Tax</th>
                    <th>Shipping Tax</th>
                    <th>Orders</th>
                </tr>
            </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
        </table>
        <div class="aiz-pagination">
            
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
    <script>

        $(document).ready(function () {
            $('#totaltax').addClass('navtab-active');
            $('#ordertax-content').toggle(false)
            $('#shippingtax-content').toggle(false)
            $('#orders-content').toggle(false)
        });

        function toggleNav(id) {
            if (id == 'totaltax') {
                $('#totaltax').addClass('navtab-active');
                $('#ordertax').removeClass('navtab-active');
                $('#shippingtax').removeClass('navtab-active');
                $('#orders').removeClass('navtab-active');

                $('#totaltax-content').toggle(true)
                $('#ordertax-content').toggle(false)
                $('#shippingtax-content').toggle(false)
                $('#orders-content').toggle(false)
            }

            else if (id == 'ordertax') {
                $('#totaltax').removeClass('navtab-active');
                $('#ordertax').addClass('navtab-active');
                $('#shippingtax').removeClass('navtab-active');
                $('#orders').removeClass('navtab-active');

                $('#totaltax-content').toggle(false)
                $('#ordertax-content').toggle(true)
                $('#shippingtax-content').toggle(false)
                $('#orders-content').toggle(false)
            }

            else if (id == 'shippingtax') {
                $('#totaltax').removeClass('navtab-active');
                $('#ordertax').removeClass('navtab-active');
                $('#shippingtax').addClass('navtab-active');
                $('#orders').removeClass('navtab-active');

                $('#totaltax-content').toggle(false)
                $('#ordertax-content').toggle(false)
                $('#shippingtax-content').toggle(true)
                $('#orders-content').toggle(false)
            }

            else if (id == 'orders') {
                $('#totaltax').removeClass('navtab-active');
                $('#ordertax').removeClass('navtab-active');
                $('#shippingtax').removeClass('navtab-active');
                $('#orders').addClass('navtab-active');

                $('#totaltax-content').toggle(false)
                $('#ordertax-content').toggle(false)
                $('#shippingtax-content').toggle(false)
                $('#orders-content').toggle(true)
            }
        }

    var totaltax = document.getElementById('totaltaxChart').getContext('2d'); 
    var totaltaxChart = new Chart(totaltax, {

        type: 'line',
        data: {
            labels: ['April 1', 'April 2', 'April 3', 'April 4', 'April 5', 'April 6'],
            datasets: [{
                label: 'Total Taxes',
                data: [130, 201, 307, 455, 212, 133],
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ordertax = document.getElementById('ordertaxChart').getContext('2d'); 
    var ordertaxChart = new Chart(ordertax, {

        type: 'line',
        data: {
            labels: ['April 1', 'April 2', 'April 3', 'April 4', 'April 5', 'April 6'],
            datasets: [{
                label: 'Order Taxes',
                data: [130, 201, 307, 455, 212, 133],
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var shippingtax = document.getElementById('shippingtaxChart').getContext('2d'); 
    var shippingtaxChart = new Chart(shippingtax, {

        type: 'line',
        data: {
            labels: ['April 1', 'April 2', 'April 3', 'April 4', 'April 5', 'April 6'],
            datasets: [{
                label: 'Shipping Taxes',
                data: [130, 201, 307, 455, 212, 133],
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var orders = document.getElementById('orderChart').getContext('2d'); 
    var orderChart = new Chart(orders, {

        type: 'line',
        data: {
            labels: ['April 1', 'April 2', 'April 3', 'April 4', 'April 5', 'April 6'],
            datasets: [{
                label: 'Orders',
                data: [130, 201, 307, 455, 212, 133],
                backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
					],
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
@endsection
