<?php

namespace Reddit\Interface;

use Symfony\Component\Console\Output\OutputInterface;
use Reddit\Model\Post;

interface TableFormatterInterface
{
    /**
     * Formats and displays the posts in a table.
     *
     * @param Post[] $posts
     * @param string $searchTerm
     * @param OutputInterface $output
     * @return void
     */
    public function format(array $posts, string $searchTerm, OutputInterface $output): void;
}
