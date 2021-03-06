@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.faqs.management') . ' | ' . trans('labels.backend.faqs.edit'))

@section('page-header')
    <h1>
        {{ trans('Faq') }}
    </h1>
@endsection

@section('content')
    {{ Form::model($faq, ['route' => ['admin.faqs.update', $faq], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-faqs']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Edit Faq') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.faqs.partials.faqs-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            {{-- Including Form blade file --}}
            <div class="box-body">
                <div class="form-group">
                    @include("backend.faqs.form")
                    <div class="edit-form-btn">
                    {{ link_to_route('admin.faqs.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!--box-->
    </div>
    {{ Form::close() }}
@endsection
