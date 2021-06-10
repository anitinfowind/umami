@extends('frontend.layouts.app')
@section('content')
    <div class="dashboard-wrap">
        <div class="container">
            <div class="row">
                @include('frontend.user.sidebar')
                <div class="col-md-9">
                    <div class="dashboard-container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="add-product-div">
                                    <span>
                                        <a href="{{ url('branch/add-branch') }}">
                                            <button type="button" class="btn add-product">+ Add Branch</button>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table product-table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Image</th>
                                        <th>Manager Name</th>
                                        <th>Email</th>
                                        <th>Location</th>
                                        <th>Phone No</th>
                                        <th width="10%">Action </th>
                                    </tr>
                                    </thead>
                                    <tbody class="record">
                                        @if($branches->isNotEmpty())
                                            @foreach($branches as $branch)
                                                <tr class="branch_{{ $branch->userId() }}">
                                                    <td>
                                                        @if($branch->user->image() !=='' && File::exists(USER_PROFILE_IMAGE_ROOT_PATH.$branch->user->slug().DS
                                                        .$branch->user->image()))
                                                            <img class="media-object" src="{{ USER_PROFILE_IMAGE_URL.$branch->user->slug().DS.$branch->user->image() }}">
                                                        @else
                                                            <img class="media-object" src="{{ WEBSITE_IMG_URL }}profile-user-img.png">
                                                        @endif</td>
                                                    <td>{{ $branch->user->fullName() }}</td>
                                                    <td>{{ $branch->user->email() }}</td>
                                                    <td>{{ $branch->restaurantLocation->location() }}</td>
                                                    <td>{{ $branch->phone() }}</td>
                                                    <td>
                                                        <div class="action-icon">
                                                            <a href="{{ url('branch/view/'. $branch->id()) }}">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ url('branch/edit-branch/'. $branch->id()) }}">
                                                                <i class="fa fa-pencil-square-o"></i>
                                                            </a>
                                                            <a href="javascript:void(0)"  onclick='removeBranch("{{ $branch->userId
                                                            () }}")'>
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8">
                                                    <h6 class="text-center">No Record Found</h6>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @include('frontend.pagination.pagination', ['paginator' => $branches])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection