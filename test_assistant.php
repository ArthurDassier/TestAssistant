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
        return "I'm a hero, my name is [".$this->name."] and I've got [".$this->hp."] hp";
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
    public function setHeal(int $value);
    public function getHeal();
}

interface IDPS
{
    public function hitHero($hero);
    public function setDMG(int $value);
    public function getDMG();
}

// ------------- EX 03 --------------

final class Warrior extends AHero implements IDPS
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
        else if (($hero->getHp() - $this->_dmg) < 0) {
            $hero->setHp(0);
            return true;
        } else {
            $hero->setHp($hero->getHp() - $this->_dmg);
            return true;
        }
    }

    public function setDMG(int $value)
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
        return "I'm a warrior hero and my name is [".$this->name."] and I've got [".$this->hp."] hp";
    }

    public function whoAmI()
    {
        echo "I’m a warrior and I love to fight!\n";
    }
}

final class Priest extends AHero implements ISupport
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
        else if (($hero->getHp() + $this->_heal) > $hero::MAX_HP) {
            $hero->setHp($hero->getHp() + ($hero::MAX_HP - $hero->getHp()));
            return true;
        } else {
            $hero->setHp($hero->getHp() + $this->_heal);
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

    public function whoAmI()
    {
        echo "I'm a priest and I want to heal everyone!\n";
    }
}

final class Receptarier extends AHero implements IDPS, ISupport
{
    private $_dmg;
    private $_heal;
    const MAX_HP = 230;
    const BASIC_DMG = 18;
    const BASIC_HEAL = 17;

    function __construct($string)
    {
        parent::__construct($string, self::MAX_HP);
        $this->_dmg = self::BASIC_DMG;
        $this->_heal = self::BASIC_HEAL;
    }

    public function hitHero($hero)
    {
        if ($hero->getHp() === 0)
            return false;
        else if ($this->_dmg === 0)
            return false;
        else if (($hero->getHp() - $this->_dmg) < 0) {
            $hero->setHp(0);
            return true;
        } else {
            $hero->setHp($hero->getHp() - $this->_dmg);
            return true;
        }
    }

    public function setDMG(int $value)
    {
        if (is_numeric($value) and !($value < self::BASIC_DMG))
            $this->_dmg = $value;
        return $this;
    }

    public function getDMG()
    {
        return intval($this->_dmg);
    }

    public function healHero($hero)
    {
        if ($hero->getHp() === $hero::MAX_HP)
            return false;
        else if ($this->_heal === 0)
            return false;
        else if (($hero->getHp() + $this->_heal) > $hero::MAX_HP) {
            $hero->setHp($hero->getHp() + ($hero::MAX_HP - $hero->getHp()));
            return true;
        } else {
            $hero->setHp($hero->getHp() + $this->_heal);
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

    public function whoAmI()
    {
        echo "I'm a receptarier and I want to save everyone behind me!\n";
    }
}

// ------------- EX 04 --------------

class ParseFile
{
    private static $_instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance))
            self::$_instance = new ParseFile();
        return self::$_instance;
    }

    public function getContentFile($path)
    {
        $content = file_get_contents($path);

        if ($content === FALSE)
            throw new Exception("Error occured.");
        echo $content;
    }

    public function getHeroesFromFile($path)
    {
        $handle = @fopen($path, "r");
        $result = array();

        if ($handle) {
            while (($buffer = fgets($handle)) !== false) {
                $array = explode(" ", $buffer);

                if (sizeof($array) < 2)
                    throw new Exception("Error occured 2.");
                $classname = reset($array);

                try {
                    $obj = new $classname($array[1]);
                } catch (Exception $e) {
                    throw new Exception("Error occured 3.");
                }
                for ($i = 2; $i < sizeof($array); $i++) {
                    try {
                        $d = explode(":", $array[$i]);

                        if ($d[0] === "d")
                            $obj->setDMG(intval($d[1]));
                        else if ($d[0] === "h")
                            $obj->setHeal(intval($d[1]));
                        else
                            throw new Exception("Error occured 4.");
                    } catch (Exception $e) {
                        throw new Exception("Error occured 4.");
                    }
                }
                array_push($result, $obj);
            }
            if (!feof($handle))
                throw new Exception("Error occured 1.");
            fclose($handle);
        } else
            throw new Exception("Error occured 1.");
        return $result;
    }

    public function getHeroesFromJSON($path)
    {
        $content = file_get_contents($path);
        $result = array();

        if ($content === FALSE)
            throw new Exception("Error occured 1.");
        $data = json_decode($content);
        foreach ($data as $hero) {
            try {
                $obj = new $hero->class($hero->name);
            } catch (Exception $e) {
                throw new Exception("Error occured 3.");
            }
            if (array_key_exists('d', $hero)) {
                try {
                    $obj->setDMG(intval($hero->d));
                } catch (Exception $e) {
                    throw new Exception("Error occured 4.");
                }
            }
            if (array_key_exists('h', $hero)) {
                try {
                    $obj->setHeal(intval($hero->h));
                } catch (Exception $e) {
                    throw new Exception("Error occured 4.");
                }
            }
            array_push($result, $obj);
        }
        return $result;
    }
}

// ------------- BONUS --------------

final class Drood extends AHero implements IDPS, ISupport
{
    private $_dmg;
    private $_heal;
    const MAX_HP = 180;
    const BASIC_DMG = 20;
    const BASIC_HEAL = 22;

    function __construct($string)
    {
        parent::__construct($string, self::MAX_HP);
        $this->_dmg = self::BASIC_DMG;
        $this->_heal = self::BASIC_HEAL;
    }

    public function hitHero($hero)
    {
        if ($hero->getHp() === 0)
            return false;
        else if ($this->_dmg === 0)
            return false;
        else if (($hero->getHp() - $this->_dmg) < 0) {
            $hero->setHp(0);
            return true;
        } else {
            $hero->setHp($hero->getHp() - $this->_dmg);
            return true;
        }
    }

    public function setDMG(int $value)
    {
        if (is_numeric($value) and !($value < self::BASIC_DMG))
            $this->_dmg = $value;
        return $this;
    }

    public function getDMG()
    {
        return intval($this->_dmg);
    }

    public function healHero($hero)
    {
        if ($hero->getHp() === $hero::MAX_HP)
            return false;
        else if ($this->_heal === 0)
            return false;
        else if (($hero->getHp() + $this->_heal) > $hero::MAX_HP) {
            $hero->setHp($hero->getHp() + ($hero::MAX_HP - $hero->getHp()));
            return true;
        } else {
            $hero->setHp($hero->getHp() + $this->_heal);
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

    public function whoAmI()
    {
        echo "I'm a drood and I can transform!\n";
    }
}

final class Viking extends AHero implements IDPS
{
    private $_dmg;
    const MAX_HP = 80;
    const BASIC_DMG = 50;

    function __construct($string)
    {
        parent::__construct("Bernard le Viking", self::MAX_HP);
        $this->_dmg = self::BASIC_DMG;
    }

    public function hitHero($hero)
    {
        if ($hero->getHp() === 0)
            return false;
        else if ($this->_dmg === 0)
            return false;
        else if (($hero->getHp() - $this->_dmg) < 0) {
            $hero->setHp(0);
            return true;
        } else {
            $hero->setHp($hero->getHp() - $this->_dmg);
            return true;
        }
    }

    public function setDMG(int $value)
    {
        if (is_numeric($value) and !($value < self::BASIC_DMG))
            $this->_dmg = $value;
        return $this;
    }

    public function getDMG()
    {
        return intval($this->_dmg);
    }

    public function whoAmI()
    {
        echo "I’m Bernard le Viking and I SMASH!\n";
    }
}

?>
