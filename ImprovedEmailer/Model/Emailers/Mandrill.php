<?php namespace MageTitans\ImprovedEmailer\Model\Emailers;

use Emailer;
use MageTitans\ImprovedEmailer\Api\EmailerInterface;

class Mandrill implements EmailerInterface
{
    public function setVariables(array $templateData)
    {

    }

    public function send($templateName, $templateContent, $message)
    {

    }
}
