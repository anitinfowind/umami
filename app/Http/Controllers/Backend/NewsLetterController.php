<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class NewsLetterController extends Controller
{

    public function index(Request $request)
    {
        $newsletters = DB::table('newsletters')->orderBy('created_at', 'desc')->get();

        return view('backend.newsletters.index', compact('newsletters'));
    }


}
