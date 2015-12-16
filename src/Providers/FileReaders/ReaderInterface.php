<?php

namespace ActiveCollab\ConfigRepository\Providers\FileReaders;

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
