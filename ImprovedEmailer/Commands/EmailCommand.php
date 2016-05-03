<?php namespace MageTitans\ImprovedEmailer\Commands;

use MageTitans\ImprovedEmailer\Model\Products\OutOfStockProducts;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class EmailCommand extends Command
{
    /** @var \MageTitans\ImprovedEmailer\Api\EmailerInterface  */
    protected $emailer;

    /** @var OutOfStockProducts  */
    protected $outOfStockProducts;

    public function __construct(\MageTitans\ImprovedEmailer\Api\EmailerInterface $emailer, OutOfStockProducts $ofStockProducts)
    {
        $this->emailer = $emailer;
        $this->outOfStockProducts = $ofStockProducts;
        parent::__construct('ImprovedEmail');
    }

    protected function configure()
    {
        $this->setName('magetitans:improvedEmail');
        $this->setDescription('Send all email out to people about how much stock is remaining');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $templateVars = $this->emailer->setVariables(['name', 'james']);
        $this->emailer->send('Products', $templateVars, $this->outOfStockProducts->getOutOfStockProducts());
    }
}
