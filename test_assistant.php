<?php
// ------------- EX 01 --------------

abstract class AHero
{
    protected $name;
    protected $hp;

    public function __construct($string, $int=100)
    {
      $this->name = $string;
      $this->hp = $int;
    }

    public function __toString()
    {
        return "I'm a hero, my name is ".$this->name." and I've got ".$this->hp." hp";
    }

    public function setName($value)
    {
        if ((strlen($value) > 0) and !(is_numeric($value)))
            $this->name = $value;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setHp($value)
    {
        if (is_numeric($value) and !($value < 0))
            $this->hp = $value;
        return $this;
    }

    public function getHp()
    {
        return $this->hp;
    }

    public function isDead()
    {
        return ($this->hp === 0);
    }

    abstract public function whoAmI();
}

class Toto extends AHero
{
    public function whoAmI()
    {
    }
}

// ------------- EX 02 --------------

interface ISupport
{
    public function healHero($hero);
    public function setHeal($value);
    public function getHeal();
}

class Drood implements ISupport
{
    private $_heal;

    public function healHero($hero)
    {
        if ($hero->getHp() === 100)
            return false;
        else if ($this->_heal === 0)
            return false;
        else if (($hero->getHp() + $_heal) > 100) {
            $hero->setHp($hero->getHp() + (100 - $hero->getHp()));
            return true;
        } else {
            $hero->setHp($hero->getHp() + $_heal);
            return true;
        }
    }

    public function setHeal($hero)
    {
        if (is_numeric($value) and !($value < 0))
            $this->_heal = $value;
        return $this;
    }

    public function getHeal()
    {
        return $this->_heal;
    }
}

interface IDPS
{
    public function hitHero($hero);
    public function setHeal($value);
    public function getHeal();
}

class Rogue implements IDPS
{
    private $_dmg;

    public function hitHero($hero)
    {
        if ($hero->getHp() === 0)
            return false;
        else if ($this->_dmg === 0)
            return false;
        else if (($hero->getHp() - $_dmg) < 0) {
            $hero->setHp(0);
            return true;
        } else {
            $hero->setHp($hero->getHp() - $_dmg);
            return true;
        }
    }

    public function setDMG($hero)
    {
        if (is_numeric($value) and !($value < 0))
            $this->_dmg = $value;
        return $this;
    }

    public function getDMG()
    {
        return $this->_dmg;
    }
}
?>
