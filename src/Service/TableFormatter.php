<?php

namespace Reddit\Service;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Reddit\Interface\TableFormatterInterface;

class TableFormatter implements TableFormatterInterface
{
    public function format(array $posts, string $searchTerm, OutputInterface $output): void
    {
        // Add a custom style for highlighting the search term
        $highlightStyle = new OutputFormatterStyle('yellow', null, ['bold', 'underscore']);
        $output->getFormatter()->setStyle('highlight', $highlightStyle);

        // Create a new table instance
        $table = new Table($output);
        $table->setHeaders(['Date', 'Title', 'URL', 'Excerpt']);

        // Prepare rows for the table
        foreach ($posts as $post) {
            $date = $post->getFormattedDate();
            $title = substr($post->getTitle(), 0, 30);
            $url = $post->getUrl();

            // Highlight the search term in the excerpt
            $excerpt = $this->highlightExcerpt($post->getExcerpt($searchTerm), $searchTerm);

            $table->addRow([$date, $title, $url, $excerpt]);
        }

        // Render the table
        $table->render();
    }

    private function highlightExcerpt(string $excerpt, string $searchTerm): string
    {
        // Highlight the search term in the excerpt
        return str_ireplace($searchTerm, "<highlight>$searchTerm</highlight>", $excerpt);
    }
}
