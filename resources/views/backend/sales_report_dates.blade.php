@extends('backend.layouts.app')

@section('page-header')
    <h1>
        Sales Reports
        <small></small>
    </h1>
@endsection

<?php
$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';
?>
   
@section('content')
  <div class="box box-info">
      <div class="box-header with-border">
              <h3 class="box-title">Sales Reports {{ ($from_date != '' && $to_date != '' ? date('m-d-Y', strtotime($from_date)) . ' - ' . date('m-d-Y', strtotime($to_date)) : '') }}</h3>

              <div class="box-tools pull-right">
               
              </div><!--box-tools pull-right-->
          </div><!--box-header with-border-->
          <div class="box-body">

            <?php if($from_date != '' && $to_date != '') { ?>
              <div class="table-responsive data-table-wrapper">
                  <table id="example" class="table table-condensed table-hover table-bordered" data-order111="[[ 3, &quot;desc&quot; ]]">
                      <thead>
                          <tr>
                              <th>Restaurant</th>
                              <th>Amount</th>
                              <th>{{ trans('labels.general.actions') }}</th>
                          </tr>
                      </thead>
                      <tbody>
                            @foreach($sales_report_dates as $repo)
                              <tr>
                                <td>{{ $repo->restaurant_name }}</td>
                                  <td>{{ $repo->amount }}</td>
                                  <td>
                                    <a class="btn btn-primary getdetails" href="javascript:;" sales_report_id="{{ $repo->id }}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top"></i></a>
                                    
                                    <!-- <div class="btn-group dropup">
                                    <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                      <span class="glyphicon glyphicon-option-vertical"></span>
                                  </button>
                                    <ul class="dropdown-menu dropdown-menu-right"> 
                                    
                                      <li><a class="getdetails" href="javascript:;" sales_report_id="{{ $repo->id }}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top"></i>View</a></li>
                                    </ul>
                                   </div> -->
                                  </td>
                              </tr>
                            @endforeach
                      </tbody>
                  </table>
              </div>
            <?php } else { ?>
              <div class="table-responsive data-table-wrapper">
                  <table id="example" class="table table-condensed table-hover table-bordered" data-order111="[[ 3, &quot;desc&quot; ]]">
                      <thead>
                          <tr>
                              <th>From Date</th>
                              <th>To Date</th>
                              <th>{{ trans('labels.general.actions') }}</th>
                          </tr>
                      </thead>
                      <tbody>
                            @foreach($sales_report_dates as $repo)
                              <tr>
                                <td>{{ date('m-d-Y', strtotime($repo->from_date)) }}</td>
                                  <td>{{ date('m-d-Y', strtotime($repo->to_date)) }}</td>
                                  <td>
                                    <a class="btn btn-primary" href="{{ url('/admin/sales_report_dates?from_date=' . $repo->from_date . '&to_date=' . $repo->to_date) }}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top"></i></a>

                                    <!-- <div class="btn-group dropup">
                                    <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                      <span class="glyphicon glyphicon-option-vertical"></span>
                                  </button>
                                    <ul class="dropdown-menu dropdown-menu-right"> 
                                    
                                    <li><a href="{{ url('/admin/sales_report_dates?from_date=' . $repo->from_date . '&to_date=' . $repo->to_date) }}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top"></i>View</a></li>
                                    </ul>
                                   </div> -->
                                  </td>
                              </tr>
                            @endforeach
                      </tbody>
                  </table>
              </div>
            <?php } ?>

          
      </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sale Orders</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
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
    <script type="text/javascript">
      $(document).ready(function() {

        $(document).on('click', '.getdetails', function(){
          var sales_report_id = $(this).attr('sales_report_id');
          $.ajax({
            method: "GET",
            url: "{{ url('admin/get_sales_report_payments') }}",
            data: {'sales_report_id': sales_report_id},
            success: function (data) {
              //console.log(data.data.sales_report_payments);
              var html = `<div class="table-responsive data-table-wrapper">
              <table class="table table-condensed table-hover table-bordered">
                <thead><tr><th>Order ID</th><th>Amount</th><th>Refunded</th><th>Deduction</th></tr></thead>
                <tbody>`;
              var total_amount = 0;
              var total_refunded = 0;
              var gross_amount = 0;
              $(data.data.sales_report_payments).each(function(i, v){
                var amount = '';
                var refunded = '';
                if(v.status == '1') {
                  amount = `<span class="">` + v.amount + `</span>`;
                  total_amount += parseFloat(v.amount);
                }
                if(v.status == '0') {
                  amount = `<span class="text-red">-` + v.amount + `</span>`;
                  refunded = `<i class="fa fa-check"></i>`;
                  total_refunded += parseFloat(v.amount);
                }
                html += `<tr><td>` + v.order_id + `</td><td>` + amount + `</td><td>` + refunded + `</td><td>` + (v.sales_deduction > 0 ? v.sales_deduction + '<br>' + v.sales_deduction_info : '') + `</td></tr>`;
                gross_amount += parseFloat(v.amount);
              });
              html += `</tbody></table></div><h4>Total: ` + gross_amount + `</h4><h4>Refunds: -` + total_refunded + `</h4><h4>Total Payable: ` + total_amount + `</h4>`;
              $("#myModal .modal-body").html(html);
              $("#myModal").modal();
            }
          });
        });

      });
    </script>
@endsection