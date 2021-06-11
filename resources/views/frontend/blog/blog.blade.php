@extends('frontend.layouts.layout')
@section('content')

<nav class="breadcrumb test" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Blog</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">Latest news</h1>

<section class="news-sec">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="blog-heading">
          <h4>Latest news</h4>
        </div>
      </div>
      @if($blogs->isNotEmpty())
      @foreach($blogs as $blog)
      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="newsBox w-100">
          <div class="food-pic relative w-100 product-img"> @if ($blog->image() !=='' && File::exists(BLOG_ROOT_PATH.$blog->image()))
            <?php $image = BLOG_URL.$blog->image(); ?>
            @else
            <?php $image =WEBSITE_IMG_URL.'no-image.png'; ?>
            @endif <img src="{{ $image }}" class="img-fluid"> </div>
          <div class="newsDesc w-100">
            <h4><a href="{{ url('blog', $blog->slug) }}">{{ Str::limit($blog->name(), TITLE_LIMIT)  }}</a></h4>
            <!--<ul class="w-100 d-flex flex-wrap">
              <li><i class="fa fa-user"></i> Posted by MagikThemes</li>
              <li><i class="fa fa-comments"></i> 4 Comments</li>
              <li><i class="fa fa-clock-o"></i> December 02, 2015</li>
            </ul>-->
            <p>{!! Str::limit(strip_tags($blog->content()), DESC_LIMIT) !!}</p>
            <a href="{{ url('blog', $blog->slug) }}" class="readMore">read more</a> </div>
        </div>
      </div>
      @endforeach
      @endif </div>
    <!--<div class="row">
      <div class="col-12">
        <div class="table-footer">
          <ul class="pagination justify-content-center">
            <li class="page-item  disabled"> <a class="page-link" href="javascript:void(0)"><i class="fa fa-angle-left" aria-hidden="true"></i> Prev</a> </li>
            <li class="page-item  active"> <a class="page-link" href="#">1</a> </li>
            <li class="page-item "> <a class="page-link" href="#">2</a> </li>
            <li class="page-item "> <a class="page-link" href="#">3</a> </li>
            <li class="page-item "> <a class="page-link" href="#">Next <i class="fa fa-angle-right" aria-hidden="true"></i></a> </li>
          </ul>
        </div>
      </div>
    </div>-->
  </div>
</section>
@endsection