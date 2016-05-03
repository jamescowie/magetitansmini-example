<?php namespace MageTitans\Emailer\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class EmailCommand extends Command
{
    protected function configure()
    {
        $this->setName('magetitans:email');
        $this->setDescription('Send all email out to people about how much stock is remaining');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $emailer = new Mandrill('SOMEAPIKEY');

        $message = array(
            'subject' => 'Out of stock email',
            'from_email' => 'you@yourdomain.com',
            'html' => '<p>You are being notified about product stock information!.</p>',
            'to' => array(array('email' => 'recipient1@domain.com', 'name' => 'Recipient 1')),
            'merge_vars' => array(array(
                'rcpt' => 'recipient1@domain.com',
                'vars' =>
                    array(
                        array(
                            'name' => 'FIRSTNAME',
                            'content' => 'Recipient 1 first name'),
                        array(
                            'name' => 'LASTNAME',
                            'content' => 'Last name')
                    ))));

        $template_name = 'Products';

        // load all products
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $productCollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');

        $collection = $productCollection->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('stock_status', 0)
            ->load();

        $productHtml = '';

        foreach ($collection as $product) {
            $productHtml .= '<p>' . $product->getName() . '</p>';
        }

        $template_content = array(
            array(
                'name' => 'main',
                'content' => 'Hi *|FIRSTNAME|* *|LASTNAME|*, thanks for signing up.'),
            array(
                'name' => 'footer',
                'content' => 'Copyright 2016.')

        );

        $emailer->messages->sendTemplate($template_name, $template_content, $message);

        $output->writeln("Email is sent for out of stock products");
    }
}
