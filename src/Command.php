<?php

namespace Console;

ini_set('memory_limit', '1024M');

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ArrayObject;

class Command extends SymfonyCommand
{
    
    public function __construct()
    {
        parent::__construct();
    }

    protected function provideReport(InputInterface $input, OutputInterface $output)
    {
        $fileContents = file(__DIR__ . "/../data/unique_diego_tw.csv");
        
        // count and confirm how many unique tweets there was, according to the file (you can assume each line is a unique entry)
        $countOfEntries = count($fileContents);

        $fileInfo = $this->getFileInfo($fileContents);

        $output -> writeln([
            "FILE REPORT",
            "",
            "Count of unique tweets: {$countOfEntries}",
            "Count of words : {$fileInfo["countOfWords"]}",
            "File word average : {$fileInfo["fileWordAverage"]}",
            "Longest tweet : {$fileInfo["longestTweet"]}",
            "Shortest tweet : {$fileInfo["shortestTweet"]}",
            "Hastag average : {$fileInfo["hastagAverage"]}",
            "Character lengths average : {$fileInfo["characterLengthsAverage"]}"
        ]);
    }

    /**
     * count how many total words if you had to count ALL the words in the csv
     * report on the average number of words per tweet
     * report on the average number of characters per tweet
     * report on the average number of hashtags used
     * report on what the longest tweet was
     * report on what the shortest tweet was
     */
    private function getFileInfo($fileContents)
    {
        $sum = []; 
        $hashtags = [];
        $characterLengths = [];
        $arrObject = new ArrayObject($fileContents);
        $arrayIterator = $arrObject->getIterator();

        while($arrayIterator->valid())
        {
            $csvLineColumn = explode(",", $arrayIterator->current());

            foreach ($csvLineColumn as $words) {
                $hashtags[] = substr_count($words, "#"); 
                $sum[] = str_word_count($words);
                $characterLengths[] = strlen($words);
            }

            $arrayIterator->next();
        }

        return [
            "countOfWords" => array_sum($sum),
            "fileWordAverage" => array_sum($sum) / count($sum),
            "longestTweet" => max($sum),
            "shortestTweet" => min($sum),
            "hastagAverage" => array_sum($hashtags) / count($hashtags),
            "characterLengthsAverage" => array_sum($characterLengths) / count($characterLengths)
        ];
    }
}
