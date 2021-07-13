<?php

class Archer extends Character{

  private $arrowNumber = 3; //numéros de flèches on peut dire que c'est le carquois
  private $daggerDamage;
  private $isAiming = false; //attribut viser un point faible initialisé comme inactif


  public function __construct($name){
    parent::__construct($name);
    //l'attaque avec la dague c'est moins de dégats, donc on choisit la moitié
    $this->daggerDamage = $this->damage/2;
  }

  public function turn($target){
    $rand = rand (1,10);
    //Chance de 60% de tirer une flèche
    if ($rand <= 6 || $this->isAiming == true){
      $status = $this->arrow($target);

    }else if ($rand > 4){
      //il vise un point faible mais il n'attaque pas dans ce tour
      $status = $this->aimWeakPoint();
    }
    return $status;
  }

  public function arrow($target){
    //s'il a encore de flèches
    if ($this->arrowNumber > 0) {
      // si est en train de viser un point faible
      if ($this->isAiming == true) {
        $aimingDamage = $this->damage * rand(15,30)/10;
        $target->setHealthPoints($aimingDamage);
        $this->isAiming = false;
        // il perte une flèche chaque fois qu'il tire
        $this->arrowNumber -= 1;
        
        $status = "$this->name tire une flèche en visant un point faible sur $target->name! Il reste $target->healthPoints de vie à  $target->name et $this->arrowNumber flèches à $this->name";

      }else{
        //s'il ne vise pas, il tire une flèche normal
        $target->setHealthPoints($this->damage);
        $this->arrowNumber -= 1;
        
        $status = "$this->name tire une flèche sur $target->name! Il reste $target->healthPoints de vie à $target->name et $this->arrowNumber flèches à $this->name";
      }
    
    }else{
      // il n'a plus de flèches attack avec une dague
      $status = $this->dagger($target);
    }
    return $status;
  }

  //fonction viser un point faible
  public function aimWeakPoint(){
    $this->isAiming = true;
    $status = "$this->name vise un point faible et inflige un fort dégat au tour suivant";
    return $status;
  }
  //attaque avec une dague
  public function dagger($target){
    $target->setHealthPoints($this->daggerDamage);
    $status = "$this->name attaque avec sa dague à $target->name! Il reste $target->healthPoints de vie à $target->name";
    return $status;
  }

}