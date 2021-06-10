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
              </div>
            </div>
            <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Total Amount</th>
                  <th>Paid Amount</th>
                  <th>Tax Amount</th>
                  <th>Sipping Charge</th>
                  <th>Discount Amount</th>
                  <th>Transction ID</th>
                  <th>Date </th>
                  <th>Action </th>
                </tr>
              </thead>
              <tbody>
                @if($payments->isNotEmpty())
                  
                 <?php $i=1;
                  foreach($payments as $payment){ ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td>{{ $payment->product_amount}}</td>
                    <td>{{ $payment->amount}}</td>
 					<td>{{ $payment->tax_ammount }}</td>
 					<td>{{ $payment->shipping_charge }}</td>
                     <td>{{ $payment->discount_price }}</td
                      >
                      <td>{{ $payment->transaction_id }}</td>
                      <td>{{ date('m-d-Y',strtotime($payment->created_at)) }}</td>
                      <td>  <a href="{{url('payment-history/view/'. $payment->order_id
                        )}}" title="Track Order">
              <button class="btn btn-success btn-sm">
                  View
                </button> 
              </a></td>
                    </tr>
                    <?php $i++;?>
                   <?php } ?>
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