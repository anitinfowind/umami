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
                  <th>Merchant Name</th>
                  <th>Amount</th>
                  <th>Statement Month </th>
                  <th>Action </th>
                </tr>
              </thead>
              <tbody>
                @if($orders->isNotEmpty())
                  
                 <?php 
                 //$i=1;
                 // $payments = [0,0,0,0,0,0,0,0,0,0,0,0];
                 // $result=array();
                 //  foreach($orders as $order){ 

                 //    $payments[$order->monthKey-1] = $order->sums;
                   

                 //  }
                  foreach($orders as $key=> $reportvalue){
                   
                    ?>
                  

                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$reportvalue->vendor_name}}</td>
                    <td>$ {{$reportvalue->sums}}</td>
                    <td>{{$reportvalue->monthKey}}</td>
                    <td><a href="{{url('statement/view/'. $reportvalue->month.'/'.$reportvalue->year
                        )}}" title="view Statement">
              <button class="btn btn-success btn-sm">
                  View
                </button></a> </td>
                   <?php /* <td><?php echo $key+1;?></td>
                    <td>{{$orders[0]->vendor_name}}</td>
                    <td>$ {{$reportvalue}}</td>
                      <td><?php $monthNum  = $key+1;
              $dateObj   = DateTime::createFromFormat('!m', $monthNum);
          echo    $monthName = $dateObj->format('F');?>
            
          </td> */?>
                   <!--    <td>
                  
            {{ Form::open([
                'url' => 'report_download',
              ]
            )
          }}

          <input type="hidden" name="name" value="{{$reportvalue->vendor_name}}">
          <input type="hidden" name="month" value="{{isset($reportvalue->monthKey)?$reportvalue->monthKey:''}}">
          <input type="hidden" name="price" value="{{isset($reportvalue->sums)?$reportvalue->sums:0}}">
          

   <button class="btn btn-primary" type="submit" name="submit_dCSV" value="submit">Download</button>
  </form>
                      </td>
                    </tr>-->
                    
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