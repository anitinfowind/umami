@extends('frontend.layouts.app')
@section('content')
    <div class="dashboard-wrap">
        <div class="container">
            <div class="row">
                @include('frontend.user.sidebar')
                <div class="col-md-9">
                    <div class="dashboard-container">
                        <div class="panel panel-default my-order">
                            

                            <div class="table-responsive">
                                 <table id="example"class="table table-striped table-bordered"  data-order111="[[ 8, &quot;asc&quot; ]]">
                                    <thead>
                                      <tr>
                                       <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                     <tbody>
                                       
                                          @foreach($sales_reports as $repo)
                                          <tr>
                                           
                                            <td>{{ date('m-d-Y', strtotime($repo->from_date)) }}</td>
                                            <td>{{ date('m-d-Y', strtotime($repo->to_date)) }}</td>
                                            <td>{{ $repo->amount }}</td>
                                            <td>
                                              <a  class="dropdown-item getdetails" href="javascript:;" title="View Details" sales_report_id="{{ $repo->id }}">
                                                        <button class="btn btn-success btn-sm">View </button>
                                                      </a>
                                                      
                                              <!-- <ul class="navbar-nav mr-auto">
                                                  <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Action
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                      <a  class="dropdown-item getdetails" href="javascript:;" title="View Details" sales_report_id="{{ $repo->id }}">
                                                        <button class="btn btn-success btn-sm">View </button>
                                                      </a>
                                                    </div>
                                                  </li>
                                              </ul> -->
                                            </td>
                                          </tr>
                                        @endforeach
                                     </tbody>
                                  </table>
                                </div>

                                


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Sale Orders</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
      
      $(document).on('click', '.getdetails', function(){
        var sales_report_id = $(this).attr('sales_report_id');
        $.ajax({
          method: "GET",
          url: "{{ url('sales_payment') }}",
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
                amount = `<span class="text-danger">-` + v.amount + `</span>`;
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