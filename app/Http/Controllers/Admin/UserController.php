<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('order')) {
            if ($request->order === 'id_asc') {
                $data = User::orderBy('id', 'asc')->paginate(10);
            } elseif ($request->order === 'id_desc') {
                $data = User::orderBy('id', 'desc')->paginate(10);
            } elseif ($request->order === 'name_asc') {
                $data = User::orderBy('name', 'asc')->paginate(10);
            } elseif ($request->order === 'name_desc') {
                $data = User::orderBy('name', 'desc')->paginate(10);
            } elseif ($request->order === 'email_asc') {
                $data = User::orderBy('email', 'asc')->paginate(10);
            } elseif ($request->order === 'email_desc') {
                $data = User::orderBy('email', 'desc')->paginate(10);
            }
        } else if ($request->has('search')) {
            $data = User::where('name', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->paginate(10);
        } else {
            $data = User::orderBy('id', 'asc')->paginate(10);
        }

        return view('admin.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::where(['id' => $id])->get()->first();
        if (!$user) {
            abort(404);
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $formData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email']
        ]);

        User::where('id', $id)->first()->update(['name' => $formData['name'], 'email' => $formData['email']]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
