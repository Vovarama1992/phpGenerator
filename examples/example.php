<?php

require __DIR__ . '/../vendor/autoload.php';

use SitemapGenerator\SitemapGenerator;

$pages = [
    [
        'loc' => 'https://site.ru/',
        'lastmod' => '2020-12-14',
        'priority' => '1.0',
        'changefreq' => 'hourly'
    ],
    [
        'loc' => 'https://site.ru/news',
        'lastmod' => '2020-12-10',
        'priority' => '0.5',
        'changefreq' => 'daily'
    ],
  
];

$fileType = 'json'; 
$filePath = __DIR__ . '/sitemap.xml';

try {
    $generator = new SitemapGenerator($fileType);
    $generator->generate($pages, $filePath);
    echo "Sitemap generated successfully.";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}