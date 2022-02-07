@extends('backend.layouts.app')

@section('content')

  <div class="row">
      <div class="col-lg-8">
          <div class="card">
              <div class="card-body">
                  <table class="table aiz-table mb-0" id="setpointTable">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th onclick="sortTable(1)" class="c-pointer text-center" width="20%">
                                 <span class="default">
                            <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                            </svg>
                        </span>
                                {{translate('Name')}}
                            </th>
                              <th onclick="sortTable(2)" class="c-pointer text-center">
                                 <span class="default">
                            <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                            </svg>
                        </span>
                                {{translate('Product Owner')}}
                            </th>
                              <th onclick="sortAmount(3)" class="c-pointer text-center">
                                 <span class="default">
                            <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                            </svg>
                        </span>
                                {{translate('Num of Sale')}}
                            </th>
                              <th onclick="sortAmount(4)" class="c-pointer text-center">
                                 <span class="default">
                            <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                            </svg>
                        </span>
                                {{translate('Base Price')}}
                            </th>
                              <th onclick="sortTable(5)" class="c-pointer text-center" width="12%">
                                 <span class="default">
                            <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                            </svg>
                        </span>
                                {{translate('Rating')}}
                            </th>
                              <th onclick="sortTable(6)" class="c-pointer text-center" width="12%">
                                 <span class="default">
                            <svg id="Layer" enable-background="new 0 0 64 64" height="18" viewBox="0 0 64 64" width="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="m31.414 15.586-7-7c-.78-.781-2.048-.781-2.828 0l-7 7c-.781.781-.781 2.047 0 2.828.78.781 2.048.781 2.828 0l3.586-3.586v39.172c0 1.104.896 2 2 2s2-.896 2-2v-39.172l3.586 3.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586c.781-.781.781-2.047 0-2.828z"/>
                                <path d="m49.414 45.586c-.781-.781-2.047-.781-2.828 0l-3.586 3.586v-39.172c0-1.104-.896-2-2-2s-2 .896-2 2v39.172l-3.586-3.586c-.781-.781-2.048-.781-2.828 0-.781.781-.781 2.047 0 2.828l7 7c.391.391.902.586 1.414.586s1.023-.195 1.414-.586l7-7c.781-.781.781-2.047 0-2.828z"/>
                            </svg>
                        </span>
                                {{translate('Point')}}
                            </th>
                              <th>{{translate('Options')}}</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($products as $key => $product)
                              <tr>
                                  <td>{{ ($key+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>
                                  <td>
                                      <a href="{{ route('product', $product->slug) }}" target="_blank">
          								<div class="form-group row">
          									<div class="col-md-5">
          										<img src="{{ uploaded_asset($product->thumbnail_img)}}" alt="Image" class="w-50px">
          									</div>
          									<div class="col-md-7">
          										<span class="text-muted">{{ $product->getTranslation('name') }}</span>
          									</div>
          								</div>
          							  </a>
                                  </td>
                                  <td>
                                  @if ($product->user != null)
                                      {{ $product->user->name }}
                                  @endif
                                  </td>
                                  <td>
                                      @php
                                          $qty = 0;
                                          if($product->variant_product){
                                              foreach ($product->stocks as $key => $stock) {
                                                  $qty += $stock->qty;
                                              }
                                          }
                                          else{
                                              $qty = $product->current_stock;
                                          }
                                          echo $qty;
                                      @endphp
                                  </td>
                                  <td>{{ number_format($product->unit_price,2) }}</td>
                                  <td>{{ $product->rating }}</td>
                                  <td>{{ $product->earn_point }}</td>
                                  <td class="text-right">
      								<a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('product_club_point.edit', encrypt($product->id))}}" title="{{ translate('Edit') }}">
      									<i class="las la-edit"></i>
      								</a>
				                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  <div class="aiz-pagination">
                      {{ $products->appends(request()->input())->links() }}
                  </div>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-header">
                      <h5 class="mb-0 h6">{{translate('Set Point for Product Within a Range')}}</h5>
                  </div>
                  <div class="card-body">
                      <div class="form-group row">
                          <small>Set any specific point for those products what are between 'min price' and 'max price'. Min-price should be less than Max-price</small>
                      </div>
                      <form class="form-horizontal" action="{{ route('set_products_point.store') }}" method="POST">
                          @csrf
                          <div class="form-group row">
                              <div class="col-lg-6">
                                  <label class="col-from-label">{{translate('Set Point for multiple products')}}</label>
                              </div>
                              <div class="col-lg-6">
                                  <input type="number" min="0" step="0.01" class="form-control" name="point" placeholder="100" required>
                              </div>
                          </div>
                          <div class="form-group row">
                              <div class="col-lg-6">
                                  <label class="col-from-label">{{translate('Min Price')}}</label>
                              </div>
                              <div class="col-lg-6">
                                  <input type="number" min="0" step="0.01" class="form-control" name="min_price" value="{{ \App\Product::min('unit_price') }}" placeholder="50" required>
                              </div>
                          </div>
                          <div class="form-group row">
                              <div class="col-lg-6">
                                  <label class="col-from-label">{{translate('Max Price')}}</label>
                              </div>
                              <div class="col-lg-6">
                                  <input type="number" min="0" step="0.01" class="form-control" name="max_price" value="{{ \App\Product::max('unit_price') }}" placeholder="110" required>
                              </div>
                          </div>
                          <div class="form-group mb-0 text-right">
                              <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-header">
                      <h5 class="mb-0 h6">{{translate('Set Point for all Products')}}</h5>
                  </div>
                  <div class="card-body">
                      <form class="form-horizontal" action="{{ route('set_all_products_point.store') }}" method="POST">
                          @csrf
                          <div class="form-group row">
                              <div class="col-lg-4">
                                  <label class="col-from-label">{{translate('Set Point For ')}} {{ single_price(1) }}</label>
                              </div>
                              <div class="col-lg-6">
                                  <input type="number" step="0.001" class="form-control" name="point" placeholder="1" required>
                              </div>
                              <div class="col-lg-2">
                                  <label class="col-from-label">{{translate('Points')}}</label>
                              </div>
                          </div>
                          <div class="form-group mb-0 text-right">
                              <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection

@section('script')
 <script>

function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("setpointTable");
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

        function sortAmount(n) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("setpointTable");
            switching = true;
            
            while (switching) {
                
                switching = false;
                rows = table.rows;
                
                for (i = 1; i < (rows.length - 1); i++) {
               
                shouldSwitch = false;
                
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                
                if (Number(x.innerHTML) > Number(y.innerHTML)) {
                   
                    shouldSwitch = true;
                    break;
                }
                }
                if (shouldSwitch) {
               
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                }
            }
        }

</script>   
@endsection