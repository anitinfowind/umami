@extends('frontend.layouts.app')
@section('content')
<div class="dashboard-wrap">
<div class="container">
<div class="row">
@include('frontend.user.sidebar')
<div class="col-md-9">
<div class="dashboard-container">
  <div class="panel panel-default">
      <div class="panel-heading">
          <div class="add-product-div">
              <span>
                  <a href="{{ url('add-product') }}">
                      <button type="button" class="btn add-product">+ Add Product</button>
                  </a>
              </span>
          </div>
      </div>
      <div class="table-responsive">
        <table id="example"class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Diet </th>
                <!-- <th>Region </th> -->
                <th>Price</th>
               <!--  <th>Quantity</th> -->
                <th>Action </th>
            </tr>
          </thead>
           <tbody>
             @if($lists->isNotEmpty())
                @foreach($lists as $product)
                  @if(isset($product->singleProductImage->image) && !empty($product->singleProductImage->image))
                   <?php 
                   $info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);
                   $ext = $info['extension'];
                   ?>
                    <tr class="product_{{$product->id}}">
                        <td>
                           @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp')
                            @if(!empty($product->singleProductImage->image) &&
                                    File::exists(PRODUCT_ROOT_PATH.$product->singleProductImage->image))
                                <?php $image = PRODUCT_URL.$product->singleProductImage->image; ?>
                            @else
                                <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                            @endif
                            <img class="resto product_list" src="{{ $image }}" alt="{{ $product->title() }}">
                          @else
                            <video width="60px" height="40px" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                            <source src="{{PRODUCT_URL.$product->singleProductImage->image}}" type="video/mp4">
                            </video>
                          @endif  
                        </td>
                        <td>{{ $product->title() }}</td>
                        <td>
                          @if($product->pCategory->isNotEmpty())
                            @foreach($product->pCategory as $pcat)
                             {{ isset($pcat->p_category->name)?$pcat->p_category->name:'' }} <br/>
                            @endforeach
                          @endif

                        </td>
                        <td>
                          @if($product->pdiet->isNotEmpty())
                            @foreach($product->pdiet as $pdits)
                              {{ isset($pdits->p_diet->name)?$pdits->p_diet->name:'' }}<br/>
                            @endforeach
                          @endif
                        </td>
                       <!--  <td>{{ isset($product->region->name)?$product->region->name:'' }}</td> -->
                        <td>{{ isset($product->price)?$product->price:'' }}</td>
                        <!-- <td>{{ isset($product->quantity)?$product->quantity:'' }}</td> -->
                        <td>
                            <div class="action-icon">
                                <a href="{{ url('product-detail/'. $product->slug()) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('edit-product/'. $product->slug()) }}">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a href="javascript:void(0)"  onclick='removeProduct("{{ $product->id}}")'>
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
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