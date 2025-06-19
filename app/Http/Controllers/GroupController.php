<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Load only groups the user belongs to
        $groups = $user->groups()->get(); // assuming proper relationship is defined

        return view('group.index', compact('groups'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('group.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'members' => 'required|array',
        ]);

        $group = Group::create(['name' => $request->name]);
        $group->users()->attach(array_merge([$request->user()->id], $request->members));

        return redirect()->route('group.index')->with('success', 'Group created!');
    }

    public function chat($groupId)
    {
        $group = Group::with('users')->findOrFail($groupId);
        abort_unless($group->users->contains(Auth::id()), 403);

        $messages = Message::where('group_id', $group->id)->orderBy('created_at')->get();
        return view('group.chat', compact('group', 'messages'));
    }

    public function sendMessage(Request $request, $groupId)
    {
        $request->validate([
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('chat_images', $imageName, 'public');
        }

        \App\Models\Message::create([
            'from_user_id' => Auth::id(),
            'group_id' => $groupId,
            'message' => $request->message,
            'image' => $path,
        ]);

        return redirect()->route('group.chat', $groupId);
    }
}
