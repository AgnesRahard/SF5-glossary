<?php

namespace App\Service;

class MessageGenerator
{
    public function getMessage($typeMessage)
    {
        switch ($typeMessage) {
            case "success":
                $message = 'Bravo!';
                break;
            case "notice":
            case "warning":
            case "danger":
                $message = "Problème lors de l'opération";
                break;
            default:
                $message = "Cas particulier";
                break;
        }

        return $message;
    }
}
