<?php

namespace SitemapGenerator;

use SitemapGenerator\Exceptions\FileAccessException;
use SitemapGenerator\Exceptions\InvalidDataException;

class JsonSitemapGenerator implements SitemapGeneratorInterface
{
    public function generate(array $pages, string $filePath): void
    {
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileAccessException("Cannot create directory: $directory");
            }
        }

        foreach ($pages as $page) {
            if (!isset($page['loc'], $page['lastmod'], $page['priority'], $page['changefreq'])) {
                throw new InvalidDataException('Invalid page data: ' . json_encode($page));
            }
        }

        $jsonContent = json_encode($pages, JSON_PRETTY_PRINT);

        if (file_put_contents($filePath, $jsonContent) === false) {
            throw new FileAccessException("Cannot write to file: $filePath");
        }
    }
}