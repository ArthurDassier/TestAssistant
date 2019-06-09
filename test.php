<?php

$warrior = new Warrior("toto");
echo $warrior . "\n";
echo $warrior->getDMG() . "\n";
$warrior->whoAmI();
$receptarier = new Receptarier("zero");
echo $receptarier . "\n";
echo $receptarier->getDMG() . "\n";
echo $receptarier->getHeal() . "\n";
$receptarier->whoAmI();
$priest = new priest("meow");
echo $priest . "\n";
echo $priest->getHeal() . "\n";
$priest->whoAmI();
$receptarier->hitHero($warrior);
echo $warrior . "\n";
$receptarier->healHero($warrior);
echo $warrior . "\n";

////////////////////////////////////////////////////

$truc = ParseFile::getInstance();

echo ($truc->getHeroesFromFile("text.txt"))[0];
echo "\n";
echo ($truc->getHeroesFromFile("text.txt"))[1];
echo "\n";
echo ($truc->getHeroesFromFile("text.txt"))[1]->getHeal();
echo "\n";
echo ($truc->getHeroesFromFile("text.txt"))[2];
echo "\n";
echo ($truc->getHeroesFromJSON("bonus.json")[0]);
echo "\n";

?>