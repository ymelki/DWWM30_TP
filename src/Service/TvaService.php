<?php

namespace App\Service;

class TvaService {
    public function calcul(float $prix){
        return $prix * 0.2;
    }
}