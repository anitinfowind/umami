@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.vendors.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.vendors.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.vendors.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.vendors.partials.vendors-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
            <table id="example" class="table table-condensed table-hover table-bordered" style="width:100%">
                  <thead>
                      <tr>
                          <th>User Name</th>
                          <th>Product Name</th>
                          <th>Category</th>
                          <th>Price</th>
                          <th>Quantity</th>
                      </tr>
                  </thead>
                 <tbody>
                  @foreach($sellerproduct as $product)
                      <tr>
                          <td>{{checkUserName($product->user_id)}}</td>
                          <td>{{$product->name}}</td>
                          <td>{{checkCategoryName($product->category_id)}}</td>
                          <td>{{$product->price}}</td>
                          <td>{{$product->quantity}}</td>
                      </tr>
                    @endforeach  
                  </tbody>
              </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}
<script type="text/javascript">
  
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>

@endsection
