<?php

interface TvControl
{
    public function setControlSystem(TvControlSystem $controlSystem) :void;
    public function on() :void;
    public function off() :void;
    public function changeChannel(int $channel) :void;
}

class SonyTvControl implements TvControl
{
    private $controlSystem;
    
    public function setControlSystem(TvControlSystem $controlSystem) :void
    {
        $this->controlSystem = $controlSystem;
    }
    
    public function changeChannel(int $channel): void
    {
        $this->controlSystem->changeChannel($channel);
        echo 'sony ' . $channel . PHP_EOL;
    }

    public function off(): void
    {
        $this->controlSystem->off();
        echo 'sony off' . PHP_EOL;
    }

    public function on(): void
    {
        $this->controlSystem->on();
        echo 'sony on' . PHP_EOL;
    }
}

class SamsungTvControl implements TvControl
{
    private $controlSystem;
    
    public function setControlSystem(TvControlSystem $controlSystem) :void
    {
        $this->controlSystem = $controlSystem;
    }
    
    public function changeChannel(int $channel): void
    {
        $this->controlSystem->changeChannel($channel);
        echo 'samsung ' . $channel . PHP_EOL;
    }

    public function off(): void
    {
        $this->controlSystem->off();
        echo 'samsung off' . PHP_EOL;
    }

    public function on(): void
    {
        $this->controlSystem->on();
        echo 'samsung on' . PHP_EOL;
    }
}

interface TvControlSystem
{
    public function on() :void;
    public function off() :void;
    public function changeChannel(int $channel) :void;
}

class ManualControl implements TvControlSystem
{
    public function changeChannel(int $channel): void
    {
        echo 'Manual: ';
    }

    public function off(): void
    {
        echo 'Manual: ';
    }

    public function on(): void
    {
        echo 'Manual: ';
    }
}

class RemoteControl implements TvControlSystem
{
    public function changeChannel(int $channel): void
    {
        echo 'Remote: ';
    }

    public function off(): void
    {
        echo 'Remote: ';
    }

    public function on(): void
    {
        echo 'Remote: ';
    }
}

$samsungTv = new SamsungTvControl();

echo 'Samsung manual control:' . PHP_EOL;
$samsungTv->setControlSystem(new ManualControl());
$samsungTv->on();
$samsungTv->changeChannel(22);
$samsungTv->off();

echo PHP_EOL . PHP_EOL;

echo 'Samsung remote control:' . PHP_EOL;
$samsungTv->setControlSystem(new RemoteControl());
$samsungTv->on();
$samsungTv->changeChannel(13);
$samsungTv->off();