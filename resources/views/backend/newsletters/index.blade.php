@extends ('backend.layouts.app')

@section ('title', trans('NewsLetter management'))

@section('page-header')
    <h1>{{ trans('NewsLetter management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('NewsLetter Email List') }}</h3>

            <div class="box-tools pull-right">
              {{-- @include('backend.chef.partials.chef-header-buttons')--}}
            </div>
        </div><!--box-header with-border-->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="example" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('S No.') }}</th>
                            <th>{{ trans('Created At') }}</th>
                             <th>{{ trans('Email') }}</th>
                        </tr>
                    </thead>
                     <tbody>
                      @if($newsletters->isNotEmpty())
                       @foreach($newsletters as $key=> $newsletter)
                          <tr>
                            <td> {{ $key+1 }}</td>
                            <td> {{ $newsletter->created_at}}</td>
                            <td> {{ $newsletter->email}}</td>
                          </tr>
                       @endforeach   
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
       $('#example').DataTable();
      } );
    </script>
@endsection
