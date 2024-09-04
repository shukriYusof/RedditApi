<?php

namespace Reddit\Model;

class Post
{
    private $title;
    private $selfText;
    private $url;
    private $date;

    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->selfText = $data['selftext'];
        $this->url = $data['url'];
        $this->date = new \DateTime('@' . $data['created_utc']);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSelfText(): string
    {
        return $this->selfText;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getFormattedDate(): string
    {
        return $this->date->setTimezone(new \DateTimeZone('Asia/Kuala_Lumpur'))->format('Y-m-d H:i:s');
    }

    /**
     * Generates an excerpt of the selfText with a specific length.
     * If a search term is provided, it highlights the search term within the excerpt.
     */
    public function getExcerpt(string $searchTerm, int $contextLength = 20): string
    {
        $lowercaseSelfText = strtolower($this->selfText);
        $lowercaseSearchTerm = strtolower($searchTerm);

        $position = strpos($lowercaseSelfText, $lowercaseSearchTerm);

        if ($position === false) {
            // If the search term is not found, return a truncated version of the selfText
            return strlen($this->selfText) > ($contextLength * 2)
                ? substr($this->selfText, 0, $contextLength * 2) . '...'
                : $this->selfText;
        }

        // Calculate the start and end of the excerpt
        $start = max(0, $position - $contextLength);
        $end = min(strlen($this->selfText), $position + strlen($searchTerm) + $contextLength);

        // Generate the excerpt
        $excerpt = substr($this->selfText, $start, $end - $start);

        // Highlight the search term
        $excerpt = str_ireplace($searchTerm, "\e[1;31m$searchTerm\e[0m", $excerpt);

        // Add ellipses if necessary
        if ($start > 0) {
            $excerpt = '...' . $excerpt;
        }
        if ($end < strlen($this->selfText)) {
            $excerpt .= '...';
        }

        return $excerpt;
    }
}
