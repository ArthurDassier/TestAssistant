<?php
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

    public function __get($property) {
        if (property_exists($this, $property))
            return $this->$property;
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            if ('name' === $property and (strlen($value) > 0) and !(is_numeric($value)))
                $this->$property = $value;
            if ('hp' === $property and is_numeric($value) and !($value < 0))
                $this->$property = $value;
        }
    
        return $this;
    }

    public function isDead() {
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
?>
