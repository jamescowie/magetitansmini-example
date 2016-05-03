<?php namespace MageTitans\BetterEmailer\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class EmailCommand extends Command
{
    protected function configure()
    {
        $this->setName('magetitans:betteremail');
        $this->setDescription('Send all email out to people about how much stock is remaining');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = new \MageTitans\BetterEmailer\Model\OutOfStockProducts();
        $emailer = new \MageTitans\BetterEmailer\Model\Emailer();

        $emailTemplate = $emailer->setTemplate(['name' => 'james', 'lastname' => 'cowie', ]);
        $emailer->sendEmail('SOMEAPIKEY','products',$emailTemplate, $products->getOutOfStockProducts());

        $output->writeln("Email has been sent");
    }
}
