<?php

namespace Reddit\Service;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Reddit\Interface\TableFormatterInterface;

class TableFormatter implements TableFormatterInterface
{
    public function format(array $posts, string $searchTerm, OutputInterface $output): void
    {
        $table = new Table($output);
        $table->setHeaders(['Date', 'Title', 'URL', 'Excerpt']);

        foreach ($posts as $post) {
            $table->addRow([
                $post->getFormattedDate(),
                $this->truncateTitle($post->getTitle()),
                $post->getUrl(),
                $this->highlightExcerpt($post->getSelfText(), $searchTerm)
            ]);
        }

        $table->render();
    }

    private function truncateTitle(string $title): string
    {
        return (strlen($title) > 30) ? substr($title, 0, 30) . '...' : $title;
    }

    private function highlightExcerpt(string $text, string $term): string
    {
        $position = stripos($text, $term);
        if ($position === false) {
            return '';
        }

        $start = max($position - 20, 0);
        $end = min($position + 20 + strlen($term), strlen($text));
        $excerpt = substr($text, $start, $end - $start);

        if ($start > 0) {
            $excerpt = '...' . $excerpt;
        }
        if ($end < strlen($text)) {
            $excerpt .= '...';
        }

        return str_ireplace($term, "<fg=yellow;options=bold>$term</>", $excerpt);
    }
}
