@extends('frontend.layouts.app')
@section('content')
    <div class="dashboard-wrap">
        <div class="container">
            <div class="row">
                @include('frontend.user.sidebar')
                <div class="col-md-9">
                    <div class="dashboard-container">
                        <div class="panel panel-default my-order">

                            <h4>
                                <?php
                                $status = $_GET['status'] ?? '';
                                if($status == 'pending') echo 'Pending Orders';
                                if($status == 'cancel') echo 'Cancelled Orders';
                                if($status == 'complete') echo 'Completed Orders';
                                ?>
                            </h4>
                            
                            <div class="table-responsive">
                             <table id="example"class="table table-striped table-bordered"  data-order="[[ 8, &quot;asc&quot; ]]">
                                <thead>
                                  <tr>
                                   <!--  <th>Profile</th> -->
                                    <th>Order Id</th>
                                    <th>Order Date</th>
                                    <th>Pickup Date</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                   <!--  <th>Phone</th> -->
                                    <th>Name of Order</th>
                                   <!--  <th>Order By</th> -->
                                   <th>Quantity</th>
                                    <th>Amount</th>
                                    
                                    <th>View</th>
                                    <th>Label</th>
                                    <!-- <th>Payment Type</th> -->
                                    <th>Action</th>
                                    <th>Status</th>
                                    
                                  </tr>
                                </thead>
                                 <tbody>
                                   @if($getordersdata->isNotEmpty())
                                      @foreach($getordersdata as $orlist)
                                      <tr>
                                        <td>{{ $orlist->orderId() }}</td>
                                        <td>{{ date('m-d-Y',strtotime($orlist->order_date)) }}</td>
                                        <td>{{ date('m-d-Y', strtotime($orlist->pickup_date)) }}</td>
                                        <td>{{ $orlist->first_name . ' ' . $orlist->last_name }}</td>
                                        <td>{{ $orlist->street_address }} {{ $orlist->address_line_2 != '' ? ', ' . $orlist->address_line_2 : '' }}</td>
                                        
                                        @php
                                          $totalqty=0;
                                          $totalprice=0;
                                          $nameofproduct='';
                                        @endphp
                                        @foreach($orlist->orderDetails as $orderdata)
                                        <?php
                                            $totalqty=$orderdata->quantity+$totalqty;
                                            $totalprice=$orderdata->total+$totalprice;
                                            
                                            $totalprice=$totalprice - $orderdata->included_shipping_price;
                                            
                                            $nameofproducts= App::make('App\Http\Controllers\Frontend\ProductController')->prouctNameGet($orderdata->product_id);
                                            $nameofproduct.=$nameofproducts.'<br/>';

                                            ?>

                                        @endforeach
                                        <td>{!!$nameofproduct!!}</td>
                                       <td>{{$totalqty}}</td>
                                        <td>{{$totalprice}}</td>
                                        <td>
                                          <a  class="dropdown-item" href="{{url('order/view/'. $orlist->orderId()) }}" title="View Order" style="padding: 0;">
                                            <button class="btn btn-success btn-sm">View </button>
                                          </a>
                                        </td>
                                       <td>
                                        <a class="dropdown-item print" href="javascript:void(0)" data-orderId="{{$orlist->orderId()}}" title="Print lable" style="padding: 0;">
                                                      <button class="btn btn-primary btn-sm">Label Print </button>
                                                    </a>
                                        </td>
                                        
                                        <td>

                                          <?php if($orlist->status() == 'PENDING') { ?>
                                            <!-- <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $orlist->id }}", "{{ PACKED }}")' style="padding: 0;">
                                              <button class="btn btn-info btn-sm">
                                                Packed
                                              </button> 
                                            </a> -->
                                            <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $orlist->id }}", "{{ DELIVERED }}")' style="padding: 0;">
                                              <button class="btn btn-warning btn-sm">
                                                Shipped
                                              </button> 
                                            </a>
                                          <?php } ?>
                                          <?php if($orlist->status() == 'PACKED') { ?>
                                            <!-- <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $orlist->id }}", "{{ DELIVERED }}")' style="padding: 0;">
                                              <button class="btn btn-warning btn-sm">
                                                Shipped
                                              </button> 
                                            </a> -->
                                          <?php } ?>
                                          <?php if($orlist->status() == 'DELIVERED') { ?>
                                            <!-- <a class="dropdown-item"  href="javascript::void(0)" style="padding: 0;">
                                              <button class="btn btn-success btn-sm">
                                                Completed
                                              </button> 
                                            </a> -->
                                          <?php } ?>

                                           <?php
                                           //$imageLable= App::make('App\Http\Controllers\Frontend\OrderController')->trackImage($orlist->order_id);
                                           ?>
                                          <ul class="navbar-nav mr-auto" style="display: none;">
                                              <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Action
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                  <a  class="dropdown-item" href="{{url('order/view/'. $orlist->orderId()) }}" title="View Order">
                                                    <button class="btn btn-success btn-sm">View </button>
                                                  </a>
                                                  <?php if($orlist->label_image != '') { ?>
                                                    <a class="dropdown-item print" href="javascript:void(0)" data-orderId="{{$orlist->orderId()}}" title="Print lable">
                                                      <button class="btn btn-primary btn-sm">Label Print </button>
                                                    </a>
                                                  <?php } ?>
                                                  <?php if($orlist->status() == 'PENDING') { ?>
                                                    <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $orlist->id }}", "{{ PACKED }}")'>
                                                      <button class="btn btn-info btn-sm">
                                                        Packed
                                                      </button> 
                                                    </a>
                                                    
                                                  <?php } ?>
                                                  <?php if($orlist->status() == 'PACKED') { ?>
                                                    <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $orlist->id }}", "{{ DELIVERED }}")'>
                                                      <button class="btn btn-warning btn-sm">
                                                        Delivered
                                                      </button> 
                                                    </a>
                                                    
                                                  <?php } ?>
                                                  <?php if($orlist->status() == 'DELIVERED') { ?>
                                                    <!-- <a class="dropdown-item"  href="javascript::void(0)">
                                                      <button class="btn btn-success btn-sm">
                                                        Completed
                                                      </button> 
                                                    </a> -->
                                                  <?php } ?>
                                                  
                                                </div>
                                              </li>
                                          </ul>
                                        </td>
                                        <td>
                                          <?php
                                          $btn_cls = '';
                                          if($orlist->status() == 'PENDING') $btn_cls = 'primary';
                                          if($orlist->status() == 'PACKED') $btn_cls = 'info';
                                          if($orlist->status() == 'SHIPPED') $btn_cls = 'warning';
                                          if($orlist->status() == 'DELIVERED') $btn_cls = 'success';
                                          if($orlist->status() == 'CANCELLED') $btn_cls = 'danger';
                                          //echo '<button class="btn btn-' . $btn_cls . ' btn-sm">' . ucfirst(strtolower($orlist->status())) . '</button>';
                                          if($orlist->status() == 'DELIVERED') echo 'Shipped';
                                          else echo ucfirst(strtolower($orlist->status()));
                                          ?>
                                        </td>
                                      </tr>
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

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    $('.print').on('click', function() {
     var orderId= $(this).attr('data-orderId');
    let CSRF_TOKEN = $('meta[name="csrf-token"').attr('content');

    $.ajaxSetup({
      url: '{{url("order/print/")}}',
      type: 'get',
      data: {orderid:orderId},
      beforeSend: function() {
        console.log('printing ...');
      },
      complete: function() {
        console.log('printed!');
      }
    });

    $.ajax({
      success: function(viewContent) {
        $.print(viewContent); // This is where the script calls the printer to print the viwe's content.
      }
    });
  });

});
</script>

@endsection