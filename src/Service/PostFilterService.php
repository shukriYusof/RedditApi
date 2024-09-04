<?php

namespace Reddit\Service;

use Reddit\Model\Post;
use Reddit\Interface\PostFilterInterface;

class PostFilterService implements PostFilterInterface
{
    public function filterPosts(array $posts, string $searchTerm): array
    {
        // Filter and sort the posts
        $filtered = array_filter($posts, function (Post $post) use ($searchTerm) {
            return stripos($post->getTitle(), $searchTerm) !== false || stripos($post->getSelfText(), $searchTerm) !== false;
        });

        usort($filtered, function (Post $a, Post $b) {
            return strcmp($a->getTitle(), $b->getTitle());
        });

        return $filtered;
    }
}
