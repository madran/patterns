<?php
class Warrior
{
    private $defense = 5;
    private $fieldOfView = 3;

    private $states = array();
    private $currentState = null;

    public function __construct()
    {
        $this->states['fortify'] = new UnitStateFortify(); 
        $this->states['sentry'] = new UnitStateSentry();
    }

    public function setDefaultState()
    {
        $this->currentState = null;
    }

    public function fortify()
    {
        $this->currentState = $this->states['fortify'];
    }

    public function sentry()
    {
        $this->currentState = $this->states['sentry'];
    }

    public function getDefense()
    {
        if ($this->currentState != null) {
            return $this->defense + $this->currentState->getBonusDefense();
        }

        return $this->defense;
    }

    public function getFieldOfView()
    {
        if ($this->currentState != null) {
            return $this->fieldOfView + $this->currentState->getBonusFieldOfView();
        }

        return $this->fieldOfView;
    }

    public function __toString()
    {
        if ($this->currentState == null) {
            return 'Stan domyślny: obrona=' . $this->getDefense() . ' | zasięg widzenia=' . $this->getFieldOfView() . PHP_EOL;
        } else {
            return 'Stan ' . $this->currentState->getStateName() . 
                   ': obrona=' . $this->getDefense() . 
                   ' | zasięg widzenia=' . $this->getFieldOfView() . PHP_EOL;
        }
    }
}

abstract class UnitState
{
    protected $bonusDefense;
    protected $bonusFieldOfView;
    protected $stateName;

    public function getBonusDefense()
    {
        return $this->bonusDefense;
    }

    public function getBonusFieldOfView()
    {
        return $this->bonusFieldOfView;
    }

    public function getStateName()
    {
        return $this->stateName;
    }
}

class UnitStateFortify extends UnitState
{
    public function __construct()
    {
        $this->stateName = 'fortify';
        $this->bonusDefense = 3;
    }
}

class UnitStateSentry extends UnitState
{
    public function __construct()
    {
        $this->stateName = 'sentry';
        $this->bonusFieldOfView = 2;
    }
}

$warrior = new Warrior();


echo $warrior;
$warrior->fortify();
echo $warrior;
$warrior->sentry();
echo $warrior;
$warrior->setDefaultState();
echo $warrior;

