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
                  								<span>
                  								<a href="{{ url('add-coupon') }}">
                  								<button type="button" class="btn add-product">+ Add Coupon</button>
                  								</a>
                  								</span>
                                </div>
                            </div>
                            <div class="table-responsive">
                              <table class="table product-table">
                                  <thead class="thead-dark">
                                      <tr>
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
                                      @foreach($coupons as $coupon)
                                        <tr class="coupon_{{$coupon->id}}">
                                            <td>{{ $coupon->couponcode() }}</td>
                                            <td>{{ ucfirst(strtolower($coupon->discount_type)) }}</td>
                                            <td>{{ $coupon->discount ?? ZERO }}{{PERCENTAGE}}</td>
                                            <td>
                                              @if(!empty($coupon->min_price )){{CURRENCY}}{{ $coupon->min_price }}
                                              @endif </td>
                                            <td>{{ $coupon->startDate() }}</td>
                                            <td>{{ $coupon->endDate() }}</td>
                                            
                                            <td>
                                                <div class="action-icon">
                                                    <a href="{{ url('edit-coupon/'. $coupon->id)}}">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>
                                                    <a href="javascript:void(0)"  onclick='removeCoupon("{{ $coupon->id}}")'>
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                      @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8">
                                                <h6 class="text-center">No Record Found</h6>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                              </table>
                          </div>
                           @include('frontend.pagination.pagination', ['paginator' => $coupons])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection