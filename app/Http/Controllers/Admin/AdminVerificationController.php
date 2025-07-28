<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationStatusUpdate;

class AdminVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = UserVerification::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }

        // Search by user name or email
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'ILIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'ILIKE', "%{$searchTerm}%");
            });
        }

        $verifications = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.verifications.index', compact('verifications'));
    }

    public function approve(UserVerification $verification)
    {
        $verification->approve();

        // Send notification email
        try {
            Mail::to($verification->user->email)->send(
                new VerificationStatusUpdate($verification, 'approved')
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send verification approval email: ' . $e->getMessage());
        }

        return back()->with('success', 'Verification approved successfully.');
    }

    public function reject(Request $request, UserVerification $verification)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $verification->reject($request->rejection_reason);

        // Send notification email
        try {
            Mail::to($verification->user->email)->send(
                new VerificationStatusUpdate($verification, 'rejected', $request->rejection_reason)
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send verification rejection email: ' . $e->getMessage());
        }

        return back()->with('success', 'Verification rejected successfully.');
    }

    public function download(UserVerification $verification)
    {
        if (!Storage::exists($verification->id_document_path)) {
            abort(404, 'Document not found');
        }

        return Storage::download($verification->id_document_path);
    }
}