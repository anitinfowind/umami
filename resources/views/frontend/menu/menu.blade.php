@extends('frontend.layouts.app')
@section('content')
<div class="inner-breadcrumbs-menu">
  <div class="container">
  <ul>
    <li><a href="#">Home</a><i class="fa fa-angle-right"></i></li>
    <li><span>Menu</span></li>
  </ul>
</div>
</div>

<div class="u-menu">
  <div class="container">
    <div class="food-menu-tab">
        <div class="row">
        <div class="col-sm-12 text-right">
           <div class="filter-sort">
          <select class="form-control">
             <!-- <option>Sort By: <b>Best Sellers</b></option>
             <option>Trending</option> -->
              <option>Delivery Date: Today</option>
             <option>Delivery Date: Yesterday</option>
             <option>Delivery Date: Last Week</option>
             <option>Delivery Date: Last month</option>
             <option>Price: Lowest First</option>
             <option>Price: Highest First</option>
             <option>Popularity: Top Selling Food</option>
             <option>Popularity: Highest Selling Food</option>
             <option>Popularity: Lowest Selling Food</option>
          </select>
         </div>
      </div>
      <div class="col-sm-3">
        <div class="filter-category">
           <ul>
            <li>
               <label><input type="checkbox"> <span>Editor's Pick</span></label>
            </li>
            <li>
               <label><input type="checkbox"> <span>Free Shipping</span></label>
            </li>
           </ul>
           <div id="accordion" class="accordion">
           <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                  <a class="card-title">Category</a>
              </div>
              <div id="collapseOne" class="collapse card-body" data-parent="#accordion">
                 <ul>
                  <li><a href="#">Fish (131)</a></li>
                  <li><a href="#">Crab (50)</a></li>
                  <li><a href="#">Lobster (55)</a></li>
                  <li><a href="#">Crab Cakes (80)</a></li>
                  <li><a href="#">Seafood Chowders (35)</a></li>
                  <li><a href="#">Shrimp (35)</a></li>
                  <li><a href="#">Oysters (131)</a></li>
                  <li><a href="#">Crawfish (131)</a></li>
                 </ul>
              </div>
              <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                  <a class="card-title">Diet</a>
              </div>
              <div id="collapseTwo" class="collapse card-body" data-parent="#accordion">
                 <ul>
                  <li><a href="#">Fish (131)</a></li>
                  <li><a href="#">Crab (50)</a></li>
                  <li><a href="#">Lobster (55)</a></li>
                  <li><a href="#">Crab Cakes (80)</a></li>
                  <li><a href="#">Seafood Chowders (35)</a></li>
                  <li><a href="#">Shrimp (35)</a></li>
                  <li><a href="#">Oysters (131)</a></li>
                  <li><a href="#">Crawfish (131)</a></li>
                 </ul>
              </div>
               <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                  <a class="card-title">Region</a>
              </div>
              <div id="collapseThree" class="collapse card-body" data-parent="#accordion">
                 <ul>
                  <li><a href="#">Northeast (131)</a></li>
                  <li><a href="#">West (131)</a></li>
                  <li><a href="#">South (50)</a></li>
                  <li><a href="#">Midwest (55)</a></li>
                  <li><a href="#">Southwest (80)</a></li>
                 </ul>
              </div>
              <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                  <a class="card-title">Price</a>
              </div>
              <div id="collapseFour" class="collapse card-body" data-parent="#accordion">
                <div class="price-range">
                  <div id="ranged-value" style="width: 100%;"></div>
                </div>
              </div>
        </div>  
        </div>
         </div>
      </div>

      <div class="col-sm-9">
         <div class="row">
         <div class="col-sm-4">
          <div class="product-box">
              <div class="product-img-box">
                <div class="product-img">
                 <img src="images/product22.jpg">
                </div>
                <div class="view-detail">
                  <button class="btn view-btn">View Details</button>
                </div>
                <div class="cart-d">
              <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
            </div>
            <div class="sale-offer">
              <a href="#">On Sale!</a>
            </div>
              </div>
              <div class="product-detail">
                 <h4>Chicken Drumsticks</h4> 
                <div class="cal-icon">
                  <a href="#" data-toggle="tooltip" data-placement="top" title="calorie free"><img src="images/calorie.png"></a>
                  <a href="#" data-toggle="tooltip" data-placement="top" title="gluten free"><img src="images/gluten.png"></a>
                </div>
                 <p>American, Fast Food</p>

                 <h6><span class="ofr-price">$89.95</span> $64.95</h6>
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
            <div class="col-sm-4">
          <div class="product-box">
              <div class="product-img-box">
                <div class="product-img">
                 <img src="images/product19.jpg">
                </div>
                <div class="view-detail">
                  <button class="btn view-btn">View Details</button>
                </div>
                <div class="cart-d">
              <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
            </div>
            <div class="sale-offer sold-out">
              <a href="#">Sold Out!</a>
            </div>
              </div>
              <div class="product-detail">
                 <h4>Chicken Rice</h4>
                 <div class="cal-icon">
                  <a href="#" data-toggle="tooltip" data-placement="top" title="calorie free"><img src="images/calorie.png"></a>
                  <a href="#" data-toggle="tooltip" data-placement="top" title="gluten free"><img src="images/gluten.png"></a>
                </div>
                 <p>American, Fast Food</p>
                 <h6><span class="ofr-price">$89.95</span> $64.95</h6>
                 <div class="rating-stars">
             <div class="rating-star">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                  </div>
              </div>
             </div>
            </div>
            <div class="col-sm-4">
          <div class="product-box">
              <div class="product-img-box">
                <div class="product-img">
                 <img src="images/product13.jpg">
                </div>
                <div class="view-detail">
                  <button class="btn view-btn">View Details</button>
                </div>
                <div class="cart-d">
              <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
            </div>
            <div class="sale-offer">
              <a href="#">On Sale!</a>
            </div>
              </div>
              <div class="product-detail">
                 <h4>Pizza Margherita</h4>
                <div class="cal-icon">
                  <a href="#" data-toggle="tooltip" data-placement="top" title="calorie free"><img src="images/calorie.png"></a>
                  <a href="#" data-toggle="tooltip" data-placement="top" title="gluten free"><img src="images/gluten.png"></a>
                </div>
                 <p>American, Fast Food</p>
                 <h6><span class="ofr-price">$89.95</span> $64.95</h6>
                 <div class="rating-stars">
             <div class="rating-star">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                  </div>
              </div>
             </div>
            </div>
            <div class="col-sm-4">
          <div class="product-box">
              <div class="product-img-box">
                <div class="product-img">
                 <img src="images/product11.jpg">
                </div>
                <div class="view-detail">
                  <button class="btn view-btn">View Details</button>
                </div>
                <div class="cart-d">
              <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
            </div>
            <div class="sale-offer">
              <a href="#">On Sale!</a>
            </div>
              </div>
              <div class="product-detail">
                 <h4>Juicy baked Burger</h4>
                 <div class="cal-icon">
                  <a href="#" data-toggle="tooltip" data-placement="top" title="calorie free"><img src="images/calorie.png"></a>
                  <a href="#" data-toggle="tooltip" data-placement="top" title="gluten free"><img src="images/gluten.png"></a>
                </div>
                 <p>American, Fast Food</p>
                 <h6><span class="ofr-price">$89.95</span> $64.95</h6>
                 <div class="rating-stars">
             <div class="rating-star">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                  </div>
              </div>
             </div>
            </div>
            <div class="col-sm-4">
          <div class="product-box">
              <div class="product-img-box">
                <div class="product-img">
                 <img src="images/product5.jpg">
                </div>
                <div class="view-detail">
                  <button class="btn view-btn">View Details</button>
                </div>
                <div class="cart-d">
              <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
            </div>
            <div class="sale-offer">
              <a href="#">On Sale!</a>
            </div>
              </div>
              <div class="product-detail">
                 <h4>Pasta & Pizza</h4>
                 <div class="cal-icon">
                  <a href="#" data-toggle="tooltip" data-placement="top" title="calorie free"><img src="images/calorie.png"></a>
                  <a href="#" data-toggle="tooltip" data-placement="top" title="gluten free"><img src="images/gluten.png"></a>
                </div>
                 <p>American, Fast Food</p>
                 <h6><span class="ofr-price">$89.95</span> $64.95</h6>
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
            <div class="col-sm-4">
          <div class="product-box">
              <div class="product-img-box">
                <div class="product-img">
                 <img src="images/product2.jpg">
                </div>
                <div class="view-detail">
                  <button class="btn view-btn">View Details</button>
                </div>
                <div class="cart-d">
              <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
            </div>
            <div class="sale-offer sold-out">
              <a href="#">Sold Out!</a>
            </div>
              </div>
              <div class="product-detail">
                 <h4>McLoons Lobster Shack</h4>
                 <div class="cal-icon">
                  <a href="#" data-toggle="tooltip" data-placement="top" title="calorie free"><img src="images/calorie.png"></a>
                  <a href="#" data-toggle="tooltip" data-placement="top" title="gluten free"><img src="images/gluten.png"></a>
                </div>
                 <p>American, Fast Food</p>
                 <h6><span class="ofr-price">$89.95</span> $64.95</h6>
                 <div class="rating-stars">
             <div class="rating-star">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                  </div>
              </div>
             </div>
            </div>
            <div class="col-sm-4">
          <div class="product-box">
              <div class="product-img-box">
                <div class="product-img">
                 <img src="images/product3.jpg">
                </div>
                <div class="view-detail">
                  <button class="btn view-btn">View Details</button>
                </div>
                <div class="cart-d">
              <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
            </div>
            <div class="sale-offer sold-out">
              <a href="#">Sold Out!</a>
            </div>
              </div>
              <div class="product-detail">
                 <h4>Kings BBQ</h4>
                 <div class="cal-icon">
                  <a href="#" data-toggle="tooltip" data-placement="top" title="calorie free"><img src="images/calorie.png"></a>
                  <a href="#" data-toggle="tooltip" data-placement="top" title="gluten free"><img src="images/gluten.png"></a>
                </div>
                 <p>American, Fast Food</p>
                 <h6><span class="ofr-price">$89.95</span> $64.95</h6>
                 <div class="rating-stars">
             <div class="rating-star">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                  </div>
              </div>
             </div>
            </div>
            <div class="col-sm-4">
          <div class="product-box">
              <div class="product-img-box">
                <div class="product-img">
                 <img src="images/product4.jpg">
                </div>
                <div class="view-detail">
                  <button class="btn view-btn">View Details</button>
                </div>
                <div class="cart-d">
              <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
            </div>
            <div class="sale-offer">
              <a href="#">On Sale!</a>
            </div>
              </div>
              <div class="product-detail">
                 <h4>Joe's KC BBQ</h4>
                 <div class="cal-icon">
                  <a href="#" data-toggle="tooltip" data-placement="top" title="calorie free"><img src="images/calorie.png"></a>
                  <a href="#" data-toggle="tooltip" data-placement="top" title="gluten free"><img src="images/gluten.png"></a>
                </div>
                 <p>American, Fast Food</p>
                 <h6><span class="ofr-price">$89.95</span> $64.95</h6>
                 <div class="rating-stars">
             <div class="rating-star">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                  </div>
              </div>
             </div>
            </div>
            <div class="col-sm-4">
          <div class="product-box">
              <div class="product-img-box">
                <div class="product-img">
                 <img src="images/product5.jpg">
                </div>
                <div class="view-detail">
                  <button class="btn view-btn">View Details</button>
                </div>
                <div class="cart-d">
              <a href="#" class="f-cart"><i class="fa fa-heart"></i></a>
            </div>
            <div class="sale-offer">
              <a href="#">On Sale!</a>
            </div>
              </div>
              <div class="product-detail">
                 <h4>Pasta & Pizza</h4>
                 <div class="cal-icon">
                  <a href="#" data-toggle="tooltip" data-placement="top" title="calorie free"><img src="images/calorie.png"></a>
                  <a href="#" data-toggle="tooltip" data-placement="top" title="gluten free"><img src="images/gluten.png"></a>
                </div>
                 <p>American, Fast Food</p>
                 <h6><span class="ofr-price">$89.95</span> $64.95</h6>
                 <div class="rating-stars">
             <div class="rating-star">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                  </div>
              </div>
             </div>
            </div>
      </div>
     </div>

<!----------- close menu-tab----------->
  </div>
</div>
</div>
</div>

@endsection