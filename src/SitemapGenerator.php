<?php

namespace SitemapGenerator;

class SitemapGenerator
{
    private $generator;

    public function __construct(string $type)
    {
        switch ($type) {
            case 'xml':
                $this->generator = new XmlSitemapGenerator();
                break;
            case 'csv':
                $this->generator = new CsvSitemapGenerator();
                break;
            case 'json':
                $this->generator = new JsonSitemapGenerator();
                break;
            default:
                throw new \InvalidArgumentException("Unsupported file type: $type");
        }
    }

    public function generate(array $pages, string $filePath): void
    {
        $this->generator->generate($pages, $filePath);
    }
}