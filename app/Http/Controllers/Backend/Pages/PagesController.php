<?php

namespace App\Http\Controllers\Backend\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Pages\CreatePageRequest;
use App\Http\Requests\Backend\Pages\DeletePageRequest;
use App\Http\Requests\Backend\Pages\EditPageRequest;
use App\Http\Requests\Backend\Pages\ManagePageRequest;
use App\Http\Requests\Backend\Pages\StorePageRequest;
use App\Http\Requests\Backend\Pages\UpdatePageRequest;
use App\Http\Responses\Backend\Page\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Page\Page;
use Illuminate\Http\Request;
use App\Repositories\Backend\Pages\PagesRepository;

use App\Models\Page_meta;

class PagesController extends Controller
{
    /**
     * @var PagesRepository
     */
    protected $pages;

    /**
     * @param PagesRepository $pages
     */
    public function __construct(PagesRepository $pages)
    {
        $this->pages = $pages;
    }

    /**
     * @param ManagePageRequest $request
     * @return ViewResponse
     */
    public function index(ManagePageRequest $request)
    {
        return new ViewResponse('backend.pages.index');
    }

    /**
     * @param CreatePageRequest $request
     * @return ViewResponse
     */
    public function create(CreatePageRequest $request)
    {
        return new ViewResponse('backend.pages.create');
    }

    /**
     * @param StorePageRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function store(StorePageRequest $request)
    {
        $this->pages->create($request->except(['_token']));

        return new RedirectResponse(route('admin.pages.index'),
            ['flash_success' => trans('alerts.backend.pages.created')]
        );
    }

    /**
     * @param Page $page
     * @param EditPageRequest $request
     * @return EditResponse
     */
    public function edit(Page $page, EditPageRequest $request)
    {
        return new EditResponse($page);
    }

    /**
     * @param Page $page
     * @param UpdatePageRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function update(Page $page, UpdatePageRequest $request)
    {
        $this->pages->update($page, $request->except(['_method', '_token']));

        $time = time();
        $page_id = $request->page_id;
        $template = $request->template;
        if($template == 'about') {
            $page_meta = Page_meta::where('page_id', $page_id)->get();
            $page_meta2 = [];
            foreach ($page_meta as $key => $value) {
                $page_meta2[$value->meta_key] = $value->meta_value;
            }
            $block_1_text_1 = trim($request->block_1_text_1);
            $block_1_text_2 = trim($request->block_1_text_2);
            $block_1_text_3 = trim($request->block_1_text_3);
            $step_title = trim($request->step_title);
            $step_1_text = trim($request->step_1_text);
            $step_2_text = trim($request->step_2_text);
            $step_3_text = trim($request->step_3_text);
            $hexa_title = trim($request->hexa_title);
            $hexa_button_text = trim($request->hexa_button_text);
            $hexa_button_link = trim($request->hexa_button_link);
            $hexa_1_title = trim($request->hexa_1_title);
            $hexa_1_text = trim($request->hexa_1_text);
            $hexa_2_title = trim($request->hexa_2_title);
            $hexa_2_text = trim($request->hexa_2_text);
            $hexa_3_title = trim($request->hexa_3_title);
            $hexa_3_text = trim($request->hexa_3_text);
            $hexa_4_title = trim($request->hexa_4_title);
            $hexa_4_text = trim($request->hexa_4_text);
            $hexa_5_title = trim($request->hexa_5_title);
            $hexa_5_text = trim($request->hexa_5_text);
            $hexa_6_title = trim($request->hexa_6_title);
            $hexa_6_text = trim($request->hexa_6_text);
            foreach (['block_1_background_image', 'step_1_background_image', 'step_1_image', 'step_2_background_image', 'step_2_image', 'step_3_background_image', 'step_3_image', 'hexa_1_image', 'hexa_2_image', 'hexa_3_image', 'hexa_4_image', 'hexa_5_image', 'hexa_6_image'] as $key => $value) {
                if($request->hasFile($value)) {
                    $upload_path = public_path()."/uploads/page_meta";
                    if(isset($page_meta2[$value]))
                        @unlink($upload_path . '/' . $page_meta2[$value]);
                    $ext = $request->file($value)->getClientOriginalExtension();
                    $img_name = $request->file($value)->getclientoriginalname();
                    $img_new_name = $page_id . $value . $time . '.' . $ext;
                    $request->file($value)->move($upload_path, $img_new_name);

                    Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => $value], ['meta_value' => $img_new_name]);
                }
            }
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'block_1_text_1'], ['meta_value' => $block_1_text_1]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'block_1_text_2'], ['meta_value' => $block_1_text_2]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'block_1_text_3'], ['meta_value' => $block_1_text_3]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'step_title'], ['meta_value' => $step_title]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'step_1_text'], ['meta_value' => $step_1_text]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'step_2_text'], ['meta_value' => $step_2_text]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'step_3_text'], ['meta_value' => $step_3_text]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'hexa_title'], ['meta_value' => $hexa_title]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'hexa_button_text'], ['meta_value' => $hexa_button_text]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'hexa_button_link'], ['meta_value' => $hexa_button_link]);
            for($i = 1; $i <= 6; $i++) {
                Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'hexa_' . $i . '_title'], ['meta_value' => ${'hexa_' . $i . '_title'}]);
                Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'hexa_' . $i . '_text'], ['meta_value' => ${'hexa_' . $i . '_text'}]);
            }
        }
        if($template == 'mission') {
            $page_meta = Page_meta::where('page_id', $page_id)->get();
            $page_meta2 = [];
            foreach ($page_meta as $key => $value) {
                $page_meta2[$value->meta_key] = $value->meta_value;
            }
            $block_1_text = trim($request->block_1_text);
            $top_text = trim($request->top_text);
            $section_1_title_1 = trim($request->section_1_title_1);
            $section_1_title_2 = trim($request->section_1_title_2);
            $section_1_text = trim($request->section_1_text);
            $section_2_title_1 = trim($request->section_2_title_1);
            $section_2_title_2 = trim($request->section_2_title_2);
            $section_2_text = trim($request->section_2_text);
            $section_3_title_1 = trim($request->section_3_title_1);
            $section_3_title_2 = trim($request->section_3_title_2);
            $section_3_text = trim($request->section_3_text);
            foreach (['block_1_background_image', 'section_1_image', 'section_2_image', 'section_3_image'] as $key => $value) {
                if($request->hasFile($value)) {
                    $upload_path = public_path()."/uploads/page_meta";
                    if(isset($page_meta2[$value]))
                        @unlink($upload_path . '/' . $page_meta2[$value]);
                    $ext = $request->file($value)->getClientOriginalExtension();
                    $img_name = $request->file($value)->getclientoriginalname();
                    $img_new_name = $page_id . $value . $time . '.' . $ext;
                    $request->file($value)->move($upload_path, $img_new_name);

                    Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => $value], ['meta_value' => $img_new_name]);
                }
            }
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'block_1_text'], ['meta_value' => $block_1_text]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'top_text'], ['meta_value' => $top_text]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'section_1_title_1'], ['meta_value' => $section_1_title_1]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'section_1_title_2'], ['meta_value' => $section_1_title_2]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'section_1_text'], ['meta_value' => $section_1_text]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'section_2_title_1'], ['meta_value' => $section_2_title_1]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'section_2_title_2'], ['meta_value' => $section_2_title_2]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'section_2_text'], ['meta_value' => $section_2_text]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'section_3_title_1'], ['meta_value' => $section_3_title_1]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'section_3_title_2'], ['meta_value' => $section_3_title_2]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'section_3_text'], ['meta_value' => $section_3_text]);
        }
        if($template == 'reward') {
            $page_meta = Page_meta::where('page_id', $page_id)->get();
            $page_meta2 = [];
            foreach ($page_meta as $key => $value) {
                $page_meta2[$value->meta_key] = $value->meta_value;
            }
            $block_1_text = trim($request->block_1_text);
            $sqblock_head_1 = trim($request->sqblock_head_1);
            $sqblock_head_2 = trim($request->sqblock_head_2);
            $sqblock_head_3 = trim($request->sqblock_head_3);
            $sqblock_text_1 = trim($request->sqblock_text_1);
            $sqblock_text_2 = trim($request->sqblock_text_2);
            $sqblock_text_3 = trim($request->sqblock_text_3);
            $sqblock_red_1 = trim($request->sqblock_red_1);
            $sqblock_red_2 = trim($request->sqblock_red_2);
            $sqblock_red_3 = trim($request->sqblock_red_3);
            $sqblock_red_4 = trim($request->sqblock_red_4);
            foreach (['block_1_background_image', 'sqblock_right_background_image'] as $key => $value) {
                if($request->hasFile($value)) {
                    $upload_path = public_path()."/uploads/page_meta";
                    if(isset($page_meta2[$value]))
                        @unlink($upload_path . '/' . $page_meta2[$value]);
                    $ext = $request->file($value)->getClientOriginalExtension();
                    $img_name = $request->file($value)->getclientoriginalname();
                    $img_new_name = $page_id . $value . $time . '.' . $ext;
                    $request->file($value)->move($upload_path, $img_new_name);
                    Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => $value], ['meta_value' => $img_new_name]);
                }
            }
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'block_1_text'], ['meta_value' => $block_1_text]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'sqblock_head_1'], ['meta_value' => $sqblock_head_1]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'sqblock_head_2'], ['meta_value' => $sqblock_head_2]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'sqblock_head_3'], ['meta_value' => $sqblock_head_3]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'sqblock_text_1'], ['meta_value' => $sqblock_text_1]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'sqblock_text_2'], ['meta_value' => $sqblock_text_2]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'sqblock_text_3'], ['meta_value' => $sqblock_text_3]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'sqblock_red_1'], ['meta_value' => $sqblock_red_1]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'sqblock_red_2'], ['meta_value' => $sqblock_red_2]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'sqblock_red_3'], ['meta_value' => $sqblock_red_3]);
            Page_meta::updateOrCreate(['page_id' => $page_id, 'meta_key' => 'sqblock_red_4'], ['meta_value' => $sqblock_red_4]);
        }

        return new RedirectResponse(route('admin.pages.index'),
            ['flash_success' => trans('alerts.backend.pages.updated')]
        );
    }

    /**
     * @param Page $page
     * @param DeletePageRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(Page $page, DeletePageRequest $request)
    {
        $this->pages->delete($page);

        return new RedirectResponse(route('admin.pages.index'),
            ['flash_success' => trans('alerts.backend.pages.deleted')]
        );
    }

    public function uploadImage(Request $request) 
    {
      $CKEditor = $request->CKEditor;
      $funcNum  = $request->CKEditorFuncNum;
      $message  = $url = '';
        if ($request->hasFile('upload')) 
        {
             $file = $request->file('upload');
            if ($file->isValid()) {
             $filename =rand(1000,9999).$file->getClientOriginalName();
             $file->move(public_path().'/uploads/restaurant/', $filename);
             $url = url('uploads/restaurant/' . $filename);
            } else {
              $message = 'An error occurred while uploading the file.';
            }
        } else  
        {
             $message = 'No file uploaded.';
        }
             return '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>';
    }
}
