@extends('frontend.layouts.layout')
@section('content')

<nav class="breadcrumb" aria-label="breadcrumb">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/blog') }}">Blog</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $blogDetail->name() }}</li>
    </ol>
  </div>
</nav>

<h1 style="display: none;">{{ $blogDetail->name() }}</h1>

<section class="p-v-40 blog-details-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-6 col-12">
        <div class="blog-des-Title w-100 m-b-15">
          <h4>Blog detail</h4>
        </div>
        <div class="relative w-100">
          <div class="box-img fullwidth relative"> @if ($blogDetail->image() !=='' && File::exists(BLOG_ROOT_PATH.$blogDetail->image()))
            <?php $image = BLOG_URL.$blogDetail->image(); ?>
            @else
            <?php $image =WEBSITE_IMG_URL.'no-image.png'; ?>
            @endif <img src="{{ $image }}"> </div>
          <!--<div class="box-date bgColor">
            <div class="date">2<span>7</span></div>
            <div class="month">July</div>
          </div>--> 
          <div class="meta-tag">
            <div class="info d-flex">
              <!-- <div class="item blogAuthor">Posted on {{ date('d M, Y',strtotime($blogDetail->created_at)) }}</div> -->
              <!--<div class="item blogAuthor">Posted By :<a href="#">John Smith</a></div>
              <div class="item views"><a href="#"><i class="fas fa-user"></i> View : 56</a></div>
              <div class="item comments"><a href="#"><i class="fas fa-comment"></i> Comment : 239</a></div>--> 
            </div>
          </div>
        </div>
        <div class="box-content w-100 ">
          <a href="#" class="title">{{ $blogDetail->name() }}</a>
          <div class="blogText blog-entry fullwidth m-b-20"> {!! $blogDetail->content() !!} </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
        
          <div class="recent_posts">
            <h3>Recent Posts</h3>
            <ul>
              @foreach($recent_blogs as $blog)
              <li>
                <a href="{{ url('blog', $blog->slug) }}">
                  <div class="blog-left">
                    @if ($blog->image() !=='' && File::exists(BLOG_ROOT_PATH.$blog->image()))
                    <?php $image = BLOG_URL.$blog->image(); ?>
                    @else
                    <?php $image =WEBSITE_IMG_URL.'no-image.png'; ?>
                    @endif
                    <img src="<?php echo $image; ?>" alt="" class="w-100 d-block">
                  </div>
                  <div class="blog-right">
                      <h5>{{ Str::limit($blog->name(), TITLE_LIMIT)  }}</h5>
                      <p>{!! trim(Str::limit(strip_tags($blog->content()), DESC_LIMIT)) !!}</p>
                  </div>
                </a>
              </li>
              @endforeach
            </ul>
          </div>

      </div>
    </div>
  </div>
</section>
@endsection