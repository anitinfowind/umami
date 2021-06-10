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
                                        <a href="{{ url('add-chef') }}">
                                            <button type="button" class="btn add-product">+ Add Chef</button>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table product-table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Email </th>
                                            <th>Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($chefs->isNotEmpty())
                                            @foreach($chefs as $chef)
                                                <tr class="product_{{$chef->id}}">
                                                    <td>
                                                        @if(!empty($chef->image) &&
                                                                File::exists(CHEF_ROOT_PATH.$chef->image))
                                                            <?php $image = CHEF_URL.$chef->image; ?>
                                                        @else
                                                            <?php $image = WEBSITE_IMG_URL.'no-product-image.png'; ?>
                                                        @endif
                                                        <img class="resto product_list" src="{{ $image }}" alt="{{ $chef->name() }}">
                                                    </td>
                                                    <td>{{ $chef->name }}</td>
                                                    <td>{{ $chef->designation }}</td>
                                                    <td>{{ $chef->email }}</td>
                                                    <td>
                                                        <div class="action-icon">
                                                            <a href="{{ url('edit-chef/'. $chef->id) }}">
                                                                <i class="fa fa-pencil-square-o"></i>
                                                            </a>
                                                            <a href="{{ url('delete-chef/'. $chef->id) }}">
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
                            @include('frontend.pagination.pagination', ['paginator' => $chefs])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection