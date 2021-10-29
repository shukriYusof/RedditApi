<?php 
namespace Osky;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

use Osky\Configure;
use Symfony\Component\Console\Output\OutputInterface;

class main extends Configure
{
    
    public function configure()
    {
        $this -> setName('reddit:search')
            -> setDescription('Search through subreddit post.')
            -> setHelp('This command allows you to search through reddit post...');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln([
            '',
            '<fg=red>Reddit Search Version( 0.0.1 )</>',
            '<fg=red>==============================</>',
            '',
        ]);

        $helper = $this->getHelper('question');
        $question1 = new Question('Please enter the name of the subreddit ( default: webdev )  : ', 'webdev');
        $question2 = new Question('Please enter the search term (deafult: php ) : ', 'php');

        $subreddit = $helper->ask($input, $output, $question1);
        $searchInput = $helper->ask($input, $output, $question2);

        return $this->searchPost($output, [
            'subreddit' => strtolower(preg_replace("/[^A-Za-z0-9\-\']/", '', $subreddit)),
            'search_term' => strtolower(preg_replace("/[^A-Za-z0-9\-\']/", '', $searchInput))
        ]);

    }
}