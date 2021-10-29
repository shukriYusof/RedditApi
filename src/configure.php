<?php
namespace Osky;

use DateTime;
use DateTimeZone;
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

            $result = json_decode($jsonResult, true);

            $tableRow = [];
    
            date_default_timezone_set('Asia/Kuala_Lumpur');

            foreach (array_slice($result['data']['children'], 0, 100) as $post) {
                
                $tableRow[] = [
                    date("Y-m-d H:i:s ",$post['data']['created']),
                    substr($post['data']['title'], 0, 30),
                    $post['data']['url']
                ];
            }
    
            $table = new Table($output);
            $table
                ->setHeaders(['Date', 'Title', 'URL'])
                ->setRows($tableRow)
            ;
            $table->setColumnMaxWidth(0, 20);
            $table->setColumnMaxWidth(1, 30);
            $table->render();

            return Command::SUCCESS;
        }
    }
}