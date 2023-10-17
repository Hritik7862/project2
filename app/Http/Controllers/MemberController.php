<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::select(['id', 'name', 'email', 'age', 'date_of_birth'])->get();

        if ($request->ajax()) {
            return DataTables::of($members)->make(true);
        }

        return view('members.index')->with('members', $members);
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
          
        return View('members.edit')->with('member', $member)->render();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
            'date_of_birth' => 'required|date',
        ]);

        $member = Member::findOrFail($id);
        $member->update($request->all());

        return Redirect::route('members.index')->with('success', 'Member updated successfully');
    }

    public function destroy($id)
    {     
        $member = Member::findOrFail($id);

        $member->delete();
        return response()->json();
    }
}

