@extends ('backend.layouts.app')
@section ('title', trans('Payment View'))
@section('page-header')
    <h1>{{ trans('Payment View') }}</h1>
@endsection
@section('content')


    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                @include('backend.paymenthistory.partials.paymenthistory-header-buttons')
            </div>
        </div>
            <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
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
                       <?php 
                       
                       $i=1;
                       

                $payment_data= $payments->orderDetails;
                  foreach($payment_data as $payment){
                  //print_r($payment->product->singleProductImage->image);die;
                   ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td>{{ $payment->product->title}}</td>
                    <td>{{ $payment->product->price }}</td
                      >
                      <td>@if(!empty($payment->product->singleProductImage->image))
                                      <?php $image = PRODUCT_URL.$payment->product->singleProductImage->image; ?>
                                    @else
                                      <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                                    @endif
                                  <img style="width:100px;height: 50px;" class="product_image_resto" src="{{ $image }}" alt="{{ $payment->product->title }}">
                                </td>
                      <td>{{ date('d-m-Y',strtotime($payment->created_at)) }}</td>
                     
                    </tr>
                    <?php $i++;?>
                   <?php } ?>
                    </tbody>
                </table>
            </div>

            <?php
            $state = App\Models\State::where('id', $payments->state_id)->first();
            ?>
            <div>
              <h4>Customer Details</h4>
              <p><u>Name:</u> {{ $payments->first_name . ' ' . $payments->last_name }}</p>
              <p><u>Email:</u> {{ $payments->email }}</p>
              <p><u>Phone:</u> {{ $payments->phone }}</p>
              <p><u>Address:</u> {{ $payments->street_address . ', ' . $payments->city . ', ' . $state->name . ' ' . $payments->zip_code }}</p>
            </div>

        </div>
    </div>
@endsection
@section('after-scripts')
    {{ Html::script(mix('js/dataTable.js')) }}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endsection