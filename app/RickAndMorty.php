<?php
declare(strict_types=1);

namespace App;
class RickAndMorty
{
    private string $description;
    private string $title;
    private array $episodes;

    public function __construct()
    {
        $this->title = "Rick and Morty";
        $this->episodes = $this->setEpisodes();
        $this->description = "Rick and Morty episode list";
    }

    public function setEpisodes(): array
    {
        $episodes = [];
        $api = json_decode(file_get_contents($_ENV["API"]));
        foreach ($api->results as $episode) {
            $episodes[] = $episode->name;
        }
        return $episodes;
    }

    public function getEpisodes(): array
    {
        return $this->episodes;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
