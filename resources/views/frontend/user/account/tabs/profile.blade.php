<table class="table table-striped table-hover">
    <tr>
        <th>{{ trans('labels.frontend.user.profile.first_name') }}</th>
        <td>{{ auth()->user()->firstName() }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.last_name') }}</th>
        <td>{{ auth()->user()->lastName() }}</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.email') }}</th>
        <td>{{ auth()->user()->email() }}</td>
    </tr>
    <tr>
        <th>{{ trans('Phone Number') }}</th>
        <td>{{ auth()->user()->phoneNo() }}</td>
    </tr>
    <tr>
        <th>{{ trans('Profile Image') }}</th>
        <td>
            @if(auth()->user()->image() !=='' && File::exists(USER_PROFILE_IMAGE_ROOT_PATH.auth()->user()->slug.DS.auth()->user()
            ->image()))
                <img class="media-object" src="{{ USER_PROFILE_IMAGE_URL.auth()->user()->slug.DS.auth()->user()->image() }}">
            @else
                <img class="media-object" src="{{ WEBSITE_IMG_URL }}profile-user-img.png">
            @endif
        </td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.created_at') }}</th>
        <td>{{ auth()->user()->created_at->format('F jS, Y') }} ({{ auth()->user()->created_at->diffForHumans() }})</td>
    </tr>
    <tr>
        <th>{{ trans('labels.frontend.user.profile.last_updated') }}</th>
        <td>{{ auth()->user()->updated_at->format('F jS, Y') }} ({{ auth()->user()->updated_at->diffForHumans() }})</td>
    </tr>
</table>