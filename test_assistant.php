<?php
// ------------- EX 01 --------------

abstract class AHero
{
    protected $name;
    protected $hp;

    public function __construct($string, int $int=100)
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

    public function setHeal(int $value)
    {
        if (is_numeric($value) and !($value < 0))
            $this->_heal = $value;
        return $this;
    }

    public function getHeal()
    {
        return intval($this->_heal);
    }
}

interface IDPS
{
    public function hitHero($hero);
    public function setDMG($value);
    public function getDMG();
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

    public function setDMG(int $value)
    {
        if (is_numeric($value) and !($value < 0))
            $this->_dmg = $value;
        return $this;
    }

    public function getDMG()
    {
        return intval($this->_dmg);
    }
}

// ------------- EX 03 --------------

class Warrior extends AHero implements IDPS
{
    private $_dmg;
    const MAX_HP = 200;
    const BASIC_DMG = 10;

    function __construct($string)
    {
        parent::__construct($string, self::MAX_HP);
        $this->_dmg = self::BASIC_DMG;
    }

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

    public function setDMG(int $hero)
    {
        if (is_numeric($value) and !($value < self::BASIC_DMG))
            $this->_dmg = $value;
        return $this;
    }

    public function getDMG()
    {
        return intval($this->_dmg);
    }

    public function __toString()
    {
        return "I'm a warrior hero and my name is ".$this->name." and I've got ".$this->hp." hp";
    }

    public function whoAmI()
    {
        return "I’m a warrior and I love to fight!\n";
    }
}

class Priest extends AHero implements ISupport
{
    private $_heal;
    const MAX_HP = 150;
    const BASIC_HEAL = 12;

    function __construct($string)
    {
        parent::__construct($string, self::MAX_HP);
        $this->_heal = self::BASIC_HEAL;
    }

    public function healHero($hero)
    {
        if ($hero->getHp() === $hero::MAX_HP)
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

    public function setHeal(int $value)
    {
        if (is_numeric($value) and !($value < self::BASIC_HEAL))
            $this->_heal = $value;
        return $this;
    }

    public function getHeal()
    {
        return intval($this->_heal);
    }

    public function __toString()
    {
    }

    public function whoAmI()
    {
        return "I'm a priest and I want to heal everyone!\n";
    }
}

?>
