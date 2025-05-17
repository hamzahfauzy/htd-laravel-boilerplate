<?php

namespace App\Modules\Base\Resources;

use App\Libraries\Abstract\Resource;
use App\Modules\Base\Models\Profile;
use App\Modules\Base\Models\Role;
use App\Modules\Base\Models\User;
use App\Modules\Base\Models\UserRole;
use Illuminate\Http\Request;

class UserResource extends Resource {

    protected static ?string $navigationGroup = 'Base';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $navigationIcon = 'bx bx-user';
    protected static ?string $slug = 'users';
    protected static ?string $routeGroup = 'base';

    protected static $model = User::class;

    public static function table()
    {
        return [
            'profile.code' => [
                'label' => 'Code',
                '_searchable' => true
            ],
            'name' => [
                'label' => 'Name',
                '_searchable' => true
            ],
            'email' => [
                'label' => 'Email',
                '_searchable' => true
            ],
            'userRoleLabel' => [
                'label' => 'Role'
            ],
            'verifiedStatusBadge' => [
                'label' => 'Verified Status',
            ],
            '_action'
        ];
    }

    public static function form()
    {
        $roles = Role::get();
        $selectedRoles = [];
        foreach($roles as $role)
        {
            $selectedRoles[$role->id] = $role->name;
        }

        return [
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
            'Role Information' => [
                'roleNames' => [
                    'label' => 'Role',
                    'type' => 'checkbox',
                    'options' => $selectedRoles,
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
        ];
    }

    public static function afterCreate(Request $request, $data)
    {
        $profileData = request('profile');
        $profileData = array_merge($profileData, ['name' => $data->name, 'user_id' => $data->id]);
        Profile::create($profileData);

        // assign role
        $roles = request('roleNames');
        $mappingRoles = [];
        foreach($roles as $role)
        {
            $mappingRoles[] = [
                'role_id' => $role,
                'user_id' => $data->id,
                'created_by' => auth()->id(),
            ];
        }
        UserRole::insert($mappingRoles);
    }
    
    public static function afterUpdate(Request $request, $data)
    {
        $profileData = request('profile');
        $profileData = array_merge($profileData, ['name' => $data->name, 'user_id' => $data->id]);
        Profile::where('user_id', $data->id)->update($profileData);

        UserRole::where('user_id', $data->id)->delete();
        $roles = request('roleNames');
        $mappingRoles = [];
        foreach($roles as $role)
        {
            $mappingRoles[] = [
                'role_id' => $role,
                'user_id' => $data->id,
                'created_by' => auth()->id(),
            ];
        }
        UserRole::insert($mappingRoles);
    }
    
    public static function beforeCreate(Request $request)
    {
        $request->merge([
            'password' => bcrypt($request->password)
        ]);
    }
    
    public static function beforeUpdate(Request $request, $data)
    {
        $request->merge([
            'password' => $request->password ? bcrypt($request->password) : $data->password
        ]);
    }
    
    public static function detail()
    {
        return [
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
        ];
    }

}