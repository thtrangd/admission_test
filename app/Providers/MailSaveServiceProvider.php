<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Mime\Part\TextPart;
use Symfony\Component\Mime\Part\AbstractPart;

class MailSaveServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        Event::listen(MessageSent::class, function (MessageSent $event) {
            $message = $event->message;
            $body = '';

            $part = $message->getBody();

            if ($part instanceof TextPart) {
                $body = $part->getBody(); // lấy string thực
            } elseif ($part instanceof AbstractPart) {
                $body = $part->toString(); // fallback cho Multipart
            }

            if (!Storage::exists('mails')) {
                Storage::makeDirectory('mails');
            }

            $filename = 'mails/mail_' . now()->format('Ymd_His_u') . '.eml';
            Storage::put($filename, $body);
        });
    }
}
