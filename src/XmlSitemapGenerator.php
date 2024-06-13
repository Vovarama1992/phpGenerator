<?php

namespace SitemapGenerator;

use SitemapGenerator\Exceptions\FileAccessException;
use SitemapGenerator\Exceptions\InvalidDataException;

class XmlSitemapGenerator implements SitemapGeneratorInterface
{
    public function generate(array $pages, string $filePath): void
    {
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileAccessException("Cannot create directory: $directory");
            }
        }

        $xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $urlsetOpen = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;
        $urlsetClose = '</urlset>';

        $urls = '';
        foreach ($pages as $page) {
            if (!isset($page['loc'], $page['lastmod'], $page['priority'], $page['changefreq'])) {
                throw new InvalidDataException('Invalid page data: ' . json_encode($page));
            }

            $urls .= '<url>' . PHP_EOL;
            $urls .= '<loc>' . htmlspecialchars($page['loc'], ENT_XML1, 'UTF-8') . '</loc>' . PHP_EOL;
            $urls .= '<lastmod>' . $page['lastmod'] . '</lastmod>' . PHP_EOL;
            $urls .= '<priority>' . $page['priority'] . '</priority>' . PHP_EOL;
            $urls .= '<changefreq>' . $page['changefreq'] . '</changefreq>' . PHP_EOL;
            $urls .= '</url>' . PHP_EOL;
        }

        $xmlContent = $xmlHeader . $urlsetOpen . $urls . $urlsetClose;

        if (file_put_contents($filePath, $xmlContent) === false) {
            throw new FileAccessException("Cannot write to file: $filePath");
        }
    }
}







