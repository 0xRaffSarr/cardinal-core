<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Http\Resource;

use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

class UploadedFile extends SymfonyUploadedFile
{

    public function store(string $path) {
        //TODO: Implement store method
    }

    public function storeWithName(string $path, string $name) {
        //TODO: Implements storeWithName method
    }

    /**
     * Create new UploadedFile
     *
     * @param SymfonyUploadedFile $file
     * @param false $test
     * @return static
     */
    public static function createFromBase(SymfonyUploadedFile $file, $test = false)
    {
        return ($file instanceof static )? $file : new static($file->getPathname(), $file->getClientOriginalName(), $file->getClientMimeType(), $file->getError(), $test);
    }
}
