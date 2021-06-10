<div class="table-responsive">
 <table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>S.No</th>
        <th>Order Id</th>
        <th>Restaurant</th>
        <!-- <th>Price</th> -->
        <th>Products</th>
        <!-- <th>Paid Amount</th> -->
        <!-- <th>Review</th> -->
        <!-- <th>Status</th> -->
        <th>Order Date</th>
        <th>Est. Delivery Date</th>
        <th>Amount</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @if($myOrders->isNotEmpty())
        @foreach($myOrders as $key=> $myOrder)

          <?php //dd($myOrder); ?>

         @php
              $totalqty=0;
              $totalprice=0;
              $products = [];
            @endphp
         
          <tr>
            <td>{{$key+1}}</td>
            <td>{{ $myOrder->orderId() }}</td>
               @foreach($myOrder->orderDetails as $orderdata)
            <?php
                $totalqty=$orderdata->quantity+$totalqty;
                $totalprice=$orderdata->total+$totalprice;
                $products[] = ['title' => $orderdata->product->title, 'quantity' => $orderdata->quantity, 'slug' => $orderdata->product->slug];
            ?>
            @endforeach
            <td>{{ $myOrder->orderDetails[0]->vendor_name }}</td>
            <!-- <td>
              <?php
              foreach ($products as $pk => $pv) {
                echo '<p>' . $pv['title'] . ' x ' . $pv['quantity'] . '</p>';
              }
              ?>
            </td> -->
             <!-- <td>{{ $myOrder->payment->amount }}</td> -->
             <td>
               <?php
              foreach ($products as $pk => $pv) {
                echo '<p>' . $pv['title'] . ' <a href="' . url('product-detail/' . $pv['slug'] . '?tab=D#heading-D') . '">(Review)</a> x ' . $pv['quantity'] . '</p>';
              }
              ?>
             </td>
            <!-- <td>
              <?php if(isset($myOrder->payment->refund_id) && $myOrder->payment->refund_id != '') { ?>
                <button class="btn btn-success btn-sm">Refunded</button>
              <?php } else { ?>
              @if($myOrder->status() == PENDING)
                <button class="btn btn-primary btn-sm">
                  {{ ucfirst(strtolower($myOrder->status())) }}
                </button>
              @elseif($myOrder->status() == PACKED)
                <button class="btn btn-info btn-sm">
                  {{ ucfirst(strtolower($myOrder->status())) }}
                </button> 
              @elseif($myOrder->status() == SHIPPED)
                <button class="btn btn-warning btn-sm">
                  {{ ucfirst(strtolower($myOrder->status())) }}
                </button> 
              @elseif($myOrder->status() == DELIVERED)
                <button class="btn btn-success btn-sm">
                  {{ ucfirst(strtolower($myOrder->status())) }}
                </button>
              @else
                <button class="btn btn-danger btn-sm">
                  {{ ucfirst(strtolower($myOrder->status())) }}
                </button>
              @endif
            <?php } ?>
            </td> -->
            <td>{{ date('F j, Y', strtotime($myOrder->created_at)) }}</td>
            <td>{{ date('F j, Y', strtotime($myOrder->delivery_date)) }}</td>
            <td>${{ $myOrder->payment->amount }}
              {!! $myOrder->payment->refund_id != '' ? '<br><span class="badge badge-dark">Refunded $' . $myOrder->payment->refund_amount . '</span><br>' . $myOrder->payment->refund_info : '' !!}
            </td>
            <td>
              <a href="{{ url('track-order', \Crypt::encryptString($myOrder->id)) }}" class="btn btn-primary btn-sm">Track Order</a>

                <ul class="navbar-nav mr-auto" style="display: none;">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                     <a  class="dropdown-item" href="{{ url('track-order', \Crypt::encryptString($myOrder->id)) }}" title="Track Order">
                        <button class="btn btn-info">Track Order</button>
                     </a>
                     <?php if(isset($myOrder->payment->refund_id) && $myOrder->payment->refund_id != '') { } else { ?>
                     @if($myOrder->status() == PENDING)
                        <!--<a  class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $myOrder->id }}", "{{ CANCELLED }}")' title="Cancel Order">
                           <button class="btn btn-danger">Cancel Order</button>
                        </a>-->
                      @endif
                       <a  class="dropdown-item" href="javascript::void(0)" data-toggle="modal" data-target="#myModal_{{$myOrder->id}}">
                        <button class="btn  btn-primary">Order Rating</button></a>
                      <?php } ?>
                    </div>
                  </li>
                </ul>
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
</div>

  
@foreach($myOrders as $k=> $myOrder)

  <div class="modal fade" id="myModal_{{$myOrder->id}}" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="cont5">
             <div class="title">
              <h3>Rating</h3>
            </div>
            <div class="stars1">
              <div class="row">
               <div class="col-sm-12">
                <div class="item-table web-tbody">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="40%" style="padding-left: 25px;">Product Image</th>
                          <th>Title</th>
                          <th style="text-align: center;">Price</th>
                          <th style="text-align: center;">quantity</th>
                          <th style="text-align: right;">Total</th>
                        </tr>
                      
                      </thead>
                      <tbody>
                        @php 
                        $subtotal=0;
                        @endphp
                       @foreach($myOrder->orderDetails as $key=>$myOrderDetail)
                       @php
                       $subtotal=$myOrderDetail->total+$subtotal;
                       @endphp
                       
                        @if(!empty($myOrderDetail->product->singleProductImage->image) &&
                        File::exists(PRODUCT_ROOT_PATH.$myOrderDetail->product->singleProductImage->image))
                          <?php $image = PRODUCT_URL.$myOrderDetail->product->singleProductImage->image; ?>
                        @else
                          <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                        @endif

                        <tr>
                          <td>
                            <a href="{{ url('product-detail',isset($myOrder->product->slug)?$myOrder->product->slug:'') }}">
                              <img width="100px" src="{{ $image }}" alt="{{ isset($myOrder->product->title)?$myOrder->product->title:'' }}">
                            </a>  
                          </td>
                          <td>
                            {{isset($myOrder->product->title)?$myOrder->product->title:''}}
                           </td>
                          <td style="text-align: center;">{{ isset($myOrderDetail->price)?$myOrderDetail->price:'' }}</td>
                          <td style="text-align: center;">{{ isset($myOrderDetail->quantity)?$myOrderDetail->quantity:'' }}</td>
                          <td style="text-align: right;"><b>{{ isset($myOrderDetail->total)?$myOrderDetail->total:'' }}</b></td>
                        </tr>
                         @if(count($myOrderDetail->ratingData)>0)
                        @foreach ($myOrderDetail->ratingData as $r => $value) 
                        <tr>
                          <td colspan="5">
                            <form action="{{url('user/review')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="orderid" value="{{$myOrder->order_id}}">
                             <input type="hidden" name="order_detail_id" value="{{$myOrderDetail->id}}">
                              <input type="hidden" name="productid" value="{{$myOrderDetail->product_id}}">
                              <div class="star-sec">
                                <span>Taste of the food (taste)
                                </span>
                            <input class="star star-5" id="star-5-1-{{$key}}{{$myOrder->id}}" value="5" type="radio" name="taste" @if($value->taste==5) checked @endif>

                            <label class="star star-5" for="star-5-1-{{$key}}{{$myOrder->id}}"> </label>
                            <input class="star star-4" id="star-4-1-{{$key}}{{$myOrder->id}}" value="4" type="radio" name="taste" @if($value->taste==4) checked @endif>
                            <label class="star star-4" for="star-4-1-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-3" id="star-3-1-{{$key}}{{$myOrder->id}}" value="3" type="radio" name="taste" @if($value->taste==3) checked @endif>
                            <label class="star star-3" for="star-3-1-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-2" value="2" id="star-2-1-{{$key}}{{$myOrder->id}}" type="radio" name="taste" @if($value->taste==2) checked @endif>
                            <label class="star star-2" for="star-2-1-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-1" id="star-1-1-{{$key}}{{$myOrder->id}}" value="1" type="radio" name="taste" @if($value->taste==1) checked @endif>
                            <label class="star star-1" for="star-1-1-{{$key}}{{$myOrder->id}}"></label>
                            </div>

                            <div class="star-sec">
                              <span>Instruction of the cooking (Instruction)
                              </span>
                            <input class="star star-5" id="star-5-2-{{$key}}{{$myOrder->id}}" value="5" type="radio" name="shipping" @if($value->shipping==5) checked @endif>

                            <label class="star star-5" for="star-5-2-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-4" id="star-4-2-{{$key}}{{$myOrder->id}}" value="4" type="radio" name="shipping" @if($value->shipping==4) checked @endif>
                            <label class="star star-4" for="star-4-2-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-3" id="star-3-2-{{$key}}{{$myOrder->id}}" value="3" type="radio" name="shipping" @if($value->shipping==3) checked @endif>
                            <label class="star star-3" for="star-3-2-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-2" value="2" id="star-2-2-{{$key}}{{$myOrder->id}}" type="radio" name="shipping"@if($value->shipping==2) checked @endif>
                            <label class="star star-2" for="star-2-2-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-1" id="star-1-2-{{$key}}{{$myOrder->id}}" value="1" type="radio" name="shipping" @if($value->shipping==1) checked @endif>
                            <label class="star star-1" for="star-1-2-{{$key}}{{$myOrder->id}}"></label>
                            </div>

                            <div class="star-sec">
                              <span> Package of the product (package)</span>
                            <input class="star star-5" id="star-5-3-{{$key}}{{$myOrder->id}}" value="5" type="radio" name="visual" @if($value->visual==5) checked @endif>

                            <label class="star star-5" for="star-5-3-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-4" id="star-4-3-{{$key}}{{$myOrder->id}}" value="4" type="radio" name="visual" @if($value->visual==4) checked @endif>
                            <label class="star star-4" for="star-4-3-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-3" id="star-3-3-{{$key}}{{$myOrder->id}}" value="3" type="radio" name="visual" @if($value->visual==3) checked @endif>
                            <label class="star star-3" for="star-3-3-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-2" value="2" id="star-2-3-{{$key}}{{$myOrder->id}}" type="radio" name="visual" @if($value->visual==2) checked @endif>
                            <label class="star star-2" for="star-2-3-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-1" id="star-1-3-{{$key}}{{$myOrder->id}}" value="1" type="radio" name="visual" @if($value->visual==1) checked @endif>
                            <label class="star star-1" for="star-1-3-{{$key}}{{$myOrder->id}}"></label>
                            </div>
                            <div class="star-sec">
                              <span> Delivered at proper temperature(shipping)</span>
                            <input class="star star-5" id="star-5-4-{{$key}}{{$myOrder->id}}" value="5" type="radio" name="deliver"@if($value->deliver==5) checked @endif/>

                            <label class="star star-5" for="star-5-4-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-4" id="star-4-4-{{$key}}{{$myOrder->id}}" value="4" type="radio" name="deliver" @if($value->deliver==4) checked @endif/>
                            <label class="star star-4" for="star-4-4-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-3" id="star-3-4-{{$key}}{{$myOrder->id}}" value="3" type="radio" name="deliver" @if($value->deliver==3) checked @endif/>
                            <label class="star star-3" for="star-3-4-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-2" value="2" id="star-2-4-{{$key}}{{$myOrder->id}}" type="radio" name="deliver" @if($value->deliver==2) checked @endif/>
                            <label class="star star-2" for="star-2-4-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-1" id="star-1-4-{{$key}}{{$myOrder->id}}" value="1" type="radio" name="deliver" @if($value->deliver==1) checked @endif/>
                            <label class="star star-1" for="star-1-4-{{$key}}{{$myOrder->id}}"></label>
                            </div>
                            <div class="comment-sec">
                              <div class="title">
                                <h3>Comment</h3>
                              </div>
                                <textarea name="comment" class="form-control" required="">{{$value->comment}}</textarea>
                            </div>
                            <input type="submit" class="btn btn-success" name="submit" value="Submit">
                            </form>
                          </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                          <td colspan="5">
                            <form action="{{url('user/review')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="orderid" value="{{$myOrder->order_id}}">
                             <input type="hidden" name="order_detail_id" value="{{$myOrderDetail->id}}">
                              <input type="hidden" name="productid" value="{{$myOrderDetail->product_id}}">
                              <div class="star-sec">
                                <span>Taste of the food (taste)</span>
                            <input class="star star-5" id="star-5-1-{{$key}}{{$myOrder->id}}" value="5" type="radio" name="taste"/>

                            <label class="star star-5" for="star-5-1-{{$key}}{{$myOrder->id}}"> </label>
                            <input class="star star-4" id="star-4-1-{{$key}}{{$myOrder->id}}" value="4" type="radio" name="taste">
                            <label class="star star-4" for="star-4-1-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-3" id="star-3-1-{{$key}}{{$myOrder->id}}" value="3" type="radio" name="taste"/>
                            <label class="star star-3" for="star-3-1-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-2" value="2" id="star-2-1-{{$key}}{{$myOrder->id}}" type="radio" name="taste"/>
                            <label class="star star-2" for="star-2-1-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-1" id="star-1-1-{{$key}}{{$myOrder->id}}" value="1" type="radio" name="taste"/>
                            <label class="star star-1" for="star-1-1-{{$key}}{{$myOrder->id}}"></label>
                            </div>

                            <div class="star-sec">
                              <span>Instruction of the cooking (Instruction)</span>
                            <input class="star star-5" id="star-5-2-{{$key}}{{$myOrder->id}}" value="5" type="radio" name="shipping"/>

                            <label class="star star-5" for="star-5-2-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-4" id="star-4-2-{{$key}}{{$myOrder->id}}" value="4" type="radio" name="shipping"/>
                            <label class="star star-4" for="star-4-2-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-3" id="star-3-2-{{$key}}{{$myOrder->id}}" value="3" type="radio" name="shipping"/>
                            <label class="star star-3" for="star-3-2-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-2" value="2" id="star-2-2-{{$key}}{{$myOrder->id}}" type="radio" name="shipping"/>
                            <label class="star star-2" for="star-2-2-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-1" id="star-1-2-{{$key}}{{$myOrder->id}}" value="1" type="radio" name="shipping"/>
                            <label class="star star-1" for="star-1-2-{{$key}}{{$myOrder->id}}"></label>
                            </div>

                          <div class="star-sec">
                              <span> Package of the product (package)</span>
                            <input class="star star-5" id="star-5-3-{{$key}}{{$myOrder->id}}" value="5" type="radio" name="visual"/>

                            <label class="star star-5" for="star-5-3-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-4" id="star-4-3-{{$key}}{{$myOrder->id}}" value="4" type="radio" name="visual"/>
                            <label class="star star-4" for="star-4-3-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-3" id="star-3-3-{{$key}}{{$myOrder->id}}" value="3" type="radio" name="visual"/>
                            <label class="star star-3" for="star-3-3-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-2" value="2" id="star-2-3-{{$key}}{{$myOrder->id}}" type="radio" name="visual"/>
                            <label class="star star-2" for="star-2-3-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-1" id="star-1-3-{{$key}}{{$myOrder->id}}" value="1" type="radio" name="visual"/>
                            <label class="star star-1" for="star-1-3-{{$key}}{{$myOrder->id}}"></label>
                            </div>

                            <div class="star-sec">
                              <span> Delivered at proper temperature(shipping)</span>
                            <input class="star star-5" id="star-5-4-{{$key}}{{$myOrder->id}}" value="5" type="radio" name="deliver"/>

                            <label class="star star-5" for="star-5-4-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-4" id="star-4-4-{{$key}}{{$myOrder->id}}" value="4" type="radio" name="deliver"/>
                            <label class="star star-4" for="star-4-4-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-3" id="star-3-4-{{$key}}{{$myOrder->id}}" value="3" type="radio" name="deliver"/>
                            <label class="star star-3" for="star-3-4-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-2" value="2" id="star-2-4-{{$key}}{{$myOrder->id}}" type="radio" name="deliver"/>
                            <label class="star star-2" for="star-2-4-{{$key}}{{$myOrder->id}}"></label>
                            <input class="star star-1" id="star-1-4-{{$key}}{{$myOrder->id}}" value="1" type="radio" name="deliver"/>
                            <label class="star star-1" for="star-1-4-{{$key}}{{$myOrder->id}}"></label>
                            </div>
                            <div class="comment-sec">
                              <div class="title">
                                <h3>Comment</h3>
                              </div>
                                <textarea name="comment" class="form-control" required=""></textarea>
                            </div>
                            <input type="submit" class="btn btn-success" name="submit" value="Submit">
                            </form>
                          </td>
                        </tr>

                        @endif

                        @endforeach
                      </tbody>
                    </table>
                </div>
               </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
               
<link rel="stylesheet" type="text/css" href="{{url('css/dataTables.bootstrap4.min.css')}}">
<script type="text/javascript" src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable();
} );
</script>               