<?php

namespace App\Mail;

use App\Models\UserVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $verification;
    public $status;
    public $rejectionReason;

    public function __construct(UserVerification $verification, string $status, string $rejectionReason = null)
    {
        $this->verification = $verification;
        $this->status = $status;
        $this->rejectionReason = $rejectionReason;
    }

    public function build()
    {
        $subject = $this->status === 'approved' 
            ? 'Age Verification Approved' 
            : 'Age Verification Update Required';

        return $this->subject($subject)
                    ->view('emails.verification-status-update');
    }
}