<?php
interface Encoder
{
    public function encode($data) :string;
}

interface Decoder
{
    public function decode(string $data);
}

class JsonEncoder implements Encoder
{
    public function encode($data) :string
    {
        return json_encode($data);
    }
}

class JsonDecoder implements Decoder
{
    public function decode(string $data)
    {
        return json_decode($data);
    }
}

class XmlEncode implements Encoder
{
    public function encode($data) :string
    {
//        var_dump($data);
//        $xmlData = new SimpleXMLElement($data);
        return $data->asXML();
    }
}

class XmlDecode implements Decoder
{
    public function decode(string $data)
    {
        return new SimpleXMLElement($data);
    }
}

abstract class FormatConverterFactory
{
    abstract public function getDecoder();
    abstract public function getEncoder();
}

class JsonConverterFactory extends FormatConverterFactory
{
    public function getDecoder()
    {
        return new JsonDecoder();
    }
    
    public function getEncoder()
    {
        return new JsonEncoder();
    }
}

class XmlConverterFactory extends FormatConverterFactory
{
    public function getDecoder() {
        return new XmlDecode();
    }

    public function getEncoder() {
        return new XmlEncode();
    }
}

class NumberSubstractor
{
    public function substract(string $data, int $number, FormatConverterFactory $factory)
    {
        $decoder = $factory->getDecoder();
        
        $decodedData = $decoder->decode($data);
        
        $decodedData->first -= $number;
        $decodedData->second -= $number;
        $decodedData->third -= $number;
        
        $encoder = $factory->getEncoder();
        
        return $encoder->encode($decodedData);
    }
}

$json = '{"first": 10, "second": 20, "third": 30}';
$xml = '<root><first>10</first><second>20</second><third>30</third></root>';

echo 'Input:' . PHP_EOL;
echo 'JSON: ' . $json . PHP_EOL;
echo 'XML: ' . $xml . PHP_EOL;

$numberSubstractor = new NumberSubstractor();
$json = $numberSubstractor->substract($json, 3, new JsonConverterFactory());

echo PHP_EOL . PHP_EOL;

$xml = $numberSubstractor->substract($xml, 5, new XmlConverterFactory());

echo 'Output:' . PHP_EOL;
echo 'JSON: ' . $json . PHP_EOL;
echo 'XML: ' . $xml . PHP_EOL;