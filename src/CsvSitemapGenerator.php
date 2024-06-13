<?php

namespace SitemapGenerator;

use SitemapGenerator\Exceptions\FileAccessException;
use SitemapGenerator\Exceptions\InvalidDataException;

class CsvSitemapGenerator implements SitemapGeneratorInterface
{
    public function generate(array $pages, string $filePath): void
    {
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileAccessException("Cannot create directory: $directory");
            }
        }

        $handle = fopen($filePath, 'w');

        if ($handle === false) {
            throw new FileAccessException("Cannot write to file: $filePath");
        }

        fputcsv($handle, ['loc', 'lastmod', 'priority', 'changefreq'], ';');

        foreach ($pages as $page) {
            if (!isset($page['loc'], $page['lastmod'], $page['priority'], $page['changefreq'])) {
                throw new InvalidDataException('Invalid page data: ' . json_encode($page));
            }

            fputcsv($handle, [$page['loc'], $page['lastmod'], $page['priority'], $page['changefreq']], ';');
        }

        fclose($handle);
    }
}