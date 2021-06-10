@extends ('backend.layouts.app')
@section ('title', trans('Shippings'))
@section('page-header')
    <h1>{{ trans('Shippings') }}</h1>
@endsection
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                @include('backend.shippings.partials.shippings-header-buttons')
            </div>
        </div>
            <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                          <th>Sr No.</th>
                          <th>Service days</th>
                          <th>Service Name</th>
                          <th>Price </th>
                          <th>Created Date </th>
                          <th>Updated Date </th>
                          <th>Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($shippings->isNotEmpty())
                            @foreach($shippings as $key=>$shipping)
                                <tr>
                                  <td>{{$key+1}}</td>
                                    <td>{{ $shipping->day }}</td>
                                    <td>
                                     {{ $shipping->service_name }}
                                    </td>
                                   <td>{{ $shipping->price }}</td>
                                    
                                    
                                    <td>
                                      {{ $shipping->created_at}}
                                    </td>
                                    <td>
                                      {{ $shipping->updated_at }}
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/shippings/edit-shippings/'. $shipping->id)}}" class="btn btn-flat btn-default">
                                            <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-pencil" data-original-title="Edit"></i>
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