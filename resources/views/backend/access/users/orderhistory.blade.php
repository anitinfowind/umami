@extends ('backend.layouts.app')

@section ('title', trans('Order History') . ' | ' . trans('labels.backend.access.users.view'))

@section('page-header')
    <h1>
        {{ trans('Users Order') }}
    </h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('Order History') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.access.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
               
                <div class="tab-content">
                 <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead class="thead-dark">
                      <tr>
                          <th>Product</th>
                          <th>Order Id</th>
                          <!-- <th>Price</th> -->
                          <th>Quantity</th>
                          <th>Total Price</th>
                          <th>Payment Type</th>
                          <th>Status</th>
                          <th>Order Date</th>
                         
                      </tr>
                  </thead>
                  @if($orderhistory->isNotEmpty())
                   @foreach($orderhistory as $order)
                    @php
                      $totalqty=0;
                      $totalprice=0;
                      $price=0;
                    @endphp

                    @foreach($order->orderDetails as $orderdata)
                    <?php
                        $price=$orderdata->price;
                        $totalqty=$orderdata->quantity+$totalqty;
                        $totalprice=$orderdata->total+$totalprice;?>
                    @endforeach
                    <tr>
                      <td>
                        <a href="{{ url('product-detail',$order->product->slug()) }}">
                          {{ $order->product->title() }}
                        </a>
                      </td>
                      <td>{{ $order->orderId() }}</td>
                      <td>{{  $totalqty }}</td>
                      <td>{{ $totalprice }}</td>
                      <td>{{ $order->paymentType() }}</td>
                      <td>
                        @if($order->status() == PENDING)
                          <button class="btn btn-primary btn-sm">
                            {{ ucfirst(strtolower($order->status())) }}
                          </button>
                        @elseif($order->status() == PACKED)
                          <button class="btn btn-info btn-sm">
                            {{ ucfirst(strtolower($order->status())) }}
                          </button> 
                        @elseif($order->status() == SHIPPED)
                          <button class="btn btn-warning btn-sm">
                            {{ ucfirst(strtolower($order->status())) }}
                          </button> 
                        @elseif($order->status() == DELIVERED)
                          <button class="btn btn-success btn-sm">
                            {{ ucfirst(strtolower($order->status())) }}
                          </button>
                        @else
                          <button class="btn btn-danger btn-sm">
                            {{ ucfirst(strtolower($order->status())) }}
                          </button>
                        @endif
                      </td>
                      <td>{{ $order->createdAt() }}</td>
                    <!--   <td>
                        <a href="{{ url('track-order', \Crypt::encryptString($order->id())) }}" title="Track Order">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        @if($order->status() == PENDING)
                          <a href="javascript::void(0)" onclick='orderCancel("{{ $order->id() }}")' title="Cancel Order">
                            <i class="fa fa-ban" aria-hidden="true"></i>
                          </a>
                        @endif
                      </td> -->
                    </tr>
                   @endforeach
                   @else
                   <td colspan="6">
                   <h4 style="text-align: center;"> Record not found </h4></td>
                  @endif
                </table>


            </div><!--tab panel-->

        </div><!-- /.box-body -->
    </div><!--box-->
@endsection
@section('after-scripts')
    {{ Html::script(mix('js/dataTable.js')) }}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endsection