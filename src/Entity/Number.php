<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Number {

   /**
    * Valeur du nombre testé
    *
    * @Assert\Positive
    * 
    * @var integer
    */ 
   private $value;

   /**
    * Get the value of value
    */ 
   public function getValue()
   {
      return $this->value;
   }

   /**
    * Set the value of value
    *
    * @return  self
    */ 
   public function setValue($value)
   {
      $this->value = $value;

      return $this;
   }
}