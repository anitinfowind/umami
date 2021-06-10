@extends ('backend.layouts.app')
@section ('title', trans('Shippings Fee'))
@section('page-header')
    <h1>{{ trans('Shippings Fee') }}</h1>
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
                          <th>Title</th>
                          <th>Distance</th>
                          <th>Alaska 1 Day </th>
                          <th>Hawai 1 Day </th>
                          <th>Service 1 Day </th>
                          <th>Alaska 2 Day </th>
                          <th>Hawai 2 Day </th>
                          <th>Service 2 Day </th>
                          <th>Alaska 3 Day </th>
                          <th>Hawai 3 Day </th>
                          <th>Service 3 Day </th>
                          <th>Alaska Above 3 Day </th>
                          <th>Hawai Above 3 Day </th>
                          <th>Service Above 3 Day </th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($freeshippings->isNotEmpty())
                            @foreach($freeshippings as $key=>$freeshipping)
                                <tr>
                                  <td>{{$key+1}}</td>
                                  <td>
                                     {{ $freeshipping->title }}
                                    </td>
                                    <td>{{ $freeshipping->min_distance.'-'.$freeshipping->max_distance }}</td>
                                    <td>
                                      {{ $freeshipping->alaska_1day}}
                                    </td>
                                    <td>
                                      {{ $freeshipping->hawai_1day }}
                                    </td>
                                    <td>
                                      @if($freeshipping->service_1==1)
                                      1 Day Air Service
                                      @elseif($freeshipping->service_1==2)
                                      2 Day Air Service
                                      @else
                                      Ground Service
                                      @endif
                                     
                                    </td>
                                    <td>
                                      {{ $freeshipping->alaska_2day }}
                                    </td>
                                    <td>
                                      {{ $freeshipping->hawai_2day }}
                                    </td>
                                    <td>
                                       @if($freeshipping->service_2==1)
                                      1 Day Air Service
                                      @elseif($freeshipping->service_1==2)
                                      2 Day Air Service
                                      @else
                                      Ground Service
                                      @endif
                                    </td>
                                    <td>
                                      {{ $freeshipping->alaska_3day }}
                                    </td>
                                    <td>
                                      {{ $freeshipping->hawai_3day }}
                                    </td>
                                    <td>
                                      @if($freeshipping->service_3==1)
                                      1 Day Air Service
                                      @elseif($freeshipping->service_1==2)
                                      2 Day Air Service
                                      @else
                                      Ground Service
                                      @endif
                                    </td>
                                    <td>
                                      {{ $freeshipping->alaska_above }}
                                    </td>
                                     <td>
                                      {{ $freeshipping->hawai_above }}
                                    </td>
                                    <td>
                                      @if($freeshipping->service_above==1)
                                      1 Day Air Service
                                      @elseif($freeshipping->service_1==2)
                                      2 Day Air Service
                                      @else
                                      Ground Service
                                      @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/shippings/edit-shippingsfee/'. $freeshipping->id)}}" class="btn btn-flat btn-default">
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