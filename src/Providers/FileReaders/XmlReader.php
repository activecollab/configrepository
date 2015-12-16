<?php

namespace ActiveCollab\Configuration\Providers\FileReaders;

class XmlReader implements ReaderInterface
{
    /**
     * {@inheritdoc}
     */
    public function read($file)
    {
        $data = [];
        if (file_exists($file)) {
            $xml = simplexml_load_file($file);
            $this->process($xml, $data);
        } else {
            throw new \Exception(sprintf(
                'Failed to open %s',
                $file
            ));
        }

        return $data;
    }

    /**
     * Convert XML to array.
     *
     * @param \SimpleXMLElement $xml
     * @param array $data
     */
    protected function process($xml, array &$data)
    {
        foreach ($xml->children() as $child) {
            $name = $child->getName();
            if (!$child->children()) {
                $data[$name] = trim($child[0]);
            } else {
                $data[$name] = [];
                $this->process($child, $data[$name]);
            }
        }
    }
}
