@extends ('backend.layouts.app')
@section ('title', trans('Payment history'))
@section('page-header')
<h1>{{ trans('Payment history') }}</h1>
@endsection
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <div class="box-tools pull-right"> @include('backend.paymenthistory.partials.paymenthistory-header-buttons') </div>
  </div>
  <div class="box-body">
    <div class="table-responsive data-table-wrapper">
      <table id="example" class="table table-condensed table-hover table-bordered">
        <thead>
          <tr>
            <th>Sr. No.</th>
            <th>Restaurant</th>
            <th>Products</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Pickup Date</th>
            <th>Delivery Date</th>
            <th>Retail Price</th>
            <th>Vendor sales</th>
            <th>Umami Sales</th>
            <th>Vendor Deduction</th>
            <th>Status</th>
            <th>UPS Tracking No</th>
            <th>Shipping Way</th>
            
            <th>Order Id</th>
            <th>Transction ID</th>
            <th>Refund ID</th>
            <th>Action </th>
          </tr>
        </thead>
        <tbody>
        
        @if($payments->isNotEmpty())
        <?php $i=1;
                  foreach($payments as $payment){ 
                    //dd($payment);
                    //dd($payment->restaurant);
                    //dd($payment->order->orderDetails);
                    ?>
          <?php
          $retail_price = $vendor_payable = $umami_fees = 0;
            foreach ($payment->order->orderDetails as $ok => $ov) {
              $retail_price += $ov->price * $ov->quantity;
              $vendor_payable += ($ov->price - $ov->included_shipping_price) * $ov->quantity;
              $umami_fees += $ov->included_shipping_price * $ov->quantity;
            }
            ?>
        <tr>
          <td data-order="<?php echo $i;?>"><?php echo $i;?>
            {!! $payment->sales_reported == 1 ? '<span class="label label-success"><i class="fa fa-check"></i> Sales Report</span>' : '' !!}
          </td>
          
          <td>{{ $payment->restaurant->name }}
            <?php
          $weekdays = [['title' => 'Mon'], ['title' => 'Tue'], ['title' => 'Wed'], ['title' => 'Thu'], ['title' => 'Fri'], ['title' => 'Sat'], ['title' => 'Sun']];
          $shipping_info = json_decode($payment->restaurant->shipping_info, true);
          foreach ($shipping_info['pickuptime'] as $shk => $shv) {
            if(isset($shv['enabled']) && $shv['enabled'] == '1') {
              echo '<br>' . $weekdays[$shk]['title'] . ': ' . $shv['start_time'] . ' - ' . $shv['end_time'];
            }
          }
          ?>
          </td>
          <td>
            <?php
            foreach ($payment->order->orderDetails as $ok => $ov) {
              echo '<p>' . $ov->product->title . ' x ' . $ov->quantity . '</p>';
            }
            ?>
          </td>
          <td>{{ $payment->order->first_name }} {{ $payment->order->last_name }}
            <br>{{ $payment->order->email }}
            <br>Phone: {{ $payment->order->phone }}
            <br>Address: {{ $payment->order->street_address }}, {{ $payment->order->address_line_2 }}, {{ $payment->order->city }}, {{ $payment->state_name }} {{ $payment->order->zip_code }} 
          </td>
          <td>{{ date('m-d-Y',strtotime($payment->order->order_date)) }}</td>
          <td>{{ date('m-d-Y',strtotime($payment->order->pickup_date)) }}</td>
          <td>{{ date('m-d-Y',strtotime($payment->order->delivery_date)) }}</td>
          <td>{{ $retail_price }}</td>
          <td>{{ $vendor_payable }}</td>
          <td>{{ $umami_fees }}</td>
          <td>{{ $payment->sales_deduction }}<br>{{ $payment->sales_deduction_info }}<br>
            <a href="javascript:;" class="sales_deduction_edit" payment_id="{{ $payment->id }}">Edit</a>
          </td>
          <td>
            <?php
            if($payment->order->status == 'DELIVERED') echo 'Shipped';
            else echo ucfirst(strtolower($payment->order->status));
            ?>
            <br>
            <?php if($payment->order->status == 'PENDING') { ?>
              <!-- <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $payment->order->id }}", "{{ PACKED }}")' style="padding: 0;">
                <button class="btn btn-info btn-sm">
                  Packed
                </button> 
              </a> -->
              <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $payment->order->id }}", "{{ DELIVERED }}")' style="padding: 0;">
                <button class="btn btn-warning btn-sm">
                  Shipped
                </button> 
              </a>
            <?php } ?>
            <?php if($payment->order->status == 'PACKED') { ?>
              <a class="dropdown-item" href="javascript::void(0)" onclick='orderStatus("{{ $payment->order->id }}", "{{ DELIVERED }}")' style="padding: 0;">
                <button class="btn btn-warning btn-sm">
                  Shipped
                </button> 
              </a>
            <?php } ?>
          </td>
          <td><a href="{{ url('track-order', \Crypt::encryptString($payment->order->id)) }}" target="_blank">{{ $payment->order->tracking_id }}</a></td>
          <td>
            <?php
            foreach (ups_service_codes() as $sk => $sv) {
              if($payment->order->ups_service_code == $sv['service_code'])
                echo $sv['title'];
            }
            ?>
          </td>
          
          <td>{{ $payment->order_id }}{!! $payment->order_status == 'CANCELLED' ? '<br><i class="badge badge-secondary">CANCELLED</i>' : '' !!}</td>
          <td>{{ $payment->transaction_id }}</td>
          <td>{{ $payment->refund_id }}
            <?php
            if($payment->refund_id != '')
              echo '<br>' . $payment->refund_amount . '<br>' . $payment->refund_info;
            ?>
          </td>
          <td><a href="{{url('admin/paymenthistory/view/'. $payment->order_id
                          )}}" title="Track Order">
            <button class="btn btn-success btn-sm"> View </button>
            </a>
            <a href="javascript:;" title="" class="getlabel" payment_id="{{ $payment->id }}"><button class="btn btn-primary btn-sm"> Label </button></a>
            <?php if($payment->refund_id == '') { ?>
            <a href111="{{url('admin/paymenthistory/refund/'. $payment->id
                          )}}" href="javascript:;" class="refund_payment" onclick111="return confirm('Are you sure to refund this payment?');" refund_amount="{{ $payment->amount }}" payment_id="{{ $payment->id }}">
            <button class="btn btn-danger btn-sm">Refund</button>
            </a>
            <?php } ?>
            <a href="{{url('admin/paymenthistory/delete/'. $payment->order->id)}}" onclick="return confirm('Are you sure to delete this payment and order?');"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button></a>
          </td>
            
        </tr>
        <?php $i++;?>
        <?php } ?>
        @endif
          </tbody>
        
      </table>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Order Label</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-12">
            <select class="form-control" name="ups_service_code">
              <option value="">--- Select service ---</option>
              <!-- <option value="11">UPS Standard (11)</option>
              <option value="03">UPS Ground (03)</option>
              <option value="12">UPS 3 Day Select (12)</option>
              <option value="02">UPS 2nd Day Air (02)</option>
              <option value="59">UPS 2nd Day Air AM (59)</option>
              <option value="13">UPS Next Day Air Saver (13)</option>
              <option value="01">UPS Next Day Air (01)</option>
              <option value="14">UPS Next Day Air Early A.M. (14)</option>
              <option value="07">UPS Worldwide Express (07)</option>
              <option value="54">UPS Worldwide Express Plus (54)</option>
              <option value="08">UPS Worldwide Expedited (08)</option>
              <option value="65">UPS World Wide Saver (65)</option> -->
              <?php
              foreach (ups_service_codes() as $key => $value) {
                echo '<option value="' . $value['service_code'] . '">' . $value['title'] . ' (' . $value['service_code'] . ')</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-12 col-12">
            <input type="hidden" name="payment_id" value="" />
            <a href="javascript:;" class="btn btn-sm btn-primary mt-10 change_ups_service">Change UPS Service</a>
          </div>
        </div>
        <div class="label_image"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>



<div class="modal fade" id="sdModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Vendor Sales Deduction</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-12">
            <div class="form-group">
              <label>Deduction Amount</label>
              <input type="text" class="form-control" name="sales_deduction" value="" />
            </div>
            <div class="form-group">
              <label>Deduction Info</label>
              <input type="text" class="form-control" name="sales_deduction_info" value="" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-12">
            <input type="hidden" name="payment_id" value="" />
            <a href="javascript:;" class="btn btn-sm btn-primary mt-10 change_sales_deduction">Update</a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>



<div class="modal fade" id="refundModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Refund Payment</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-12">
            <div class="form-group">
              <label>Refund Amount</label>
              <input type="text" class="form-control" name="refund_amount" value="" />
            </div>
            <div class="form-group">
              <label>Refund Info</label>
              <input type="text" class="form-control" name="refund_info" value="" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-12">
            <input type="hidden" name="payment_id" value="" />
            <a href="javascript:;" class="btn btn-sm btn-primary mt-10 refund_payment_process">Refund Payment</a>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>


@endsection
@section('after-scripts')

<style type="text/css">
  .dataTables_wrapper .col-sm-12 {
    overflow-x: scroll;
  }
</style>

    {{ Html::script(mix('js/dataTable.js')) }} 
<script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({responsive: true});
        } );
    </script> 
<script type="text/javascript">
function orderStatus(orderId, status)
{
  if(confirm("Are you sure? You want to be " +status.toLowerCase()+ " this order.")) {
    $.ajax({
      headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
      url: "{{ url('admin/paymenthistory/change-status') }}",
      data: {'order_id' : orderId, 'status' : status},
      method: 'POST',
      beforeSend: function () {
        $("#overlay").show();
      },
      success: function(data) {
        $("#overlay").hide();
        location.reload();
      }
    });
  }

}


  $(document).ready(function(){

    $(document).on('click', '.getlabel', function(){
      var payment_id = $(this).attr('payment_id');
      $('#myModal .modal-body input[name="payment_id"]').val(payment_id);
      $.ajax({
        method: "GET",
        url: "{{ url('admin/paymenthistory/label') }}/" + payment_id,
        data: {},
        success: function (data) {
          //console.log(data.data.label_image);
          $("#myModal .modal-body .label_image").html('<img style="height: auto;max-width: 100%;margin: 20px auto;text-align: center;  display: block;" src="data:image/png;base64,' + data.data.label_image + '">');
          $("#myModal").modal();
        }
      });
    });

    $(document).on('click', '.change_ups_service', function(){
      var ups_service_code = $('#myModal .modal-body select[name="ups_service_code"]').val();
      var payment_id = $('#myModal .modal-body input[name="payment_id"]').val();
      if(ups_service_code != '') {
        $.ajax({
          method: "POST",
          url: "{{ url('admin/paymenthistory/change-label') }}",
          data: {payment_id: payment_id, ups_service_code: ups_service_code},
          success: function (data) {
            $("#myModal").modal('hide');
          }
        });
      }
    });

    
    $(document).on('click', '.sales_deduction_edit', function(){
      var payment_id = $(this).attr('payment_id');
      $('#sdModal .modal-body input[name="payment_id"]').val(payment_id);
      $.ajax({
        method: "GET",
        url: "{{ url('admin/paymenthistory/details') }}/" + payment_id,
        data: {},
        success: function (data) {
          //console.log(data.data.label_image);
          var payhis = data.data.payment_history;
          $('#sdModal .modal-body input[name="sales_deduction"]').val(payhis.sales_deduction);
          $('#sdModal .modal-body input[name="sales_deduction_info"]').val(payhis.sales_deduction_info);
          $("#sdModal").modal();
        }
      });
    });

    $(document).on('click', '.change_sales_deduction', function(){
      var sales_deduction = $.trim($('#sdModal .modal-body input[name="sales_deduction"]').val());
      var sales_deduction_info = $.trim($('#sdModal .modal-body input[name="sales_deduction_info"]').val());
      var payment_id = $('#sdModal .modal-body input[name="payment_id"]').val();
      $.ajax({
        method: "POST",
        url: "{{ url('admin/paymenthistory/change-sales-deduction') }}",
        data: {payment_id: payment_id, sales_deduction: sales_deduction, sales_deduction_info: sales_deduction_info},
        success: function (data) {
          location.reload();
        }
      });
    });

    
    $(document).on('click', '.refund_payment', function(){
      var payment_id = $(this).attr('payment_id');
      var refund_amount = $(this).attr('refund_amount');
      $('#refundModal .modal-body input[name="refund_amount"]').val(refund_amount).attr('max_amount', refund_amount);
      $('#refundModal .modal-body input[name="payment_id"]').val(payment_id);
      $("#refundModal").modal();
    });

    $(document).on('click', '.refund_payment_process', function(){
      var refund_amount = parseFloat($.trim($('#refundModal .modal-body input[name="refund_amount"]').val()));
      var refund_info = $.trim($('#refundModal .modal-body input[name="refund_info"]').val());
      var payment_id = $('#refundModal .modal-body input[name="payment_id"]').val();
      var max_amount = parseFloat($('#refundModal .modal-body input[name="refund_amount"]').attr('max_amount'));
      if(refund_amount == '' || isNaN(refund_amount) || refund_amount > max_amount) {
        alert('Enter valid refund amount');
        return false;
      }
      $.ajax({
        method: "POST",
        url: "{{ url('admin/paymenthistory/refund-payment') }}",
        data: {payment_id: payment_id, refund_amount: refund_amount, refund_info: refund_info},
        success: function (data) {
          location.reload();
        }
      });
    });

  });
</script>
@endsection