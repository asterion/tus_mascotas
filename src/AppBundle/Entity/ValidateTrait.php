<?php

namespace AppBundle\Entity;

trait ValidateTrait
{
    public static function isRut($rut)
    {
        $rut = preg_replace('/[^0-9kK]/', '', $rut);

        $dv = mb_strtoupper(substr($rut, -1));
        $rut = substr($rut, 0, strlen($rut)-1);

        $s=1;

        for($m=0;$rut!=0;$rut/=10) {
            $s=($s+$rut%10*(9-$m++%6))%11;
        }

        return chr($s?$s+47:75) == $dv;
    }
}
