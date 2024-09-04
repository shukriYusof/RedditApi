<?php

namespace Reddit\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Reddit\Interface\RedditServiceInterface;
use Reddit\Interface\PostFilterInterface;
use Reddit\Interface\TableFormatterInterface;

class RedditSearchCommand extends Command
{
    private $redditService;
    private $postFilterService;
    private $tableFormatter;

    public function __construct(RedditServiceInterface $redditService, PostFilterInterface $postFilterService, TableFormatterInterface $tableFormatter)
    {
        parent::__construct();
        $this->redditService = $redditService;
        $this->postFilterService = $postFilterService;
        $this->tableFormatter = $tableFormatter;
    }

    protected function configure()
    {
        $this
            ->setName('reddit:search')
            ->setDescription('Search for new posts on a specified subreddit');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $subreddit = 'webdev'; // Default subreddit
            $searchTerm = 'php'; // Default search term

            // Fetch posts
            $posts = $this->redditService->fetchPosts($subreddit);

            // Filter posts
            $filteredPosts = $this->postFilterService->filterPosts($posts, $searchTerm);

            // Format and output results
            $this->tableFormatter->format($filteredPosts, $searchTerm, $output);

        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

