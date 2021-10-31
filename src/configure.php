<?php
namespace Osky;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class Configure extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function searchPost(OutputInterface $output, $data)
    {
        $output->writeln([
            '',
            'searching ' . $data['search_term'] . ' in https://www.reddit.com/r/' . $data['subreddit'] .  '/search.json?q=title:' . $data['search_term'] . '&restrict_sr=on',
        ]);
        $jsonResult = @file_get_contents('https://www.reddit.com/r/' . $data['subreddit'] .  '/search.json?q=title:' . $data['search_term'] . '&restrict_sr=on');

        if (!$jsonResult) {

            $error = error_get_last();
            $output->writeln([
                '',
                '',
                '<error> HTTP request failed. Error was: ' . $error['message'] . '</error>'
            ]);

            return Command::FAILURE;
        } else {

            $output -> writeln([
                '',
                '====**** Search Result For Reddit Console App ****====',
                '======================================================',
                '',
            ]);

            $result     = json_decode($jsonResult, true);
            $tableRow   = [];
            $table      = new Table($output);
            $delimiter  = 20;
            $keyword    = $data['search_term'];
            // $pattern    = "/(\w+\s){0,".$delimiter."}(".strtolower($keyword)."|".strtoupper($keyword).")(\s\w+){0,".$delimiter."}/";

            date_default_timezone_set('Asia/Kuala_Lumpur');

            foreach (array_slice($result['data']['children'], 0, 100) as $post) {
               
                if(str_contains($post['data']['selftext'], $data['search_term'])){

                    // preg_match($pattern, $post['data']['selftext'], $match); //this could be use if the usecase doesnt chage.

                    $tableRow[] = [
                        date("Y-m-d H:i:s ",$post['data']['created']),
                        substr($post['data']['title'], 0, 30),
                        $post['data']['url'],
                        $this->excerpt($post['data']['selftext'], $keyword, $delimiter, $output, false)
                    ];
                }

            }
            
            $table
                ->setStyle('box-double')
                ->setHeaders(['Date', 'Title', 'URL', 'Exerpt'])
                ->setRows($tableRow);
            $table->setColumnMaxWidth(0, 20);
            $table->setColumnMaxWidth(1, 30);
            $table->render();

            return Command::SUCCESS;
        }
    }

    function excerpt($string, $keyword, $delimiter, $output, $caps){
        
        $words = explode($keyword, $string);
        $str1  = substr($words[0], strlen($words[0]) - $delimiter, $delimiter);
        $str2  = substr($words[1], 0, $delimiter);
        // return $output->writeln('... '.$str1.'<fg=#c0392b;options=underscore>'. $keyword . '</>'.$str2.' ...');

        return '... '.$str1.'<fg=#c0392b;options=underscore>'. $keyword . '</>'.$str2.' ...';
    }
}