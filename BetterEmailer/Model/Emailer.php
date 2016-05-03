<?php namespace MageTitans\BetterEmailer\Model;

class Emailer
{
    public function setTemplate(array $templateData)
    {
        $message = array(
            'subject' => $templateData['subject'],
            'from_email' => $templateData['from_email'],
            'html' => $templateData['html'],
            'to' => array(array('email' => $templateData['to_email'], 'name' => $templateData['name'])),
            'merge_vars' => array(array(
                'rcpt' => $templateData['to_email'],
                'vars' =>
                    array(
                        array(
                            'name' => $templateData['first_name'],
                            'content' => 'Recipient 1 first name'),
                        array(
                            'name' => $templateData['last_name'],
                            'content' => 'Last name')
                    ))));

        return $message;
    }


    public function sendEmail($ApiKey, $templateName, $templateContent, $message)
    {
        $emailer = new Mandrill($ApiKey);
        $emailer->messages->sendTemplate($templateName, $templateContent, $message);
    }
}
