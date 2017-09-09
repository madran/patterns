<?php

class Warrior
{
    public static $instances = 0;
    public $instance = 0;
    public $attack = 8;
    public $defense = 5;
    public $isDead = false;

    public function __toString()
    {
        return spl_object_hash($this);
    }
}

abstract class HumanResources
{
    protected $waiting = [];
    protected $busy = [];
    
    protected function getOneHuman()
    {
        if (empty($this->waiting)) {
            $humanResource = $this->createNewHumanResource();
            $this->busy[spl_object_hash($humanResource)] = $humanResource;
            return $humanResource;
        } else {
            foreach ($this->waiting as $humanRsourceKey => $humanResource) {
                unset($this->waiting[$humanRsourceKey]);
                if ($this->shoudlBeRemovedOnReceive($humanResource) === false) {
                    $this->busy[$humanRsourceKey] = $humanResource;
                    return $humanResource;
                }
            }
            return $this->getOneHuman();
        }
    }
    
    protected function returnOneHuman($humanRsource)
    {
        unset($this->busy[spl_object_hash($humanRsource)]);
        if ($this->shoudlBeRemovedOnReturn($humanRsource) === false) {
            $this->waiting[spl_object_hash($humanRsource)] = $humanRsource;
        }
    }
    
    abstract protected function createNewHumanResource();
    
    abstract protected function shoudlBeRemovedOnReturn($hr) : bool;
    abstract protected function shoudlBeRemovedOnReceive($hr) : bool;
}

class Barracks extends HumanResources
{
    public function getWarrior()
    {
        return $this->getOneHuman();
    }

    public function quater($warrior)
    {
        $this->returnOneHuman($warrior);
    }
    
    protected function createNewHumanResource()
    {
        $hr = new Warrior();
        $hr->instance = ++Warrior::$instances;
        return $hr;
    }

    protected function shoudlBeRemovedOnReceive($hr): bool
    {
        return false;
    }

    protected function shoudlBeRemovedOnReturn($hr): bool
    {
        return $hr->isDead;
    }

}

$barracks = new Barracks();
$warriors = array();
for ($i = 0; $i < 5; $i++) {
    $warrior = $barracks->getWarrior();
    echo 'Warrior: ' . $warrior->instance . ' isDead=' . ($warrior->isDead ? 'true' : 'false') . PHP_EOL;
    $warriors[] = $warrior;
}

echo PHP_EOL;
echo PHP_EOL;

foreach ($warriors as $warrior) {
    $warrior->isDead = (boolean) rand(0, 1);
    echo 'Warrior: ' . $warrior->instance . ' isDead=' . ($warrior->isDead ? 'true' : 'false') . PHP_EOL;
    $barracks->quater($warrior);
}

echo PHP_EOL;
echo PHP_EOL;

for ($i = 0; $i < 5; $i++) {
    $warrior = $barracks->getWarrior();
    echo 'Warrior: ' . $warrior->instance . ' isDead=' . ($warrior->isDead ? 'true' : 'false') . PHP_EOL;
    $warriors[] = $warrior;
}
