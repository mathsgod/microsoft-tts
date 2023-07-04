# Microsoft TTS

## Installation

```bash
composer require mathsgod/microsoft-tts
```

## Usage

```php
use Microsoft\CognitiveServices\Speech\TTS;

require __DIR__ . '/vendor/autoload.php';

$region="eastasia";
$key='YOUR_KEY';
$tts = new TTS($key, $region);
$tts->save('Hello World', 'hello-world.mp3');
```


### Format and Voice
    
```php
$format=TTS::AUDIO_24KHZ_160KBITRATE_MONO_MP3;
$voice="zh-HK-HiuGaaiNeural";
$tts->save('Hello World', 'hello-world.mp3', $format, $voice);
```

### Get voices list
    
```php
$voices=$tts->getVoicesList();
```