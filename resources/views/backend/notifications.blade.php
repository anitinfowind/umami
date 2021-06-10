@extends('backend.layouts.app')

@section('page-header')
    <h1>
        Notifications
        <small></small>
    </h1>
@endsection
   
@section('content')
  <div class="box box-info">
      <div class="box-header with-border">
              <h3 class="box-title">Notifications</h3>

              <div class="box-tools pull-right">
                <!-- <div class="btn-group">
                  <button type="button" data-toggle="dropdown" class="btn btn-primary btn-flat dropdown-toggle" aria-expanded="false">Action
                    <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span></button> 
                    <ul role="menu" class="dropdown-menu">
                      <li><a href="javascript:;" class="add_testimonial"><i class="fa fa-plus"></i> Add New</a></li>
                    </ul>
                </div> --> 
                <div class="clearfix"></div>
              </div>
                <!--box-tools pull-right-->
          </div><!--box-header with-border-->
          <div class="box-body">
          <div class="table-responsive data-table-wrapper">
              <table id="example" class="table table-condensed table-hover table-bordered" data-order111="[[ 3, &quot;desc&quot; ]]">
                  <thead>
                      <tr>
                          <th>Title</th>
                          <th>{{ trans('labels.general.actions') }}</th>
                      </tr>
                  </thead>
                  <tbody>
                        @foreach($notifications as $ntf)
                          <tr>
                            <td>{{ $ntf->message }}</td>
                              <td>
                                <!-- <div class="btn-group dropup">
                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                  <span class="glyphicon glyphicon-option-vertical"></span>
                              </button>
                                <ul class="dropdown-menu dropdown-menu-right"> 
                                <li><a class="delete_notification text-danger" href="javascript:;" notification_id="{{ $ntf->id }}"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top"></i>Delete</a></li>
                                </ul>
                               </div> -->
                               <a class="btn btn-danger delete_notification" href="javascript:;" notification_id="{{ $ntf->id }}"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top"></i></a>
                              </td>
                          </tr>
                        @endforeach
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
    <script type="text/javascript">
      $(document).ready(function() {

        $(document).on('click', '.delete_notification', function(){
          var notification_id = $(this).attr('notification_id');
          if(confirm('Are you sure to delete this notification?')) {
            var url = '{{ url('admin/set_notification') }}';
            var data = new FormData();
            data.append('status', '1');
            data.append('notification_id', notification_id);
            data.append('_token', $('meta[name="csrf-token"]').attr('content'));
            $.ajax({type: 'POST', dataType: 'json', url: url, data: data, processData: false, contentType: false, success: function (data) {
                location.reload();
              }
            });
          }
        })

      });
    </script>
@endsection