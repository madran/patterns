<?php

abstract class Stream
{
    protected $name;
    protected $data;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->data = '';
    }
    
    public function add(string $data) :void
    {
        $this->data .= $data;
    }
    
    public function setData(string $data) :void
    {
        $this->data = $data;
    }
    
    public function getData() :string
    {
        return $this->data;
    }
    
    abstract public function save() :void;
}

class FileStream extends Stream
{
    public function save(): void
    {
        file_put_contents($this->name, $this->data);
    }
}

abstract class StreamModes extends Stream
{
    protected $stream;
    
    public function __construct(Stream $stream)
    {
//        if (is_a($stream, StreamModes::class)) {
//            $this->stream = $stream->getStream();
//        } else {
            $this->stream = $stream;
//        }
    }
    
    public function getStream() :Stream
    {
        return $this->stream;
    }
    
    public function setData(string $data) :void
    {
        $this->stream->setData($data);
    }
    
    public function add(string $data) :void
    {
        $this->stream->add($data);
    }
    
    public function getData() :string
    {
        return $this->stream->getData();
    }
    
    public function save(): void
    {
        $this->stream->save();
    }
}

class CompressStream extends StreamModes
{
    public function save() :void
    {
        $compressedData = gzcompress($this->stream->getData());
        $this->stream->setData($compressedData);
        $this->stream->save();
    }
}

class AsciiStream extends StreamModes
{
    public function save() :void
    {
        $data = $this->stream->getData();
        $asciiData = '';
        
        foreach ($this->stringIterate($data) as $char) {
            $asciiData .= strval(ord($char));
        }
        
        $this->stream->setData($asciiData);
        $this->stream->save();
    }
    
    private function stringIterate($str)
    {
        $length = mb_strlen($str);
        
        for ($i = 0; $i < $length; $i++) {
            yield mb_substr($str, $i, 1);
        }
    }
}

$stream = new CompressStream(new FileStream('decorator'));
$stream->add('Kamilka tralalala hopsa hopsa sa');
$stream->save();

$data = file_get_contents('decorator');
echo 'Uncompressed -> Size: ' . strlen(gzuncompress($data)) . ' Value: ' . gzuncompress($data) . PHP_EOL;
echo 'Compressed -> Size: ' . strlen($data) . ' Value: ' . $data . PHP_EOL;

$stream = new AsciiStream(new FileStream('decorator'));
$stream->add('Kamilka tralalala hopsa hopsa sa');
$stream->save();

$data = file_get_contents('decorator');
echo 'Ascii: ' . $data . PHP_EOL;

echo PHP_EOL;

$stream = new AsciiStream(new CompressStream(new FileStream('decorator')));
$stream->add('Kamilka tralalala hopsa hopsa sa');
$stream->save();

$data = file_get_contents('decorator');
echo 'Uncompressed -> Size: ' . strlen(gzuncompress($data)) . ' Value: ' . gzuncompress($data) . PHP_EOL;
echo 'Compressed -> Size: ' . strlen($data) . ' Value: ' . $data . PHP_EOL;