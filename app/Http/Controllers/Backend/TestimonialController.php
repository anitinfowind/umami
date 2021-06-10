<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\Permission\Permission;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Models\Settings\Setting;
use Illuminate\Http\Request;
use DB;
use App\Models\Sales_report;
use App\Models\Sales_report_payment;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();

        return view('backend.testimonials',
            compact('testimonials')
        );
    }

    
    public function get_testimonial(Request $request) {
        $testimonial_id = $request->input('testimonial_id');
        $testimonial = Testimonial::find($testimonial_id);
        $data = ['testimonial' => $testimonial];
        return response()->json(['success' => 1, 'message' => '', 'data' => $data]);
    }


    public function set_testimonial(Request $request)
    {
        // if(!empty($request->file('post_image')))
        //    {
        //      $postimage = $request->file('post_image');
        //      $extnsion= $postimage->getClientOriginalExtension();
        //      $request->validate([
        //       'post_image'=>'required|mimes:mp4,ogx,oga,ogv,ogg,webm,jpeg,jpg,png,gif',
        //      ]);
        // }

        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $title = $request->input('title');
        $comment = $request->input('comment');
        $status = $request->input('status');
        $remove_image = $request->input('remove_image');
        $remove_post_image = $request->input('remove_post_image');
        $testimonial_id = $request->input('testimonial_id');
        $testimonial = Testimonial::find($testimonial_id);
        
        $image = $testimonial->image ?? '';
        $upload_path = public_path('/uploads/testimonial');
        if($remove_image == '1') {
            @unlink($upload_path . '/' . $image);
            $image = '';
        }

        $post_image = $testimonial->post_image ?? '';
        $post_upload_path = public_path('/uploads/testimonial/post_image');
        if($remove_post_image == '1') {
            @unlink($post_upload_path . '/' . $post_image);
            $post_image = '';
        }

        if($request->hasFile('image')) {
            @unlink($upload_path . '/' . $image);
            $image = $request->file('image');
            $name = date('d-m-Y-H-i-s') . '-' . $image->getClientOriginalName();
            $image->move($upload_path, $name);
            $image = $name;
        }
        

        if($request->file('post_image')) {
            @unlink($post_upload_path . '/' . $post_image);
            $post_image = $request->file('post_image');
            $name = date('d-m-Y-H-i-s') . '-' . $post_image->getClientOriginalName();
            $post_image->move($post_upload_path, $name);
            $post_image = $name;
        }

        if($testimonial_id == '')
            Testimonial::create(['first_name' => $first_name, 'last_name' => $last_name, 'title' => $title, 'comment' => $comment, 'status' => $status, 'image' => $image, 'post_image' => $post_image]);
        else
            Testimonial::where('id', $testimonial_id)->update(['first_name' => $first_name, 'last_name' => $last_name, 'title' => $title, 'comment' => $comment, 'status' => $status, 'image' => $image, 'post_image' => $post_image]);
        return response()->json(['success' => 1, 'message' => '']);
    }

    
    public function delete_testimonial(Request $request) {
        $testimonial_id = $request->input('testimonial_id');
        $testimonial = Testimonial::find($testimonial_id);
        $upload_path = public_path('/uploads/testimonial');
        @unlink($upload_path . '/' . $testimonial->image);
        Testimonial::destroy($testimonial_id);
        return response()->json(['success' => 1, 'message' => '']);
    }


}
