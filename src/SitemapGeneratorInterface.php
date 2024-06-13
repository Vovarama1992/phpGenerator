<?php

namespace SitemapGenerator;

interface SitemapGeneratorInterface
{
    public function generate(array $pages, string $filePath): void;
}