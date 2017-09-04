<?php
class Player {
    public $health = 100;
    public $stamina = 25;
    public $food = 100;
    public $water = 100;

    public function __construct($playerStatus = null)
    {
        if(!empty($playerStatus)) {
            $this->health = $playerStatus->health;
            $this->stamina = $playerStatus->stamina;
            $this->food = $playerStatus->food;
            $this->water = $playerStatus->water;
        }
    }

    public function saveStatus()
    {
        return new PlayerStatus($this);
    }

    public function __toString()
    {
        return  'Health: ' . $this->health . PHP_EOL .
                'Stamina: ' . $this->stamina . PHP_EOL .
                'Food: ' . $this->food . PHP_EOL .
                'Water: ' . $this->water;
    }
}

class PlayerStatus {
    public $health;
    public $stamina;
    public $food;
    public $water;

    public function __construct($player)
    {
        $this->health = $player->health;
        $this->stamina = $player->stamina;
        $this->food = $player->food;
        $this->water = $player->water;
    }
}

class GameSave {
    private $playerStatusSave = array();

    public function addSave($save)
    {
        array_push($this->playerStatusSave, $save);
    }

    public function getSave($index)
    {
        return $this->playerStatusSave[$index];
    }
}

$player = new Player();
echo 'Start gry:' . PHP_EOL;
echo $player . PHP_EOL;
echo PHP_EOL;
echo 'Gra...' . PHP_EOL;
echo PHP_EOL;

$player->health = 72;
$player->stamina = 32;
$player->food = 89;
$player->water = 43;

echo 'Zapis gry' . PHP_EOL;
$gameSave = new GameSave();
$gameSave->addSave($player->saveStatus());
echo PHP_EOL;

echo 'Wczytanie gry:' . PHP_EOL;
$loadedPlayer = new Player($gameSave->getSave(0));
echo $loadedPlayer . PHP_EOL;
