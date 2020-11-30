<?php 

namespace Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\Command;


class UniqueDiegoCommand extends Command
{
    
    public function configure()
    {
        $this->setName("getfileinfo")->setDescription("Provide detailed report from input file unique_diego_tw.csv");  
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->provideReport($input, $output);
    }
}
