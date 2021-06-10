@foreach($products as $product)
    <div class="col-sm-4">
        <div class="product-box">
            <div class="product-img-box">
               @if($product->editor_pick==1)
               <div class="editor"><img src="{{ WEBSITE_IMG_URL.'editor-pic.png' }}"></div>
               @endif
                <div class="product-img">
                    @if(!empty($product->singleProductImage->image) &&
                            File::exists(PRODUCT_ROOT_PATH.$product->singleProductImage->image))
                        <?php $image = PRODUCT_URL.$product->singleProductImage->image; ?>
                    @else
                        <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                    @endif
                  <a href="{{url('product-detail/'.$product->slug)}}"> <img class="product_image_resto" src="{{ $image }}" alt="{{ $product->title }}"></a>
                </div>
                <div class="view-detail">
                    <a href="{{ url('product-detail/'. $product->slug) }}">
                        <button class="btn view-btn">
                            View Details
                        </button>
                    </a>
                </div>
                <div class="cart-d">
                    @if(auth()->check())
                        @if(auth()->user()->isUser())
                            <div class="like-img">
                                @if(!empty($product->favorite))
                                    <a
                                            href="javascript:void(0)"
                                            class=" fav_{{ $product->id() }}"
                                            onclick='favourite("{{ $product->id() }}","unfavourite")'
                                    >
                                        <i class="food_tab_{{ $product->id() }} fa fa-heart" aria-hidden="true"
                                           id="fav_{{ $product->id() }}"></i>
                                    </a>
                                @else
                                    <a
                                            href="javascript:void(0)"
                                            class="f-cart fav_{{ $product->id() }}"
                                            onclick='favourite("{{ $product->id() }}","favourite")'
                                    >
                                        <i class="food_tab_{{ $product->id() }} fa fa-heart-o" aria-hidden="true"
                                           id="fav_{{ $product->id() }}"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="like-img">
                            <a href="{{ url('login') }}" class="f-cart">
                                <i class="fa fa-heart-o"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="sale-offer">
                    <a href="#">On Sale!</a>
                </div>
            </div>
            <div class="product-detail">
                <h4>{{ Str::limit($product->title,30) }}</h4>
                <div class="cal-icon">
                  <?php $checkattr=[];
                  if(!empty($product->attribute))
                  {
                    $checkattr= explode(',',$product->attribute);
                  }?>
                    @if($productAttrs->isNotEmpty())
                     @foreach($productAttrs as $productAttr)
                      @if(in_array($productAttr->id,$checkattr))
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{{$productAttr->name}}">
                          <img src="{{ ATTRIBUTE_URL.$productAttr->icon}}">
                        </a>
                       @endif
                    @endforeach
                    @endif
                </div>
                <p>{{ $product->region->name }}, {{ $product->category->name }}</p>
                <h6>
                    @if(!empty($product->discount))
                        <span class="ofr-price">${{ $product->price }}</span>${{ $product->discount }}
                    @endif
                    @if(empty($product->discount))
                        ${{ $product->price }}
                    @endif
                </h6>
                <div class="rating-stars">
                    <div class="rating-star">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
