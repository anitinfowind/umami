@extends('frontend.layouts.app')
@section('content')
<div class="dashboard-wrap">
  <div class="container">
    <div class="row">
      @include('frontend.user.sidebar')
      <div class="col-md-9">
        <div class="dashboard-container">
          <div class="panel panel-default">
            <div class="table-responsive">
              <table class="table product-table">
                <thead class="thead-dark">
                  <tr>
                      <th>Product image</th>
                      <!-- @if(auth()->user()->isVender())
                          <th>User Name</th>
                      @endif -->
                      <th>Title </th>
                      <th>Category</th>
                      <th>Diet </th>
                      <th>Price</th>
                      <th>Time</th>
                      @if(auth()->user()->isUser())
                      <th>Action </th>
                      @endif
                  </tr>
                </thead>
                  <tbody>
                    @if($favorites->isNotEmpty())
                      @foreach($favorites as $favorite)
                      @if(isset($favorite->product->singleProductImage->image) && !empty($favorite->product->singleProductImage->image))
                      <tr class="favorite_{{$favorite->id}}">
                        <td>
                            @if(!empty($favorite->product->singleProductImage->image) &&
                            File::exists(PRODUCT_ROOT_PATH.$favorite->product->singleProductImage->image))
                            <?php $image = PRODUCT_URL.$favorite->product->singleProductImage->image; ?>
                            @else
                                <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                            @endif

                            <?php
                            $pdimg = WEBSITE_IMG_URL.'no-product-image.png';
                            foreach ($favorite->product->productImage as $ik => $iv) {
                              $pathinfo = pathinfo($iv->image);
                              if(in_array($pathinfo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp'])) 
                                $pdimg = PRODUCT_URL . $iv->image;
                            }
                            ?>

                            <img class111="resto product_list" src="{{ $pdimg }}" alt="{{ $favorite->product->title() }}" style="max-width: 60px; max-height: 60px;">
                          </td>
                              <!-- @if(auth()->user()->isVender())
                              <td>{{ $favorite->user->name }}</td>
                              @endif -->
                              <td><a href="{{ url('product-detail/' . $favorite->product->slug) }}">{{ $favorite->product->title() }}</a></td>
                              <td>{{  isset($favorite->product->category->name)?$favorite->product->category->name:'' }}</td>
                              <td>{{ isset($favorite->product->diet->name)?$favorite->product->diet->name:'' }}</td>
                              <td>${{ $favorite->product->price() }}</td>
                              <td>{{ $favorite->created_at->diffForHumans() }}</td>
                              @if(auth()->user()->isUser())
                              <td>
                                  <div class="action-icon">
                                      <a href="javascript:void(0)"  onclick='removeFavorite("{{ $favorite->id}}")'>
                                          <i class="fa fa-trash"></i>
                                      </a>
                                      <!-- <a onclick='addToCart("{{$favorite->product->slug}}")'><i class="fa fa-shopping-cart"></i></a> -->
                                  </div>
                              </td>
                              @endif
                          </tr>
                      @endif
                      @endforeach
                      @else
                        <tr>
                          <td colspan="8">
                              <h6 class="text-center">No Record Found</h6>
                          </td>
                        </tr>
                    @endif
                  </tbody>
              </table>
            </div>
              @include('frontend.pagination.pagination', ['paginator' => $favorites])
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection