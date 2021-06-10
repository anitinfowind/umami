@extends ('backend.layouts.app')
@section ('title', trans('Vendor Payment'))
@section('page-header')
    <h1>{{ trans('Vendor Payment') }}</h1>
@endsection
@section('content')
    <div class="box box-info">
       
            <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
                   <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Amount</th>
                  <th>Vendor Name</th>
                  <th>Order ID</th>
                  <th>Date </th>
                  <th>Action </th>
                </tr>
              </thead>
              <tbody>
                @if($payments->isNotEmpty())
                  
                 <?php $i=1;
                  foreach($payments as $payment){
                  //dd($payment); 
                    ?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td>{{ $payment->price }}</td>
                    <td>
                      <?php //echo $vendor_name= isset($payment->vendor_name)? '<a href="' . url('user-detail/' . $payment->vendor_slug) . '" target="_blank">' . $payment->vendor_name . '</a>' :''; ?>
                      <?php echo $vendor_name= isset($payment->vendor_name)? '<a href="' . url('admin/products/create') . '" target="_blank">' . $payment->vendor_name . '</a>' :''; ?>
                    </td>
                      <td>{{ $payment->pay_order_id }}</td>
                      <td>{{ date('d-m-Y',strtotime($payment->created_at)) }}</td>
                      <td>  <a href="{{url('admin/paymenthistory/view/'. $payment->pay_order_id
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
@endsection
@section('after-scripts')
    {{ Html::script(mix('js/dataTable.js')) }}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endsection