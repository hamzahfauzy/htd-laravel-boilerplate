<?php

namespace App\Modules\Base\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Base\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('base::profile.index');
    }

    public function edit()
    {
        return view('base::profile.form');
    }

    public function update(Request $request)
    {
        $data = auth()->user();
        $request->merge([
            'password' => $request->password ? bcrypt($request->password) : $data->password
        ]);
        
        $data->update($request->all());

        $profileData = request('profile');
        $profileData = array_merge($profileData, ['name' => $data->name, 'user_id' => $data->id]);
        Profile::where('user_id', $data->id)->updateOrCreate(['user_id' => $data->id],$profileData);

        return redirect()->route('profile.index')->with('success', 'Profile Updated');
    }

    public function updateImage(Request $request)
    {
        $file = $request->file('file');
        $fileUrl = $file->store('profile');
        Profile::where('user_id', auth()->id())->updateOrCreate(['user_id' => auth()->id()], [
            'pic_url' => $fileUrl
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile Image Updated');
    }
}