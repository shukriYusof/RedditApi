<?php

namespace Reddit\Interface;

interface RedditServiceInterface
{
    /**
     * Fetches the latest 100 posts from a given subreddit.
     *
     * @param string $subreddit
     * @return array
     */
    public function fetchPosts(string $subreddit): array;
}
