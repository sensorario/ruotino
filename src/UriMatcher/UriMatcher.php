<?php

namespace App\UriMatcher;

class UriMatcher
{
    private int $position = 0;

    public function __construct(
        private array|string $path,
        private string $currentUrl,
    ) {

    }

    public function match () {
        if (is_string($this->path))
            return $this->matchCount($this->path, $this->currentUrl);

        foreach ($this->path as $pathIndex => $path) {
            if ($this->matchCount($path, $this->currentUrl)) {
                $this->position = $pathIndex;
                return true;
            }
        }

        return false;
    }

    private function matchCount($path, $url)
    {
        $explodedPath = explode('/', $path);
        $explodedUrl = explode('/', $url);

        $return = count($explodedPath) ===  count($explodedUrl);

        if ($return === true) {
            foreach($explodedPath as $pos => $pathItem) {
                if (
                    $explodedPath[$pos] != $explodedUrl[$pos]
                    && strpos($explodedPath[$pos], ":") === false
                ) {
                    return false;
                }
            }
        }

        return $return;
    }

    public function getPath(): string
    {
        return $this->path[$this->position];
    }
}