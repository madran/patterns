<?php

class Warrior
{
    public $attack = 8;
    public $defense = 5;
    public $isDead = false;

    public function __toString()
    {
        return spl_object_hash($this);
    }
}

class Barracks
{
    private static $warriorsWaiting = array();
    private static $warriorsFighting = array();

    public static function getWarrior()
    {
        if (empty(self::$warriorsWaiting)) {
            $warrior = new Warrior();
            array_push(self::$warriorsFighting, $warrior);
            return $warrior;
        } else {
            $numberOfWarriorsWaiting = count(self::$warriorsWaiting);
            foreach (self::$warriorsWaiting as $warrior) {
                if ($warrior->isDead) {
                    self::$warriorsWaiting = array_diff(self::$warriorsWaiting, array($warrior));
                } else {
                    self::$warriorsWaiting = array_diff(self::$warriorsWaiting, array($warrior));
                    array_push(self::$warriorsFighting, $warrior);
                    return $warrior;
                }
            }
        }
    }

    public function quater($warrior)
    {
        array_push(self::$warriorsWaiting, $warrior);
        if (($key = array_search($warrior, self::$warriorsFighting)) !== false) {
            unset(self::$warriorsFighting[$key]);
        }
    }
}

$warriors = array();
for ($i = 0; $i < 5; $i++) {
    $warrior = Barracks::getWarrior();
    echo $warrior . PHP_EOL;
    $warriors[] = $warrior;
}

foreach ($warriors as $warrior) {
    $warrior->isDead = (boolean) rand(0, 1);
    Barracks::quater($warrior);
}

echo PHP_EOL;
echo PHP_EOL;

for ($i = 0; $i < 5; $i++) {
    $warrior = Barracks::getWarrior();
    echo $warrior . PHP_EOL;
    $warriors[] = $warrior;
}
