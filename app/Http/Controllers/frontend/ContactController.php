<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('frontend.contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
        ]);

        Contact::create([
            'user_id' => session('frontend_auth'),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'title' => $data['title'] ?? null,
            'content' => $data['content'],
            'replay_id' => 0,
            'created_at' => now(),
            'status' => 1,
        ]);

        return back()->with('success', 'Thong tin lien he da duoc gui thanh cong.');
    }
}
