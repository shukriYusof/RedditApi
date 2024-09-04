<?php

namespace Reddit\Service;

use GuzzleHttp\Client;
use Reddit\Model\Post;
use Reddit\Interface\RedditServiceInterface;

class RedditService implements RedditServiceInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(string $subreddit, string $searchTerm): array
    {
        $subreddit = str_replace(' ', '', $subreddit);
        
        $url = "https://www.reddit.com/r/{$subreddit}/search.json?q=" . urlencode($searchTerm) . "&limit=100&restrict_sr=on";
        $response = $this->client->request('GET', $url);

        $data = json_decode($response->getBody()->getContents(), true);

        $posts = [];
        if (isset($data['data']['children'])) {
            foreach ($data['data']['children'] as $child) {
                $posts[] = new Post($child['data']);
            }
        }

        return $posts;
    }
}
