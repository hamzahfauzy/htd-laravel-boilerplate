@extends('themes.sneat.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="m-0">Edit Profile</h3>

            <div class="header-button">
                <a href="{{route('profile.index')}}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-fw fa-arrow-left"></i> Back</a>
            </div>
        </div>

        <div class="mb-3"></div>
        
        @include('libraries.components.form', [
            'page' => json_decode(json_encode(['isEdit' => true])),
            'sections' => [
                'Account Information' => [
                    'name' => [
                        'label' => 'Name',
                        'type' => 'text',
                        'placeholder' => 'Enter your name',
                        'required' => true,
                    ],
                    'email' => [
                        'label' => 'Email',
                        'type' => 'email',
                        'placeholder' => 'Enter your email',
                        'required' => true,
                    ],
                    'password' => [
                        'label' => 'Password',
                        'type' => 'password',
                        'placeholder' => 'Enter your password',
                        'required' => true,
                    ],
                ],
                'Profile Information' => [
                    'profile.code' => [
                        'label' => 'Code',
                        'type' => 'text',
                        'placeholder' => 'Enter your code/cilivization code',
                        'required' => true,
                    ],
                    'profile.address' => [
                        'label' => 'Address',
                        'type' => 'textarea',
                        'placeholder' => 'Enter your address',
                        'required' => true,
                    ],
                    'profile.gender' => [
                        'label' => 'Gender',
                        'type' => 'select',
                        'options' => [
                            'MALE' => 'Male',
                            'FEMALE' => 'Female',
                        ],
                        'required' => true,
                    ],
                    'profile.phone' => [
                        'label' => 'Phone',
                        'type' => 'tel',
                        'placeholder' => 'Enter your phone number',
                        'required' => true,
                    ],
                ]
            ],
            'data' => auth()->user()
        ])
    </div>
</div>
@endsection
