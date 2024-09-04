<?php

namespace Reddit\Interface;

use Reddit\Model\Post;

interface PostFilterInterface
{
    /**
     * Filters and sorts posts based on the search term.
     *
     * @param Post[] $posts
     * @param string $searchTerm
     * @return Post[]
     */
    public function filterPosts(array $posts, string $searchTerm): array;
}
