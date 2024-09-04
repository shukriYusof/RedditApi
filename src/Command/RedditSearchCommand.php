<?php

namespace Reddit\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Reddit\Service\RedditService;
use Reddit\Service\PostFilterService;
use Reddit\Service\TableFormatter;

class RedditSearchCommand extends Command
{
    protected static $defaultName = 'reddit:search';

    private $redditService;
    private $postFilterService;
    private $tableFormatter;

    public function __construct(RedditService $redditService, PostFilterService $postFilterService, TableFormatter $tableFormatter)
    {
        $this->redditService = $redditService;
        $this->postFilterService = $postFilterService;
        $this->tableFormatter = $tableFormatter;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Searches for posts on Reddit.')
            ->addArgument('subreddit', InputArgument::OPTIONAL, 'The subreddit to search in.')
            ->addArgument('searchTerm', InputArgument::OPTIONAL, 'The term to search for.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        // Prompt for subreddit if not provided
        $subreddit = $input->getArgument('subreddit');
        if (!$subreddit) {
            $question = new Question('Please enter the subreddit (default is "webdev"): ', 'webdev');
            $subreddit = $helper->ask($input, $output, $question);
        }

        // Prompt for search term if not provided
        $searchTerm = $input->getArgument('searchTerm');
        if (!$searchTerm) {
            $question = new Question('Please enter the search term (default is "php"): ', 'php');
            $searchTerm = $helper->ask($input, $output, $question);
        }

        // Trim whitespace from inputs
        $subreddit = trim($subreddit);
        $searchTerm = trim($searchTerm);

        $output->writeln("Searching for '{$searchTerm}' in subreddit '{$subreddit}'...");

        // Example processing code (e.g., search Reddit, handle output)
        $posts = $this->redditService->search($subreddit, $searchTerm);
        if (empty($posts)) {
            $output->writeln('<comment>No posts found matching your search.</comment>');
            return Command::SUCCESS;
        }

        $filteredPosts = $this->postFilterService->filterPosts($posts, $searchTerm);
        $this->tableFormatter->format($filteredPosts, $searchTerm, $output);

        return Command::SUCCESS;
    }
}

