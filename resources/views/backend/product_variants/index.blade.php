@extends ('backend.layouts.app')
@section ('title', trans('Product Variants'))
@section('page-header')
    <h1>{{ trans('Product Variants') }}</h1>
@endsection
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                @include('backend.product_variants.partials.product-attribute-header-buttons')
            </div>
        </div>
            <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('Product Name') }}</th>
                            <th>{{ trans('Variant Name') }}</th>
                            <th>{{ trans('Price') }}</th>
                            <th>{{ trans('Status') }}</th>
                            <th>{{ trans('Created At') }}</th>
                            <th>{{ trans('Updated At') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($productVariants->isNotEmpty())
                            @foreach($productVariants as $productVariant)
                           
                                <tr>
                                   <td>{{ productName($productVariant->productId()) }}</td>
                                    <td>{{ $productVariant->variant_name() }}</td>
                                    <td>{{ $productVariant->price() }}</td>
                                    <td>
                                        @if($productVariant->isActive() == 1)
                                            <label class="label label-success">Active</label>
                                        @else
                                            <label class="label label-danger">Inactive</label>
                                        @endif               
                                    </td>
                                    <td>{{ $productVariant->createdAt() }}</td>
                                    <td>{{ $productVariant->updatedAt() }}</td>
                                    <td>
                                        <a href="{{ route("admin.productVariants.edit", $productVariant->id()) }}" class="btn btn-flat btn-default">
                                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-pencil" data-original-title="Edit"></i>
                                        </a>
                                        <a href="{{ route("admin.productVariants.delete", $productVariant->id()) }}" class="btn btn-flat btn-default" data-method="delete"
                                           data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-trash" data-original-title="Delete" aria-describedby="tooltip373985"></i>
                                            <div class="tooltip fade top" role="tooltip" id="tooltip373985" style="top: -27px; left: -12.3906px; display: block;">
                                                <div class="tooltip-arrow" style="left: 50%;"></div>
                                                <div class="tooltip-inner">Delete</div>
                                            </div>
                                        </a>
                                        @if($productVariant->isActive() == 1)
                                            <a href='{{ route("admin.productVariants.update-product-variants-status", [$productVariant->id(), 0]) }}' class="btn btn-flat
                                            btn-default">
                                                <i class="fa fa-square" data-toggle="tooltip" data-placement="top" title="Deactivate"></i>
                                            </a>
                                        @else
                                            <a href='{{ route("admin.productVariants.update-product-variants-status", [$productVariant->id(), 1]) }}' class="btn btn-flat
                                            btn-default">
                                                <i class="fa fa-check-square" data-toggle="tooltip" data-placement="top" title="activate"></i>
                                            </a>
                                        @endif
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