<?php

namespace ActiveCollab\Configuration\Providers\FileReaders;

interface ReaderInterface
{
    /**
     * Method should read file to array.
     *
     * @param $file
     *
     * @return array
     * @throws \Exception
     */
    public function read($file);
}
