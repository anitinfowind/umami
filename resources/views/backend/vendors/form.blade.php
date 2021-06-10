<div class="box-body">

  <input type="hidden" value="2" name="assignees_roles[]" id="role-2" checked="checked" class="get-role-for-permissions">
  <input type="hidden" name="permissions[2]" value="2" id="perm_2" checked="checked">
    <div class="form-group">
        {{ Form::label('First Name', trans('validation.attributes.backend.access.users.firstName'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('first_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.users.firstName'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->
    {{-- Last Name --}}
    <div class="form-group">
        {{ Form::label('Last Name', trans('validation.attributes.backend.access.users.lastName'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('last_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.users.lastName'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->
    {{-- Email --}}
    <div class="form-group">
        {{ Form::label('email', trans('validation.attributes.backend.access.users.email'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.users.email'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->  
    @if(empty($vendors))  
    {{-- Password --}}
    <div class="form-group">
        {{ Form::label('password', trans('validation.attributes.backend.access.users.password'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::password('password', ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.users.password'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->
    {{-- Password Confirmation --}}
    <div class="form-group">
        {{ Form::label('password_confirmation', trans('validation.attributes.backend.access.users.password_confirmation'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::password('password_confirmation', ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.users.password_confirmation'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->  
    @endif  
     {{-- Status --}}
      <div class="form-group">
          {{ Form::label('status', trans('validation.attributes.backend.access.users.active'), ['class' => 'col-lg-2 control-label']) }}

          <div class="col-lg-1">
                      <div class="control-group">
                          <label class="control control--checkbox">
                              {{ Form::checkbox('status', '1', true) }}
                          <div class="control__indicator"></div>
                          </label>
                      </div>
          </div><!--col-lg-1-->
      </div><!--form control-->
      {{-- Confirmed --}}
      <div class="form-group">
          {{ Form::label('confirmed', trans('validation.attributes.backend.access.users.confirmed'), ['class' => 'col-lg-2 control-label']) }}

          <div class="col-lg-1">
               <div class="control-group">
                  <label class="control control--checkbox">
                    @if(isset($vendors->confirmed))
                    {{ Form::checkbox('confirmed', '1', $vendors->confirmed == 1) }}
                    @else
                        {{ Form::checkbox('confirmed', '1', true) }}
                    @endif
                     
                     
                      <div class="control__indicator"></div>
                  </label>
              </div>
          </div><!--col-lg-1-->
      </div><!--form control--> 
     {{-- Confirmation Email --}}
    <div class="form-group">
        <label class="col-lg-2 control-label">{{ trans('validation.attributes.backend.access.users.send_confirmation_email') }}<br/>
            <small>{{ trans('strings.backend.access.users.if_confirmed_off') }}</small>
        </label>

        <div class="col-lg-1">
            <div class="control-group">
                <label class="control control--checkbox">
                    {{ Form::checkbox('confirmation_email', '1') }}
                    <div class="control__indicator"></div>
                </label>
            </div>
        </div><!--col-lg-1-->
    </div><!--form control-->           
</div><!--box-body-->

@section("after-scripts")
    <script type="text/javascript">
        //Put your javascript needs in here.
        //Don't forget to put `@`parent exactly after `@`section("after-scripts"),
        //if your create or edit blade contains javascript of its own
        $( document ).ready( function() {
            //Everything in here would execute after the DOM is ready to manipulated.
        });
    </script>
@endsection
