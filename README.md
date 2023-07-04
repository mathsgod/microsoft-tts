# Microsoft TTS

## Installation

```bash
composer require mathsgod/microsoft-tts
```

## Usage

```php
use Microsoft\CognitiveServices\Speech\TTS;

require __DIR__ . '/vendor/autoload.php';

$key='YOUR_KEY';
$tts = new TTS($key);
$tts->save('Hello World', 'hello-world.mp3');
```


