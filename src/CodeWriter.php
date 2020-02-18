<?php

namespace MilesChou\Schemarkdown;

use Illuminate\Support\Facades\Log;

class CodeWriter
{
    /**
     * @var bool
     */
    private $overwrite;

    /**
     * @param bool $overwrite
     */
    public function __construct($overwrite = true)
    {
        $this->overwrite = $overwrite;
    }

    /**
     * @param iterable $generator Array or callable which should return array like [filePath => code]
     * @param string $pathPrefix
     */
    public function generate(iterable $generator, $pathPrefix): void
    {
        foreach ($generator as $filePath => $code) {
            Log::info("Write file '{$filePath}'");

            $this->writeCode($code, $filePath, $pathPrefix);
        }
    }

    /**
     * @param mixed $code
     * @param string $filePath
     * @param string $pathPrefix
     */
    private function writeCode($code, $filePath, $pathPrefix): void
    {
        $fullPath = $pathPrefix . '/' . $filePath;

        if (!$this->overwrite && is_file($fullPath)) {
            return;
        }

        $dir = dirname($fullPath);

        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        file_put_contents($fullPath, $code);
    }
}
