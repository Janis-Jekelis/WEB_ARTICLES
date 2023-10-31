<?php
declare(strict_types=1);

namespace App\Models;

class Article
{
    private string $title;
    private string $description;
    private ?array $content;

    public function __construct(string $title, string $description, ?array $content = null)
    {
        $this->title = $title;
        $this->description = $description;
        if (isset($content)) {
            $this->content = $content;
        } else {
            $this->content = null;
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getContent(): ?array
    {
        return $this->content;
    }

}