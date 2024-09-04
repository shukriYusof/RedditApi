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
}
