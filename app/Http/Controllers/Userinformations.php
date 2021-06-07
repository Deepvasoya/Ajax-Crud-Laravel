<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userinformation;

class Userinformations extends Controller
{

    public function index()
    {
        $user = Userinformation::orderby('id', 'DESC')->simplePaginate(3);
        return view('home', compact('user'));
    }

    public function pagination(Request $request)
    {
        if ($request->ajax()) {
            $user = Userinformation::orderby('id', 'DESC')->simplePaginate(3);
            return view('page', compact('user'))->render();
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'Designation' => 'required',
        ]);
        $users = new Userinformation();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->Designation = $request->Designation;
        $users->save();
        return response()->json($users);
    }

    public function edit($id)
    {
        $userdata = Userinformation::find($id);
        return response()->json($userdata);
    }

    public function update(Request $request)
    {
        $userdata = Userinformation::find($request->id);
        $userdata->name = $request->name;
        $userdata->email = $request->email;
        $userdata->Designation = $request->Designation;
        $userdata->save();
        return response()->json($userdata);
    }


    public function delete($id)
    {
        $user = Userinformation::find($id);
        $user->delete();
        return response()->json(['success' => 'Record Hasbeen Deleted.']);
    }
}
