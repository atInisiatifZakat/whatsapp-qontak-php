# WhatsApp Qontak API

Sending WhatsApp message via Qontak API, using [HTTPlug](https://github.com/php-http/httplug).

## Installation

First
install [HTTPlug](https://github.com/php-http/httplug) [adapter or client](https://docs.php-http.org/en/latest/clients.html)

```bash
composer require php-http/curl-client
```

and then install this package :

```bash
composer require inisiatif/whatsapp-qontak-php
```

## Usage

First your must be created a valid and approved WhatsApp template.

```php
use Inisiatif\WhatsappQontakPhp\Client;
use Inisiatif\WhatsappQontakPhp\Message\Body;
use Inisiatif\WhatsappQontakPhp\Message\Button;
use Inisiatif\WhatsappQontakPhp\Message\Header;
use Inisiatif\WhatsappQontakPhp\Message\Message;
use Inisiatif\WhatsappQontakPhp\Message\Receiver;
use Inisiatif\WhatsappQontakPhp\Message\Language;

$credentials = Credential('username', 'password', 'clientId', 'clientSecret');

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
