<?php

namespace ActiveCollab\ConfigRepository\Providers\FileReaders;

class JsonReader implements ReaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function read($file)
    {
        if (is_file($file)) {
            return json_decode(file_get_contents($file), true);
        } else {
            throw new \Exception(sprintf(
                'File not found at %s',
                $file
            ));
        }
    }
}
