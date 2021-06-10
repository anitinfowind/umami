@if($comments->isNotEmpty())
    @foreach($comments as $comment)
        <div class="review-box" id="element_{{$comment->id()}}">
            <div class="review-user">
                <div class="review-user-img">
                    @if($comment->user->image() !=='' && File::exists(USER_PROFILE_IMAGE_ROOT_PATH.$comment->user->slug().DS
                    .$comment->user->image()))
                        <img class="media-object rounded-circle" src="{{ USER_PROFILE_IMAGE_URL.$comment->user->slug().DS
                        .$comment->user->image() }}">
                    @else
                        <img class="media-object rounded-circle" src="{{ WEBSITE_IMG_URL }}profile-user-img.png">
                    @endif
                    <div class="reviewer-name">
                        <p class="text-light-black fw-600">{{ $comment->user->fullName() }} </p>
                        <span class="review-date text-light-white">{{ $comment->date() }}</span>
                    </div>
                </div>
                @if(isset(auth()->user()->id) && !empty(auth()->user()->id))
                @if($comment->userId() === auth()->user()->id)
                    <div class="del-comment">
                        <a href="javascript:void(0)" onclick='removeComment("{{ $comment->id() }}")'>
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                @endif
                @endif
            </div>
           <p>
               {!! $comment->comment()  !!} </p>
        </div>
    @endforeach
@endif
