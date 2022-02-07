@extends('frontend.layouts.app')

@section('content')
  <div class="profile py-5">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 mx-auto">
                <div class="position-absolute">
                    <div class="img-1"></div>
                    <div class="img-2"></div>
                    <div class="img-3"></div>
                    <div class="img-4"></div>
                </div>
                <div class="card">
                    <div class="text-center pt-4">
                        <h1 class="h4 header-title">
                            {{ translate('Store Sign In')}}
                        </h1>
                    </div>

                    
                    <div class="text-center mb-5 mt-4">
                      <form id="StoreForm" action="{{ route('walkin.compare_staff_id')}}" method="POST">
                        @csrf
                        <div class="text-center form-group">
                          <input id="compare_email" name="compare_email" placeholder="Coordinator Email" style="width: 273px; height: 42px">
                        </div>
                        <div class="text-center form-group">
                          <input id="password" name="password" type="password" placeholder="Password" style="width: 273px; height: 42px">
                        </div>
                        <!-- <select id="store_id" name="store_id" style="width: 180px; height: 42px">
                            <option value="null">--</option>
                          @foreach($store as $data)
                            <option value="{{json_encode($data)}}">{{$data->name}}</option>
                          @endforeach
                        </select> -->
                        <button  type="submit" class="btn btn-primary">Submit</button>
                        <!-- <button onclick="submitLocation()" type="sub" class="btn btn-primary">Submit</button> -->
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection

<script>
  // function submitLocation(){
  //   var e = document.getElementById("store_id");
  //   var strData = e.value;
  //   console.log('ewqeqw',strData); 
  //   // if(strData == 'null'){
  //   //   alert('Please select store!');
  //   // }else{
  //     // localStorage.setItem("store_data", strData);
  //     var now = new Date();
  //     var time = now.getTime();
  //     var expireTime = time + 1000*36000;
  //     now.setTime(expireTime);
  //     document.cookie = 'store_data='+strData+';expires='+now.toUTCString()+';path=/';
  //     document.getElementById("StoreForm").submit();
  //     event.preventDefault();
  //   // }
  // }

</script>