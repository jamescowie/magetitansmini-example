<?php
namespace MageTitans\ImprovedEmailer\Api;

interface EmailerInterface
{
    public function send($templateName, $templateContent, $message);
    public function setVariables(array $templateData);
}
