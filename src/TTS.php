<?php

namespace Microsoft\CognitiveServices\Speech;

class TTS
{
    private $key;
    private $region;
    private $client;

    /*
amr-wb-16000hz
audio-16khz-16bit-32kbps-mono-opus
audio-16khz-32kbitrate-mono-mp3
audio-16khz-64kbitrate-mono-mp3
audio-16khz-128kbitrate-mono-mp3
audio-24khz-16bit-24kbps-mono-opus
audio-24khz-16bit-48kbps-mono-opus
audio-24khz-48kbitrate-mono-mp3
audio-24khz-96kbitrate-mono-mp3
audio-24khz-160kbitrate-mono-mp3
audio-48khz-96kbitrate-mono-mp3
audio-48khz-192kbitrate-mono-mp3
ogg-16khz-16bit-mono-opus
ogg-24khz-16bit-mono-opus
ogg-48khz-16bit-mono-opus
raw-8khz-8bit-mono-alaw
raw-8khz-8bit-mono-mulaw
raw-8khz-16bit-mono-pcm
raw-16khz-16bit-mono-pcm
raw-16khz-16bit-mono-truesilk
raw-22050hz-16bit-mono-pcm
raw-24khz-16bit-mono-pcm
raw-24khz-16bit-mono-truesilk
raw-44100hz-16bit-mono-pcm
raw-48khz-16bit-mono-pcm
webm-16khz-16bit-mono-opus
webm-24khz-16bit-24kbps-mono-opus
webm-24khz-16bit-mono-opus
*/

    const AMR_WB_16000HZ = "amr-wb-16000hz";
    const AUDIO_16KHZ_16BIT_32KBPS_MONO_OPUS = "audio-16khz-16bit-32kbps-mono-opus";
    const AUDIO_16KHZ_32KBITRATE_MONO_MP3 = "audio-16khz-32kbitrate-mono-mp3";
    const AUDIO_16KHZ_64KBITRATE_MONO_MP3 = "audio-16khz-64kbitrate-mono-mp3";
    const AUDIO_16KHZ_128KBITRATE_MONO_MP3 = "audio-16khz-128kbitrate-mono-mp3";
    const AUDIO_24KHZ_16BIT_24KBPS_MONO_OPUS = "audio-24khz-16bit-24kbps-mono-opus";
    const AUDIO_24KHZ_16BIT_48KBPS_MONO_OPUS = "audio-24khz-16bit-48kbps-mono-opus";
    const AUDIO_24KHZ_48KBITRATE_MONO_MP3 = "audio-24khz-48kbitrate-mono-mp3";
    const AUDIO_24KHZ_96KBITRATE_MONO_MP3 = "audio-24khz-96kbitrate-mono-mp3";
    const AUDIO_24KHZ_160KBITRATE_MONO_MP3 = "audio-24khz-160kbitrate-mono-mp3";
    const AUDIO_48KHZ_96KBITRATE_MONO_MP3 = "audio-48khz-96kbitrate-mono-mp3";
    const AUDIO_48KHZ_192KBITRATE_MONO_MP3 = "audio-48khz-192kbitrate-mono-mp3";
    const OGG_16KHZ_16BIT_MONO_OPUS = "ogg-16khz-16bit-mono-opus";
    const OGG_24KHZ_16BIT_MONO_OPUS = "ogg-24khz-16bit-mono-opus";
    const OGG_48KHZ_16BIT_MONO_OPUS = "ogg-48khz-16bit-mono-opus";
    const RAW_8KHZ_8BIT_MONO_ALAW = "raw-8khz-8bit-mono-alaw";
    const RAW_8KHZ_8BIT_MONO_MULAW = "raw-8khz-8bit-mono-mulaw";
    const RAW_8KHZ_16BIT_MONO_PCM = "raw-8khz-16bit-mono-pcm";
    const RAW_16KHZ_16BIT_MONO_PCM = "raw-16khz-16bit-mono-pcm";
    const RAW_16KHZ_16BIT_MONO_TRUESILK = "raw-16khz-16bit-mono-truesilk";
    const RAW_22050HZ_16BIT_MONO_PCM = "raw-22050hz-16bit-mono-pcm";
    const RAW_24KHZ_16BIT_MONO_PCM = "raw-24khz-16bit-mono-pcm";
    const RAW_24KHZ_16BIT_MONO_TRUESILK = "raw-24khz-16bit-mono-truesilk";
    const RAW_44100HZ_16BIT_MONO_PCM = "raw-44100hz-16bit-mono-pcm";
    const RAW_48KHZ_16BIT_MONO_PCM = "raw-48khz-16bit-mono-pcm";
    const WEBM_16KHZ_16BIT_MONO_OPUS = "webm-16khz-16bit-mono-opus";
    const WEBM_24KHZ_16BIT_24KBPS_MONO_OPUS = "webm-24khz-16bit-24kbps-mono-opus";
    const WEBM_24KHZ_16BIT_MONO_OPUS = "webm-24khz-16bit-mono-opus";

    public function __construct(string $key, string $region = "eastasia")
    {
        $this->key = $key;
        $this->region = $region;
        $this->client = new \GuzzleHttp\Client([
            "base_uri" => "https://" . $this->region . ".tts.speech.microsoft.com/cognitiveservices/v1",
        ]);
    }

    public function getVoicesList()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://" . $this->region . ".tts.speech.microsoft.com/cognitiveservices/voices/list", [
            "headers" => [
                "Ocp-Apim-Subscription-Key" => $this->key
            ],
            "verify" => false
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    private function getToken()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post("https://" . $this->region . ".api.cognitive.microsoft.com/sts/v1.0/issuetoken", [
            "headers" => [
                "Ocp-Apim-Subscription-Key" => $this->key
            ],
            "verify" => false
        ]);

        return $response->getBody()->getContents();
    }

    public function convert(string $text, string $format = self::AUDIO_24KHZ_160KBITRATE_MONO_MP3, string $voice = "zh-HK-HiuGaaiNeural")
    {
        //generate xml
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>' . "<speak version='1.0' xml:lang='en-US'></speak>");
        $v = $xml->addChild("voice");
        $v->addAttribute("name", $voice);
        $v[0] = $text;


        $body = $xml->saveXML();

        //remove xml header
        $body = str_replace('<?xml version="1.0" encoding="utf-8"?>', "", $body);

        $response = $this->client->post("", [
            "headers" => [
                "Authorization" => "Bearer " . $this->getToken(),
                "Content-Type" => "application/ssml+xml",
                "X-Microsoft-OutputFormat" => $format,
                "User-Agent" => "TTSForPHP"
            ],
            "verify" => false,
            "body" => $body
        ]);

        return $response->getBody()->getContents();
    }

    public function save(string $text, string $file, string $format = self::AUDIO_24KHZ_160KBITRATE_MONO_MP3, string $voice = "zh-HK-HiuGaaiNeural")
    {
        $data = $this->convert($text, $format, $voice);
        return file_put_contents($file, $data);
    }
}
