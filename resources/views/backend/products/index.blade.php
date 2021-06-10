@extends ('backend.layouts.app')

@section ('title', trans('Products Management'))

@section('page-header')
    <h1>{{ trans('Products Management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('Products Management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.products.partials.products-header-buttons')
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example"class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                          <th style="display: none;"></th>
                            <th>{{ trans('Restaurant Name') }}</th>
                            <th>{{ trans('Product Name') }}</th>
                            <th>{{ trans('Category Name') }}</th>
                            <th>{{ trans('Brand') }}</th>
                            <th>{{ trans('Diet') }}</th>
                           <!--  <th>{{ trans('Region') }}</th> -->
                            <th>{{ trans('Image') }}</th>
                            <th>{{ trans('Price') }}</th>
                            <th>{{ trans('Quantity') }}</th> 
                            <th>{{trans('Status')}}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                           <!--  <th>
                              <form method="post">
                                <input type="hidden" class="adminstatus" name="status">
                                <button>Submit</button>
                              </form>
                            </th> -->
                        </tr>
                    </thead>
                    <tbody>
                      @if($products->isNotEmpty())
                       @foreach($products as $key=>$product)
                           <?php 
                            $ext = '';
                            if(isset($product->singleProductImage->image)) {
                              $info = pathinfo(PRODUCT_ROOT_PATH.$product->singleProductImage->image);
                               $ext = $info['extension'];
                             }
                               ?>
                            <tr>
                              <td style="display: none;">{{$key+1}}</td>
                                <td>{{restaurantName($product->restaurant_id)}} </td>
                                <td>{{ isset($product->title)?$product->title:''}}</td>
                                <td>
                                  @if($product->pCategory->isNotEmpty())
                                    @foreach($product->pCategory as $pcat)
                                     {{ isset($pcat->p_category->name)?$pcat->p_category->name:'' }} <br/>
                                    @endforeach
                                  @endif
                                </td>
                                <td>
                                 @if($product->pBrand->isNotEmpty())
                                    @foreach($product->pBrand as $pbrands)
                                      {{ isset($pbrands->p_brand->name)?$pbrands->p_brand->name:'' }}<br/>
                                    @endforeach
                                 @endif
                                </td>
                                <td>
                                   @if($product->pdiet->isNotEmpty())
                                     @foreach($product->pdiet as $pdits)
                                       {{ isset($pdits->p_diet->name)?$pdits->p_diet->name:'' }}<br/>
                                     @endforeach
                                   @endif
                                </td>
                                <td>
                                 @if($ext=='jpeg'||$ext=='jpg'||$ext=='png' ||$ext=='gif'||$ext=='webp') 
                                  @if(!empty($product->singleProductImage->image) &&
                                          File::exists(PRODUCT_ROOT_PATH.$product->singleProductImage->image))
                                      <?php $image = PRODUCT_URL.$product->singleProductImage->image; ?>
                                  @else
                                      <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                                  @endif
                                  <img class="resto product_list" src="{{ $image }}" alt="{{ $product->title() }}">
                                  @elseif($ext != '')
                                  <video width="100px" height="80px" muted loop  controls poster="{{url('thimbnailimage.png')}}"> 
                                  <source src="{{PRODUCT_URL.$product->singleProductImage->image}}" type="video/mp4">
                                  </video>

                                  @endif
                                </td>
                                <td>{{ $product->price}}</td>
                                <td>{{ $product->quantity}}</td>
                                <td>
                                  @if($product->product_admin_status == 1)
                                      <label class="label label-success">Publish</label>
                                  @else
                                      <label class="label label-danger">Pending</label>
                                  @endif
                                </td>
                                <td>
                                  <div class="btn-group action-btn">
                                   <a class="btn btn-default btn-flat" href="{{route('admin.products.view',$product)}}">
                                      <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-eye" data-original-title="View"></i>
                                   </a>
                                     <a class="btn btn-default btn-flat edit_product" href111="{{route('admin.products.edit',$product)}}" href="javascript:;" onclick1111="window.location.href='{{ url('admin/products/' . $product->id . '/edit?dt_page=') }}'" product_id="{{ $product->id }}">
                                          <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-pencil" data-original-title="Edit"></i>
                                     </a>
                                       <a href="{{ route('admin.products.delete',$product) }}" class="btn btn-flat btn-default" data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                          <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-trash" data-original-title="Delete" aria-describedby="tooltip373985"></i>
                                          <div class="tooltip fade top" role="tooltip" id="tooltip373985" style="top: -27px; left: -12.3906px; display: block;">
                                            <div class="tooltip-arrow" style="left: 50%;"></div>
                                            <div class="tooltip-inner">Delete</div>
                                            </div>
                                       </a>
                                      @if(!empty($product->price))
                                        @if($product->product_admin_status == 1)
                                         <a class="btn btn-default btn-flat" href="{{url('admin/products/status/'.$product->id.'/0')}}"><i class="fa fa-square" data-toggle="tooltip" data-placement="top" title="" data-original-title="Deactivate"></i></a>
                                         @else
                                         <a class="btn btn-default btn-flat" href="{{url('admin/products/status/'.$product->id.'/1')}}"><i class="fa fa-check-square" data-toggle="tooltip" data-placement="top" title="" data-original-title="Activate" aria-describedby="tooltip302972"></i><div class="tooltip fade top" role="tooltip"><div class="tooltip-inner">Activate</div></div></a>
                                         @endif
                                      @else
                                      <a class="btn btn-default btn-flat" id="btnSave" href="javascript:void(0)"><i class="fa fa-square" data-toggle="tooltip" data-placement="top" title="" data-original-title="Product Publish"></i></a>
                                      @endif  
                                 </div>
                                </td>
                                <!-- <td><input type="checkbox" name="ceck" class="publishdata" value="{{$product->id}}" @if($product->product_admin_status == 1) checked @endif></td> -->
                            </tr> 
                         @endforeach
                        @else
                        <td style="text-align: center;"> Product Not found</td>
                       @endif 
                    </tbody>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
     $(document).ready(function() {
        //$('#example').DataTable();

        var table = $('#example').DataTable();
        <?php if(isset($_GET['dt_page'])) { echo 'table.page(' . $_GET['dt_page'] . ').draw("page");'; } ?>

        $(document).on('click', '.edit_product', function(){
          var product_id = $(this).attr('product_id');
          var info = table.page.info();
          window.location.href = '{{ url('admin/products/') }}/' + product_id + '/edit?dt_page=' + info.page;
        });
        

    } );
$("#btnSave").click(function (e) {
    e.preventDefault();
       swal({
          title: 'Please enter product price first.',
          type: 'warning',
          confirmButtonColor: '#3085d6'
      }).then((value) => {
          if (value === "yes") {
            // Add Your Custom Code for CRUD
          }
          return false;
      });
  });

$('.publishdata').click(function(){
  var id= $(this).val();
 var diet = [];
  $("input").each(function() {
    if ($(this).is(':checked')) {
      var checked = ($(this).val());
      diet.push(checked);
    }
  });
  $('.adminstatus').val(diet);

});
</script>
@endsection
