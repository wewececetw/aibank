<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\UsersRoles;
use Auth;

class SampleMail extends Mailable
{
    use Queueable, SerializesModels;
    public $from;
    public $ctx;
    public $title;
    public $attachment;
    /**
     * Create a new message instance.
     *
     * @return void
     */

     // only content $ctx is need
     // if don't use from or title just new SampleMail put false
    public function __construct($ctx, $from=false, $title=false ,$attachment=false)
    {
        $this->from = $from;
        $this->ctx = $ctx;
        $this->title = $title;
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->attachment != false){
            return $this->subject($this->title)
            ->view('Back_End.emails.sample', [
                'ctx' => $this->ctx,
            ])->attach($this->attachment);
        }

        if(!$this->from && !$this->title){
            return $this->view('Back_End.emails.sample', [
                'ctx' => $this->ctx,
            ]);
        }else if(!$this->from && $this->title){
            return $this->subject($this->title)
                ->view('Back_End.emails.sample', [
                    'ctx' => $this->ctx,
                ]);
        }else if($this->from && !$this->title){
            return $this->from($this->from)
                ->view('Back_End.emails.sample', [
                    'ctx' => $this->ctx,
                ]);
        }else{
            return $this->from($this->from)
                ->subject($this->title)
                ->view('Back_End.emails.sample', [
                    'ctx' => $this->ctx,
                ]);
        }

    }
}
