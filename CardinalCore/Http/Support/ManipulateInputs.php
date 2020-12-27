<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Http\Support;

use CardinalCore\Http\Resource\UploadedFile;

trait ManipulateInputs
{
    /**
     * Convert array in Cardinal UploadedFIle
     *
     * @param array $files
     * @return UploadedFile[]
     */
    protected function convertUploadedFiles(array $files)
    {
        return array_map(function ($file) {
            if (is_null($file) || (is_array($file) && empty(array_filter($file)))) {
                return $file;
            }

            return is_array($file)
                ? $this->convertUploadedFiles($file)
                : UploadedFile::createFromBase($file);
        }, $files);
    }

    /**
     * Return all file
     *
     * @return UploadedFile[]
     */
    public function allFiles() {
        return $this->reqeustFiles = $this->reqeustFiles ?? $this->convertUploadedFiles($this->files->all());
    }

    public function file(string $key) {
        //TODO: Implements file method
    }
}
