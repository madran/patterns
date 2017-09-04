<?php
class Warrior
{
    private $activeWeapon;

    public function slash()
    {
        return $this->activeWeapon;
    }

    public function bash()
    {
        return $this->activeWeapon;
    }

    public function setActiveWeapon($weapon)
    {
        $this->activeWeapon = $weapon;
    }
}

class Sword
{
    public function __toString()
    {
        return 'Slash, slash...';
    }
}

class Hammer
{
    public function __toString()
    {
        return 'Bash, bash...';
    }
}

class Knife
{
    public function __toString()
    {
        return 'Cut, cut...';
    }
}

class Mallet
{
    public function __toString()
    {
        return 'Tenderize, tenderize...';
    }
}

class Kitchen
{
    public function prepareMeal($cook)
    {
        $cook->setActiveTool(new Knife());
        echo $cook->cut() . PHP_EOL;
        $cook->setActiveTool(new Mallet());
        echo $cook->tenderize() . PHP_EOL;
    }
}

abstract class AbstractCook
{
    abstract public function setActiveTool($tool);
    abstract public function cut();
    abstract public function tenderize();
}

class Housewife extends AbstractCook
{
    private $activeTool;

    public function setActiveTool($tool)
    {
        $this->activeTool = $tool;
    }

    public function cut()
    {
        return $this->activeTool;
    }

    public function tenderize()
    {
        return $this->activeTool;
    }
}

class CookAdapter extends AbstractCook
{
    private $warrior;

    public function __construct($person)
    {
        $this->warrior = $person;
    }

    public function setActiveTool($tool)
    {
        $this->warrior->setActiveWeapon($tool);
    }

    public function cut()
    {
        return $this->warrior->slash();
    }

    public function tenderize()
    {
        return $this->warrior->bash();
    }
}
echo 'Warrior:' . PHP_EOL;
$warrior = new Warrior();
$warrior->setActiveWeapon(new Knife());
echo $warrior->slash() . PHP_EOL;
$warrior->setActiveWeapon(new Hammer());
echo $warrior->bash() . PHP_EOL;

echo PHP_EOL;
echo 'Housewife:' . PHP_EOL;
$kitchen = new Kitchen();
$kitchen->prepareMeal(new Housewife());

echo PHP_EOL;
echo 'Warrior adapted to housewife:' . PHP_EOL;
$kitchen->prepareMeal(new CookAdapter(new Warrior()));
