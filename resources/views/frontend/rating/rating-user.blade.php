@extends('frontend.layouts.app')
@section('content')
    <div class="dashboard-wrap">
      <div class="container">
        <div class="row">
          @include('frontend.user.sidebar')
          <div class="col-md-9">
            <div class="dashboard-container">
              <div class="panel panel-default my-order">
                <div class="table-responsive">
                  <table id="example"class="table table-striped table-bordered" width="100%">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Order Id</th>
                        <th>Product Title</th>
                        <th>Image</th>
                        <th width="30%">Rating</th>
                        <th>Comment</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($lists->isNotEmpty())
                        @foreach($lists as $key=> $list)
                        @if(isset($list->product->singleProductImage->image) && !empty($list->product->singleProductImage->image))
                        <?php
                        $info = pathinfo(PRODUCT_ROOT_PATH.$list->product->singleProductImage->image);
                       $ext = $info['extension'];?>
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $list->order_id }}</td>
                            <td>{{ $list->product->title }}</td><td>
                              @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                              @if($list->product->singleProductImage->image !=='' && 
                                File::exists(PRODUCT_ROOT_PATH.$list->product->singleProductImage->image))
                                  <img class="media-object" src="{{ PRODUCT_URL.$list->product->singleProductImage->image }}">
                              @else
                                <img class="media-object" src="{{ WEBSITE_IMG_URL }}no-product-image.png">
                              @endif
                              @else
                              <video width="150px" height="100px" margin-bottom="20px" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                                <source src="{{PRODUCT_URL.$list->product->singleProductImage->image}}" type="video/mp4">
                              </video>
                              @endif
                            <td>
                              <?php $rating= round($list->average_rating);
                              ?>
                              @for($i=1; $i<=$rating;$i++)
                               <div class="rating-stars user">
                                    <div class="rating-star">
                                      <i class="fa fa-star user"></i> 
                                    </div>
                                  </div>
                              @endfor
                            <!-- <div class="star-sec">
                            <label class="star star-5" for="star-5-1-{{$key}}"> </label>
                            <input class="star star-4" id="star-4-1-{{$key}}" value="4" type="radio" @if( round($list->average_rating)==4) checked @endif>
                            <label class="star star-4" for="star-4-1-{{$key}}"></label>
                            <input class="star star-3" id="star-3-1-{{$key}}" value="3" type="radio"  @if( round($list->average_rating)==3) checked @endif>
                            <label class="star star-3" for="star-3-1-{{$key}}"></label>
                            <input class="star star-2" value="2" id="star-2-1-{{$key}}" type="radio"  @if( round($list->average_rating)==2) checked @endif>
                            <label class="star star-2" for="star-2-1-{{$key}}"></label>
                            <input class="star star-1" id="star-1-1-{{$key}}" value="1" type="radio"  @if( round($list->average_rating)==1) checked @endif>
                            <label class="star star-1" for="star-1-1-{{$key}}"></label>
                          </div> -->
                        </div>

                            </td>
                            <td>{{ $list->comment }}</td>
                          </tr>
                          @endif
                        @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <link rel="stylesheet" type="text/css" href="{{url('css/dataTables.bootstrap4.min.css')}}">
<script type="text/javascript" src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable();
} );
</script>
@endsection