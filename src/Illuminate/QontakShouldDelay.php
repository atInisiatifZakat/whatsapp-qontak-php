<?php

declare(strict_types=1);

namespace Inisiatif\WhatsappQontakPhp\Illuminate;

interface QontakShouldDelay
{
  public function getReleaseDelay(): int;
}
