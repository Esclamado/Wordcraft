@extends('backend.layouts.app')

@section('content')
<div class="card">
    <form class="" action="" method="GET" id="sortorders">
        <div class="card-header row gutters-5">
            <div class="col text-center text-md-left">
                <h5 class="mb-md-0 h6">{{ translate('Stocks') }}</h5>
            </div>

            <div class="col-lg-2">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0">
                    <option value="">{{ translate('Filter by') }}</option>
                    <option value="">{{translate('All Products')}}</option>
                    <option value="">{{translate('Out of Stocks')}}</option>
                    <option value="">{{translate('Low Stocks')}}</option>
                    <option value="">{{translate('In Stocks')}}</option>
                    <option value="">{{translate('On Backorders')}}</option>
                </select>
            </div>
           
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="" name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
        </div>
    </form>
    <div class="card-body overflow-auto">
        <div class="float-right">
            <a href="">
                <svg xmlns="http://www.w3.org/2000/svg"   width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download mr-1">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Download Stocks Table
            </a>
        </div>
        <table class="table aiz-table mb-0" id="allordersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product/Variation</th>
                    <th>SKU</th>
                    <th>Status</th>
                    <th width="10%" class="text-right">No. of Stocks</th>
                </tr>
            </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>LNS Racks</td>
                        <td>RACKS12345</td>
                        <td>In Stock</td>
                        <td class="text-right">23</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>LNS Chairs</td>
                        <td>CHAIRS67890</td>
                        <td>In Stock</td>
                        <td class="text-right">56</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>LNS Racks</td>
                        <td>RACKS12345</td>
                        <td>In Stock</td>
                        <td class="text-right">23</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>LNS Chairs</td>
                        <td>CHAIRS67890</td>
                        <td>In Stock</td>
                        <td class="text-right">56</td>
                    </tr>
                </tbody>
        </table>
        <div class="aiz-pagination">
            
        </div>
    </div>
</div>
@endsection
