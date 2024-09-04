<?php

namespace Reddit\Interface;

interface RedditServiceInterface
{
    /**
     * Fetches the latest 100 posts from a given subreddit.
     *
     * @param string $subreddit
     * @param string $searchTerm
     * @return array
     */
    public function search(string $subreddit, string $searchTerm): array;
}
