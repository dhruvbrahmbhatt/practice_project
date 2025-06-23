<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $groups = Auth::user()->groups; // or Group::where('...')->get();
        return view('group.index', compact('groups', 'users'));
    }

    public function chatWith($userId)
    {
        $user = User::findOrFail($userId);

        // Fetch all messages between current user and selected user
        $messages = Message::where(function ($q) use ($userId) {
            $q->where('from_user_id', Auth::id())
                ->where('to_user_id', $userId);
        })
            ->orWhere(function ($q) use ($userId) {
                $q->where('from_user_id', $userId)
                    ->where('to_user_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // ✅ Mark all unread messages from the selected user as read
        Message::where('from_user_id', $userId)
            ->where('to_user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('chat.chat', compact('user', 'messages'));
    }


    public function sendMessage(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $path = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('chat_images', $imageName, 'public');
        }
        // dd($request->hasFile('image'), $path);
        Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $userId,
            'message' => $request->message,
            'image' => $path
        ]);

        return redirect()->route('chat.with', $userId);
    }

    public function send(Request $request)
    {
        $message = $request->input('message');

        // Save to DB or broadcast via WebSockets
        // Example: Broadcast using events
        // event(new MessageSent(auth()->user(), $message));

        return response()->json(['status' => 'Message sent']);
    }

    public function getUsers()
    {
        $users = User::where('id', '!=', Auth::id())->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'online' => $user->isOnline()
            ];
        });
        return response()->json($users);
    }

    // public function send(Request $request, $userId)
    // {
    //     dd($request->file('image'));
    //     $request->validate([
    //         'message' => 'nullable|string',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $message = new Message();
    //     $message->from_user_id = Auth::id();
    //     $message->to_user_id = $userId;
    //     $message->message = $request->message;
    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $imageName = time() . '_' . $image->getClientOriginalName();
    //         $path = $image->storeAs('chat_images', $imageName, 'public');
    //         $message->image = $path;
    //     }

    //     $message->save();

    //     return redirect()->back()->with('success', 'Message sent!');
    // }
}
