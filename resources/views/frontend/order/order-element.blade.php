<?php
$segment = \Request::segment(1);
?>

<?php
/*if($segment != 'today-order-pickup') {
?>
<div class="row">
<div id="owl-demo">
  <?php 


     $now = new DateTime( "1 year ago", new DateTimeZone('America/New_York'));
$interval = new DateInterval( 'P1D'); // 1 Day interval
$period = new DatePeriod( $now, $interval,366);
$dates = array();
foreach ($period as $dt) {
    $dates[] = $dt;
}
$dates = array_reverse($dates);
  ?>

  <?php 

  foreach ($dates as $key => $value) {
   $date_day=$value->format('M d, Y'); 
 $date_str=  $value->format('Y-m-d');
  $timestamp = strtotime($date_str);
    ?>
  <div class="item">
    <div class="product-box col-sm-12">
      <div class="product-img-box">
        <input type="hidden" class="orders" value="1">
        <a href="{{url('order-date/'.$timestamp) }}">
          <div class="product-img">
            <?php 
            
            echo  $day = date('D', $timestamp);
            ?>
            <p>{{$date_day}}<br/> Orders</p>
          </div>
        </a>
      </div>
    </div>
  </div>
<?php } ?>
</div>
</div> 
<?php }*/ ?>

<?php
//$nxtsunday = date('Y-m-d', strtotime('next sunday', strtotime('today')));
//$prevmonday = date('Y-m-d', strtotime('previous monday', strtotime('today')));

//echo "Next Monday:". date('Y-m-d', strtotime('next monday', strtotime('today')));
//echo "Previous Monday:". date('Y-m-d', strtotime('previous monday', strtotime('today')));
?>


<?php
/*if($segment != 'today-order-pickup') {
?>
<div class="row">
  <div class="col-md-4"><label>From date</label><input type="text" class="form-control" name="from_date" value="{{ date('d-m-Y', strtotime($from_date)) }}" readonly /></div>
  <div class="col-md-4"><label>To date</label><input type="text" class="form-control" name="to_date" value="{{ date('d-m-Y', strtotime($to_date)) }}" readonly /></div>
  <div class="col-md-4"><label>&nbsp;</label><br><a href="javascript:;" class="btn btn-danger btn-sm search_orders">Search</a></div>
</div>
<?php }*/ ?>


<?php
$n = date('N', strtotime($date));
$prevmonday = date('Y-m-d', strtotime('previous monday', strtotime($date)));
if($n == '1') // monday
  $prevmonday = $date;
$nxtsunday = date('Y-m-d', strtotime('next sunday', strtotime($date)));
if($n == '1') // sunday
  $nxtsunday = $date;
?>

<div class="horz_links d-flex">
  <div class="item previtem"><a href="{{ url('order?d=' . date('Y-m-d', strtotime($prevmonday . ' -1 day'))) }}">Previous Week</a></div>
  <?php
  for($i = 0; $i < 5; $i++) {
    $d = date('d F, Y', strtotime($prevmonday . ' +' . $i . ' day'));
    $d2 = date('Y-m-d', strtotime($prevmonday . ' +' . $i . ' day'));
    $active = '';
    if($d2 == $date) $active = 'active';
    echo '<div class="item ' . $active . '"><a href="' . url('order?d=' . $d2) . '">' . $d . '<br>' . $daily_order_counts[$i] . ' Orders</a></div>';
  }
  ?>
  <div class="item nextitem"><a href="{{ url('order?d=' . date('Y-m-d', strtotime($nxtsunday . ' +1 day'))) }}">Next Week</a></div>
</div>


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
           
            <!-- <td>
              @if($orlist->user != null && $orlist->user->image() !=='' && 
                File::exists(USER_PROFILE_IMAGE_ROOT_PATH.$orlist->user->slug.DS.$orlist->user->image()))
                  <img class="media-object" src="{{ USER_PROFILE_IMAGE_URL.$orlist->user->slug.DS.$orlist->user->image() }}">
              @else
                <img class="media-object" src="{{ WEBSITE_IMG_URL }}profile-user-img.png">
              @endif
            </td> -->
            <td>{{ $orlist->orderId() }}</td>
            <td>{{ date('m-d-Y',strtotime($orlist->order_date)) }}</td>
            <td>{{ date('m-d-Y', strtotime($orlist->pickup_date)) }}</td>
            <td>{{ $orlist->first_name . ' ' . $orlist->last_name }}</td>
            <td>{{ $orlist->streetAddress() }} {{ $orlist->address_line_2 != '' ? ', ' . $orlist->address_line_2 : '' }}</td>
            
            <!-- <td>phone</td> -->
           <!--  <td>
              @if($orlist->vendor_id == Auth()->user()->id)
              {{'SELF'}}
              @else
              {{'BRANCH'}}

              @endif
            </td> -->
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
           <!--  <td>{{ $orlist->paymentType() }}</td> -->
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
                        <!-- <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $orlist->id }}", "{{ CANCELLED }}")'>
                          <button class="btn btn-danger btn-sm">
                            Cancel
                          </button> 
                        </a> -->
                      <?php } ?>
                      <?php if($orlist->status() == 'PACKED') { ?>
                        <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $orlist->id }}", "{{ DELIVERED }}")'>
                          <button class="btn btn-warning btn-sm">
                            Delivered
                          </button> 
                        </a>
                        <!-- <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $orlist->id}}", "{{ CANCELLED }}")'>
                          <button class="btn btn-danger btn-sm">
                            Cancel
                          </button> 
                        </a> -->
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
              <?php
              /*@if($orlist->status() == PENDING)
                <button class="btn btn-primary btn-sm">
                  Printed
                </button>
              @elseif($orlist->status() == PACKED)
                <button class="btn btn-info btn-sm">
                  {{ ucfirst(strtolower($orlist->status())) }}
                </button> 
              @elseif($orlist->status() == SHIPPED)
                <button class="btn btn-warning btn-sm">
                  {{ ucfirst(strtolower($orlist->status())) }}
                </button> 
              @elseif($orlist->status() == DELIVERED)
                <button class="btn btn-success btn-sm">
                 Completed
                </button>
              @else
                <button class="btn btn-danger btn-sm">
                  <?php 
                  if($orlist->status()!=''){
               echo    ucfirst(strtolower($orlist->status()));
                 }else{
                   echo    ucfirst(strtolower('CANCELLED'));
                 }

                   ?>
                </button>
              @endif*/
              ?>
            </td>
          </tr>
        @endforeach
       @endif
     </tbody>
  </table>
</div>
<link rel="stylesheet" type="text/css" href="{{url('css/dataTables.bootstrap4.min.css')}}">
<script type="text/javascript" src="{{url('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#example').DataTable();
} );

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
</script>

<script type="text/javascript">
  $(document).ready(function(){

    $('input[name="from_date"], input[name="to_date"]').datepicker({
        defaultDate: "today",
        changeMonth: true,
        changeYear: true,
        yearRange: "{{ date('Y') - 20 }}:{{ date('Y') }}",
        numberOfMonths: 1,
        dateFormat: "dd-mm-yy",
    });

    $(document).on('click', '.search_orders', function(){
      var from_date = $('input[name="from_date"]').val();
      var to_date = $('input[name="to_date"]').val();
      window.location.href = '{{ url('/order') }}?fd=' + from_date + '&td=' + to_date;
    });

  });
</script>