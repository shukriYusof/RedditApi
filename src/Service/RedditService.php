<?php

namespace Reddit\Service;

use Reddit\Interface\RedditServiceInterface;
use Reddit\Model\Post;
use GuzzleHttp\Client;

class RedditService implements RedditServiceInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchPosts(string $subreddit): array
    {
        $response = $this->client->request('GET', "https://www.reddit.com/r/{$subreddit}/new.json?limit=100");
        $data = json_decode($response->getBody()->getContents(), true);
        
        if (!isset($data['data']['children'])) {
            throw new \RuntimeException('Invalid response from Reddit API.');
        }
        
        return array_map(function($post) {
            return new Post($post['data']);
        }, $data['data']['children']);
    }
}
