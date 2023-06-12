# WhatsApp Qontak API

Sending WhatsApp message via Qontak API, using [HTTPlug](https://github.com/php-http/httplug).

## Installation

First install HTTPlug [adapter or client](https://docs.php-http.org/en/latest/clients.html)
and PSR-17 package compatible

```bash
composer require php-http/curl-client laminas/laminas-diactoros
```

and then install this package :

```bash
composer require inisiatif/whatsapp-qontak-php
```

## Usage

### Non framework usage

First your must be created a valid and approved WhatsApp template.

```php
use Inisiatif\WhatsappQontakPhp\Client;
use Inisiatif\WhatsappQontakPhp\Credential;
use Inisiatif\WhatsappQontakPhp\Message\Body;
use Inisiatif\WhatsappQontakPhp\Message\Button;
use Inisiatif\WhatsappQontakPhp\Message\Header;
use Inisiatif\WhatsappQontakPhp\Message\Message;
use Inisiatif\WhatsappQontakPhp\Message\Receiver;
use Inisiatif\WhatsappQontakPhp\Message\Language;

$credentials = new Credential('username', 'password', 'clientId', 'clientSecret');

$client = new Client($credentials);

// Create message receiver
$receiver = new Receiver('+6281318788271', 'Nuradiyana');

// [Optional] Create language, supported 'en' and 'id', default is 'id'
$language = new Language('id');

// [Optional] Create params message body
$body = [
    new Body('Nuradiyana'),
    new Body('Gorengan'),
];

// [Optional] Create header message, support "DOCUMENT", "VIDEO", "IMAGE"
$header = new Header(
    Header::TYPE_DOCUMENT, 'https://example.com/link-to-file-url.pdf', 'file-name.pdf'
);

// [Optional] Create buttons
$buttons = [new Button('url', 'https://example.com')];

$message = new Message($receiver, $language, $body, $header, $buttons);
$response = $client->send('templateId', 'channelId', $message);

// Message Id and Receiver Name
echo $response->getMessageId();
echo $response->getName();

// All raw data
\var_dump($response->getData());
```

### Using in Laravel as Notification Channel

1. Add new config value in `config/services.php` and then setting each value in `.env`

```php
'qontak' => [
    'username' => env('QONTAK_USERNAME', null),
    'password' => env('QONTAK_PASSWORD', null),
    'client_id' => env('QONTAK_CLIENT_ID', null),
    'client_secret' => env('QONTAK_CLIENT_SECRET', null),
],
```

2. Add this code in `register` method `AppServiceProvider`

```php
$this->app->singleton(\Inisiatif\WhatsappQontakPhp\ClientInterface::class, function () {
    return $this->app->runningUnitTests() ? \Inisiatif\WhatsappQontakPhp\ClientFactory::makeTestingClient() :  \Inisiatif\WhatsappQontakPhp\ClientFactory::makeFromArray(
        config('service.qontak')
    );
});
```

3. Then create or register `ContakChannel` in notification class

```php
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Inisiatif\WhatsappQontakPhp\Message\Message;
use Inisiatif\WhatsappQontakPhp\Message\Receiver;
use Inisiatif\WhatsappQontakPhp\Illuminate\Envelope;
use Inisiatif\WhatsappQontakPhp\Illuminate\QontakChannel;
use Inisiatif\WhatsappQontakPhp\Illuminate\QontakNotification;

class InvoicePaid extends Notification implements QontakNotification
{
    use Queueable;
 
    public function via($notifiable): array
    {
        return [QontakChannel::class];
    }
 
    public function toQontak($notifiable): Envelope
    {
        // First create message object
        $receiver = new Receiver('+6281318788271', 'Nuradiyana');
        $message = new Message($receiver);
        
        // Then create envelope object and return it
        return new Envelope('templateId', 'channelId', $message);
    }
}
```

## Testing

🧹 Fixing codebase with **Easy Coding Standard**:

```bash
composer ecs
```

⚗️ Run static analysis using **Psalm**:

```bash
composer psalm
```

🚀 Run the entire test suite:

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
