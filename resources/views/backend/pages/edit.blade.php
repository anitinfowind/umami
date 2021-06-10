@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.pages.management') . ' | ' . trans('labels.backend.pages.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.pages.management') }}
        <small>{{ trans('labels.backend.pages.edit') }}</small>
    </h1>
@endsection

@section('content')

<?php
//dd($page->page_meta);
$page_meta = [];
foreach ($page->page_meta as $key => $value) {
    $page_meta[$value->meta_key] = $value->meta_value;
}
?>

    {{ Form::model($page, ['route' => ['admin.pages.update', $page], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-role', 'enctype' => 'multipart/form-data']) }}

    <input type="hidden" name="page_id" value="{{ $page->id }}">
    <input type="hidden" name="template" value="{{ $page->template }}">

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.pages.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.pages.partials.pages-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('title', trans('validation.attributes.backend.pages.title'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.title'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    <label class="col-lg-2 control-label">Template</label>
                    <div class="col-lg-10">
                        <select name="page_template" class="form-control box-size">
                            <option value="">-- Default --</option>
                            <option value="about" {!! $page->template == 'about' ? 'selected="selected"' : '' !!}>About</option>
                            <option value="mission" {!! $page->template == 'mission' ? 'selected="selected"' : '' !!}>Mission</option>
                            <option value="reward" {!! $page->template == 'reward' ? 'selected="selected"' : '' !!}>Reward</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="{!! in_array($page->template, ['about', 'mission', 'reward']) ? 'display: none;' : '' !!}">
                    {{ Form::label('description', trans('validation.attributes.backend.pages.description'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('description', null,['class' => 'form-control','id' => 'editor1', 'placeholder' => trans('validation.attributes.backend.pages.description')]) }}
                    </div><!--col-lg-3-->
                </div><!--form control-->

                <?php
                if($page->template == 'about') {
                    ?>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Block 1: background image</label>
                        <div class="col-lg-10">
                            <?php 
                            $block_1_background_image = $page_meta['block_1_background_image'] ?? '';
                            if($block_1_background_image != '')
                                echo '<img src="' . url('public/uploads/page_meta/' . $block_1_background_image) . '" style="max-width: 300px; max-height: 150px;" />'; 
                            ?>
                            <input name="block_1_background_image" type="file" class="form-control box-size" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Block 1: text 1</label>
                        <div class="col-lg-10">
                            <input name="block_1_text_1" type="text" class="form-control box-size" value="{{ $page_meta['block_1_text_1'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Block 1: text 2</label>
                        <div class="col-lg-10">
                            <input name="block_1_text_2" type="text" class="form-control box-size" value="{{ $page_meta['block_1_text_2'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Block 1: text 3</label>
                        <div class="col-lg-10">
                            <input name="block_1_text_3" type="text" class="form-control box-size" value="{{ $page_meta['block_1_text_3'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Step Title</label>
                        <div class="col-lg-10">
                            <input name="step_title" type="text" class="form-control box-size" value="{{ $page_meta['step_title'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Step 1: background image</label>
                        <div class="col-lg-10">
                            <?php 
                            $step_1_background_image = $page_meta['step_1_background_image'] ?? '';
                            if($step_1_background_image != '')
                                echo '<img src="' . url('public/uploads/page_meta/' . $step_1_background_image) . '" style="max-width: 300px; max-height: 150px;" />'; 
                            ?>
                            <input name="step_1_background_image" type="file" class="form-control box-size" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Step 1: image</label>
                        <div class="col-lg-10">
                            <?php 
                            $step_1_image = $page_meta['step_1_image'] ?? '';
                            if($step_1_image != '')
                                echo '<img src="' . url('public/uploads/page_meta/' . $step_1_image) . '" style="max-width: 300px; max-height: 150px;" />'; 
                            ?>
                            <input name="step_1_image" type="file" class="form-control box-size" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Step 1: Text</label>
                        <div class="col-lg-10">
                            <textarea class="form-control page_editor" id="step_1_text" name="step_1_text">{{ $page_meta['step_1_text'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Step 2: background image</label>
                        <div class="col-lg-10">
                            <?php 
                            $step_2_background_image = $page_meta['step_2_background_image'] ?? '';
                            if($step_2_background_image != '')
                                echo '<img src="' . url('public/uploads/page_meta/' . $step_2_background_image) . '" style="max-width: 300px; max-height: 150px;" />'; 
                            ?>
                            <input name="step_2_background_image" type="file" class="form-control box-size" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Step 2: image</label>
                        <div class="col-lg-10">
                            <?php 
                            $step_2_image = $page_meta['step_2_image'] ?? '';
                            if($step_2_image != '')
                                echo '<img src="' . url('public/uploads/page_meta/' . $step_2_image) . '" style="max-width: 300px; max-height: 150px;" />'; 
                            ?>
                            <input name="step_2_image" type="file" class="form-control box-size" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Step 2: Text</label>
                        <div class="col-lg-10">
                            <textarea class="form-control page_editor" id="step_2_text" name="step_2_text">{{ $page_meta['step_2_text'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label">Step 3: background image</label>
                        <div class="col-lg-10">
                            <?php 
                            $step_3_background_image = $page_meta['step_3_background_image'] ?? '';
                            if($step_3_background_image != '')
                                echo '<img src="' . url('public/uploads/page_meta/' . $step_3_background_image) . '" style="max-width: 300px; max-height: 150px;" />'; 
                            ?>
                            <input name="step_3_background_image" type="file" class="form-control box-size" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Step 3: image</label>
                        <div class="col-lg-10">
                            <?php 
                            $step_3_image = $page_meta['step_3_image'] ?? '';
                            if($step_3_image != '')
                                echo '<img src="' . url('public/uploads/page_meta/' . $step_3_image) . '" style="max-width: 300px; max-height: 150px;" />'; 
                            ?>
                            <input name="step_3_image" type="file" class="form-control box-size" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Step 3: Text</label>
                        <div class="col-lg-10">
                            <textarea class="form-control page_editor" id="step_3_text" name="step_3_text">{{ $page_meta['step_3_text'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Hexa Title</label>
                        <div class="col-lg-10">
                            <input name="hexa_title" type="text" class="form-control box-size" value="{{ $page_meta['hexa_title'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Hexa Button Text</label>
                        <div class="col-lg-10">
                            <input name="hexa_button_text" type="text" class="form-control box-size" value="{{ $page_meta['hexa_button_text'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Hexa Button Link</label>
                        <div class="col-lg-10">
                            <input name="hexa_button_link" type="text" class="form-control box-size" value="{{ $page_meta['hexa_button_link'] ?? '' }}" />
                        </div>
                    </div>
                    <?php for($i = 1; $i <= 6; $i++) { ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Hexa {{ $i }}: image</label>
                            <div class="col-lg-10">
                                <?php 
                                ${'hexa_' . $i . '_image'} = $page_meta['hexa_' . $i . '_image'] ?? '';
                                if(${'hexa_' . $i . '_image'} != '')
                                    echo '<img src="' . url('public/uploads/page_meta/' . ${'hexa_' . $i . '_image'}) . '" style="max-width: 300px; max-height: 150px;" />'; 
                                ?>
                                <input name="{{ 'hexa_' . $i . '_image' }}" type="file" class="form-control box-size" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Hexa {{ $i }}: Title</label>
                            <div class="col-lg-10">
                                <input name="{{ 'hexa_' . $i . '_title' }}" type="text" class="form-control box-size" value="{{ $page_meta['hexa_' . $i . '_title'] ?? '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Hexa {{ $i }}: Text</label>
                            <div class="col-lg-10">
                                <textarea class="form-control page_editor" id="{{ 'hexa_' . $i . '_text' }}" name="{{ 'hexa_' . $i . '_text' }}">{{ $page_meta['hexa_' . $i . '_text'] ?? '' }}</textarea>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if($page->template == 'mission') { ?>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Block 1: background image</label>
                        <div class="col-lg-10">
                            <?php 
                            $block_1_background_image = $page_meta['block_1_background_image'] ?? '';
                            if($block_1_background_image != '')
                                echo '<img src="' . url('public/uploads/page_meta/' . $block_1_background_image) . '" style="max-width: 300px; max-height: 150px;" />'; 
                            ?>
                            <input name="block_1_background_image" type="file" class="form-control box-size" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Block 1: text</label>
                        <div class="col-lg-10">
                            <input name="block_1_text" type="text" class="form-control box-size" value="{{ $page_meta['block_1_text'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Top Text</label>
                        <div class="col-lg-10">
                            <textarea class="form-control page_editor" id="top_text" name="top_text">{{ $page_meta['top_text'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <?php for($i = 1; $i <= 3; $i++) { ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Section {{ $i }}: image</label>
                            <div class="col-lg-10">
                                <?php 
                                ${'section_' . $i . '_image'} = $page_meta['section_' . $i . '_image'] ?? '';
                                if(${'section_' . $i . '_image'} != '')
                                    echo '<img src="' . url('public/uploads/page_meta/' . ${'section_' . $i . '_image'}) . '" style="max-width: 300px; max-height: 150px;" />'; 
                                ?>
                                <input name="{{ 'section_' . $i . '_image' }}" type="file" class="form-control box-size" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Section {{ $i }}: Title 1</label>
                            <div class="col-lg-10">
                                <input name="{{ 'section_' . $i . '_title_1' }}" type="text" class="form-control box-size" value="{{ $page_meta['section_' . $i . '_title_1'] ?? '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Section {{ $i }}: Title 2</label>
                            <div class="col-lg-10">
                                <input name="{{ 'section_' . $i . '_title_2' }}" type="text" class="form-control box-size" value="{{ $page_meta['section_' . $i . '_title_2'] ?? '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Section {{ $i }}: Text</label>
                            <div class="col-lg-10">
                                <textarea class="form-control page_editor" id="{{ 'section_' . $i . '_text' }}" name="{{ 'section_' . $i . '_text' }}">{{ $page_meta['section_' . $i . '_text'] ?? '' }}</textarea>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php
                if($page->template == 'reward') {
                    ?>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Block 1: background image</label>
                        <div class="col-lg-10">
                            <?php 
                            $block_1_background_image = $page_meta['block_1_background_image'] ?? '';
                            if($block_1_background_image != '')
                                echo '<img src="' . url('public/uploads/page_meta/' . $block_1_background_image) . '" style="max-width: 300px; max-height: 150px;" />'; 
                            ?>
                            <input name="block_1_background_image" type="file" class="form-control box-size" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Block 1: text</label>
                        <div class="col-lg-10">
                            <textarea name="block_1_text" class="form-control box-size" rows="4">{{ $page_meta['block_1_text'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">SQ Block: right background image</label>
                        <div class="col-lg-10">
                            <?php 
                            $sqblock_right_background_image = $page_meta['sqblock_right_background_image'] ?? '';
                            if($sqblock_right_background_image != '')
                                echo '<img src="' . url('public/uploads/page_meta/' . $sqblock_right_background_image) . '" style="max-width: 300px; max-height: 150px;" />'; 
                            ?>
                            <input name="sqblock_right_background_image" type="file" class="form-control box-size" />
                        </div>
                    </div>
                    <?php for($i = 1; $i <= 3; $i++) { ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">SQ Block Heading {{ $i }}</label>
                            <div class="col-lg-10">
                                <input name="{{ 'sqblock_head_' . $i }}" type="text" class="form-control box-size" value="{{ $page_meta['sqblock_head_' . $i] ?? '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">SQ Block Text {{ $i }}</label>
                            <div class="col-lg-10">
                                <input name="{{ 'sqblock_text_' . $i }}" type="text" class="form-control box-size" value="{{ $page_meta['sqblock_text_' . $i] ?? '' }}" />
                            </div>
                        </div>
                    <?php } ?>
                    <?php for($i = 1; $i <= 4; $i++) { ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">SQ Block Red {{ $i }}</label>
                            <div class="col-lg-10">
                                <input name="{{ 'sqblock_red_' . $i }}" type="text" class="form-control box-size" value="{{ $page_meta['sqblock_red_' . $i] ?? '' }}" />
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="form-group">
                    {{ Form::label('cannonical_link', trans('validation.attributes.backend.pages.cannonical_link'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('cannonical_link', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.cannonical_link')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('seo_title', trans('validation.attributes.backend.pages.seo_title'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('seo_title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.seo_title')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('seo_keyword', trans('validation.attributes.backend.pages.seo_keyword'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('seo_keyword', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.pages.seo_keyword')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('seo_description', trans('validation.attributes.backend.pages.seo_description'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('seo_description', null,['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.pages.seo_description')]) }}
                    </div><!--col-lg-3-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('status', trans('validation.attributes.backend.pages.is_active'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <div class="control-group">
                            <label class="control control--checkbox">
                                {{ Form::checkbox('status', 1, ($page->status == 1) ? true : false ) }}
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                    </div><!--col-lg-3-->
                </div><!--form control-->
                <div class="edit-form-btn">
                    {{ link_to_route('admin.pages.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    {{ Form::close() }}
@endsection
<script src="//cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
@section("after-scripts")
    <script type="text/javascript">
        Backend.Pages.init('{{ config('locale.languages.' . app()->getLocale())[1] }}');
          window.onload = function() {
            CKEDITOR.replace( 'editor1', {
              filebrowserUploadUrl: '{{ route('admin.pages.upload',['_token' => csrf_token() ]) }}'
            });

            $('.page_editor').each(function(){
                var thisid = $(this).attr('id');
                CKEDITOR.replace( thisid, {
                    format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
                  filebrowserUploadUrl: '{{ route('admin.pages.upload',['_token' => csrf_token() ]) }}'
                });
            });

          };
    </script>
@endsection