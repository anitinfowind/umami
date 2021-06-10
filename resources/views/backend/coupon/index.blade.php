@extends ('backend.layouts.app')
@section ('title', trans('Coupon'))
@section('page-header')
    <h1>{{ trans('Coupons') }}</h1>
@endsection
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                @include('backend.coupon.partials.coupon-header-buttons')
            </div>
        </div>
            <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                          <th>Sr No.</th>
                          <th>Coupon code</th>
                          <th>Discount Type</th>
                          <th>Discount </th>
                          <th>Minimum Price </th>
                          <th>Start Date </th>
                          <th>End Date </th>
                          <th>Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($coupons->isNotEmpty())
                            @foreach($coupons as $key=>$coupon)
                                <tr>
                                  <td>{{$coupons->firstItem()+$key}}</td>
                                    <td>{{ $coupon->couponcode() }}</td>
                                    <td>
                                     {{ ucfirst(strtolower($coupon->discount_type)) }}
                                    </td>
                                    <?php if($coupon->discount_type=='FIXED'){ $dicountval="".CURRENCY."";}else{$dicountval="".PERCENTAGE."";} ?>
                                    <td>{{ $coupon->discount ?? ZERO }}{{$dicountval}}</td>
                                    <td>
                                     @if(!empty($coupon->min_price )){{CURRENCY}}{{ $coupon->min_price }}
                                      @endif
                                    </td>
                                    <td>{{ date('M-d-Y',strtotime($coupon->startDate())) }}
                                    
                                    </td>
                                    <td>
                                      {{ date('M-d-Y',strtotime( $coupon->endDate())) }}
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/coupon/edit-coupon/'. $coupon->id)}}" class="btn btn-flat btn-default">
                                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-pencil" data-original-title="Edit"></i>
                                        </a>
                                        <a href="{{ route("admin.coupon.delete", $coupon->id) }}" class="btn btn-flat btn-default" data-method="delete"
                                           data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-trash" data-original-title="Delete" aria-describedby="tooltip373985"></i>
                                            <div class="tooltip fade top" role="tooltip" id="tooltip373985" style="top: -27px; left: -12.3906px; display: block;">
                                                <div class="tooltip-arrow" style="left: 50%;"></div>
                                                <div class="tooltip-inner">Delete</div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
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