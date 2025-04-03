<?php
namespace App\Business\Services;

class SingletonService{
public $value;

public function __construct(){
    $this->value = random_int(1,1000);
}

}