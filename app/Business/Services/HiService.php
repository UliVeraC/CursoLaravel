<?php

namespace App\Business\Services;

use App\Business\Interfaces\MessageServiceInterface;

class HiService implements MessageServiceInterface
{
    public function Hi(){
        return "Hola Mundo";
    }
}