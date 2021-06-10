@extends ('backend.layouts.app')

@section ('title', trans('Chef view') . ' | ' . trans('Chef view'))
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('Chef view') }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-striped table-hover">
            <tr>
                <th>{{ trans('Name') }}</th>
                <td>{{ isset($chef->name)?$chef->name:'--' }}</td>
            </tr>

            <tr>
                <th>{{ trans('Email') }}</th>
                <td>{{ $chef->email }}</td>
            </tr>
             <tr>
                <th>{{ trans('Designation') }}</th>
                <td>{{ $chef->designation }}</td>
            </tr>
            <tr>
                <th>{{ trans('Description') }}</th>
                <td>  {!! isset($chef->description)?$chef->description:''!!}</td>
            </tr>

         </table>
          
          <p>&nbsp;</p>
           <div class="form-group">
              {{ Form::label('Images', trans('Images'), ['class' => 'col-lg-2 control-label']) }}

              <div class="col-lg-10">
              
                  @if(!empty($chef->image) &&
                          File::exists(CHEF_ROOT_PATH.$chef->image))
                      <?php $image = CHEF_URL.$chef->image; ?>
                  @else
                      <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                  @endif
                  <img class="resto" width="300px" src="{{ $image }}" alt="{{}}">
              
            
              </div><!--col-lg-10-->
          </div><!--form control-->
        </div><!-- /.box-body -->
    </div><!--box-->
@endsection