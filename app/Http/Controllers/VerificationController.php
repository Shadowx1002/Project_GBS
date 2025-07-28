<?php

namespace App\Http\Controllers;

use App\Models\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $verification = $user->verification;

        return view('verification.show', compact('verification'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_document' => ['required', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5120'], // 5MB max
            'date_of_birth' => ['required', 'date', 'before:-18 years'],
        ], [
            'date_of_birth.before' => 'You must be at least 18 years old.',
            'id_document.mimes' => 'ID document must be a JPEG, PNG, or PDF file.',
            'id_document.max' => 'ID document must not exceed 5MB.',
        ]);

        $user = auth()->user();

        // Delete existing verification if any
        if ($user->verification) {
            Storage::delete($user->verification->id_document_path);
            $user->verification->delete();
        }

        // Store the document
        $documentPath = $request->file('id_document')->store('verification-documents', 'private');

        // Create verification record
        UserVerification::create([
            'user_id' => $user->id,
            'id_document_path' => $documentPath,
            'date_of_birth' => $request->date_of_birth,
            'verification_status' => 'pending',
        ]);

        // Update user's date of birth if provided
        $user->update(['date_of_birth' => $request->date_of_birth]);

        return redirect()->back()->with('success', 
            'ID verification submitted successfully! We will review your documents within 24-48 hours.');
    }

    public function download($id)
    {
        $verification = UserVerification::findOrFail($id);
        
        // Only admin or the user themselves can download
        if (!auth()->user()->isAdmin() && auth()->id() !== $verification->user_id) {
            abort(403);
        }

        return Storage::download($verification->id_document_path);
    }
}