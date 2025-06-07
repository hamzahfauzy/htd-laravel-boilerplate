@extends('themes.sneat.app')

@section('title', 'Profile')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="m-0">Profile</h3>

            <div class="header-button">
                <a href="{{route('profile.edit')}}" class="btn btn-sm btn-warning">Edit Profile</a>
            </div>
        </div>

        <div class="mb-3"></div>

        @if (\Session::has('success'))
        <div class="col-12">
            <div class="alert alert-success">
                {!! \Session::get('success') !!}
            </div>
        </div>
        @endif

        <div class="col-12 col-md-3">
            <img src="{{auth()->user()->getProfileImageUrl()}}" alt="" width="100%" class="img-thumbnail rounded">
            <button class="w-100 btn btn-primary mt-2" onclick="$('#image_file').click()">Change Image</button>
            <form action="" method="post" id="image_form" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" id="image_file" style="opacity: 0" onchange="$('#image_form').submit()">
            </form>
        </div>
        <div class="col-12 col-md-9">
            @include('libraries.components.detail', [
                'fields' => [
                    'Account Information' => [
                        'name' => 'Name',
                        'email' => 'Email',
                        'verifiedStatus' => 'Verified Status',
                    ],
                    'Role Information' => [
                        'userRoleLabel' => 'Role'
                    ],
                    'Profile Information' => [
                        'profile.code' => 'Code',
                        'profile.address' => 'Address',
                        'profile.gender' => 'Gender',
                        'profile.phone' => 'Phone',
                    ]
                ],
                'data' => auth()->user()
            ])
        </div>
        
    </div>
</div>
@endsection
