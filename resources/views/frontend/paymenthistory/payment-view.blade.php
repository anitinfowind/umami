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
            <table id="example"class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Product Name</th>
                  <th>Product Amount</th>
                  <th>Product Image</th>
                  <th>Date </th>
                
                </tr>
              </thead>
              <tbody>
               @if($payments)
                  
                 <?php $i=1;
                $payment_data= $payments->orderDetails;
                  foreach($payment_data as $payment){
                  //print_r($payment->product->singleProductImage->image);die;
                   ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td>{{ isset($payment->product->title)?$payment->product->title:''}}</td>
                    <td>{{ ($payment->total - $payment->included_shipping_price) }}</td
                      >
                      <td>@if(!empty($payment->product->singleProductImage->image))
                                      <?php $image = PRODUCT_URL.$payment->product->singleProductImage->image; ?>
                                    @else
                                      <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                                    @endif
                                  <img style="width:100px;height: 50px;" class="product_image_resto" src="{{ $image }}" alt="{{ isset($payment->product->title)?$payment->product->title:'' }}">
                                </td>
                      <td>{{ date('m-d-Y',strtotime($payment->created_at)) }}</td>
                     
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
  <script type="text/javascript" src="{{url('js/
  jquery.dataTables.min.js')}}"></script>
  <script type="text/javascript" src="{{url('js/dataTables.bootstrap4.min.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable();
    } );
  </script>
  @endsection