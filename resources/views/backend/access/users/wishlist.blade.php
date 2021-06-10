@extends ('backend.layouts.app')

@section ('title', trans('User WishList') . ' | ' . trans('labels.backend.access.users.view'))

@section('page-header')
    <h1>
        {{ trans('Users') }}
    </h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('User WishList') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.access.includes.partials.user-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
               
                <div class="tab-content">
                  <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead class="thead-dark">
                      <tr>
                          <th>Image</th>
                          <th>Title </th>
                          <th>Category</th>
                          <th>Diet </th>
                          <th>Region </th>
                          <th>Price</th>
                      </tr>
                  </thead>
                  @if($favorites->isNotEmpty())
                   @foreach($favorites as $favorite)
                    <tr>
                        <td>
                         @if(!empty($favorite->product->singleProductImage->image) &&
                                  File::exists(PRODUCT_ROOT_PATH.$favorite->product->singleProductImage->image))
                              <?php $image = PRODUCT_URL.$favorite->product->singleProductImage->image; ?>
                          @else
                              <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                          @endif
                          <img class="resto product_list" src="{{ $image }}" alt="{{ $favorite->product->title() }}">
                        </td>
                        <td>{{ $favorite->product->title() }}</td>
                        <td>{{  $favorite->product->category->name() }}</td>
                        <td>{{ $favorite->product->diet->name() }}</td>
                        <td>{{ $favorite->product->region->name() }}</td>
                        <td>{{ $favorite->product->price() }}</td>
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