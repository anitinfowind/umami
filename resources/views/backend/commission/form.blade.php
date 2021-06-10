<div class="box-body">
    <div class="form-group">
        {{ Form::label('Owner comm', trans('Site Commission'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('site_commission', null, ['class' => 'form-control box-size', 'placeholder' => trans('Site Commission'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->


    <div class="form-group">
        {{ Form::label('vendor', trans('Vendor Commission'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('vendor_commission', null, ['class' => 'form-control box-size', 'placeholder' => trans('Vendor Commission'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->


   <!--  <div class="form-group">
        {{ Form::label('status', trans('validation.attributes.backend.faqs.status'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            <div class="control-group">
                <label class="control control--checkbox">
                    @if(isset($products->status))
                        {{ Form::checkbox('status', 1, $products->status == 1 ? true :false) }}
                    @else
                        {{ Form::checkbox('status', 1, true) }}
                    @endif
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div>
    </div> -->
</div>
@section('after-scripts')
    <script type="text/javascript">
        Backend.Faq.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');
    </script>


@endsection