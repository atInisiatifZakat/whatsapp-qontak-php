<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Illuminate;

interface QontakNotification
{
    /**
     * @param mixed $notifiable
     */
    public function toQontak($notifiable): Envelope;
}
