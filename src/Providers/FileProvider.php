<?php

namespace ActiveCollab\Configuration\Providers;

use ActiveCollab\Configuration\Providers\FileReaders\ReaderInterface;

class FileProvider extends ArrayProvider
{
    /**
     * Supported extensions
     *
     * @var array
     */
    protected $extensions = [
        'php',
        'xml',
        'json',
    ];
    /**
     * @var string
     */
    protected $file_path;
    /**
     * @var string
     */
    protected $file_extension;

    /**
     * FileProvider constructor.
     * @param string $file_path
     * @throws \Exception
     */
    public function __construct($file_path)
    {
        $this->file_path = $file_path;
        $this->validate($file_path);
        $extension = $this->getFileExtension();

        if ($this->file_extension === 'php') {
            $this->data = include $file_path;
        } else {
            $class_name = '\\ActiveCollab\\Configuration\\Providers\\FileReaders\\'.ucfirst($extension).'Reader';
            $reader = new $class_name();

            if (!$reader instanceof ReaderInterface) {
                throw new \Exception(sprintf(
                    'Invalid file provider class. Class name is %s .',
                    $class_name
                ));
            }
            $this->data = $reader->read($file_path);
        }
        parent::__construct($this->data);
    }

    /**
     * Get file extension.
     *
     * @return string
     * @throws \Exception
     */
    public function getFileExtension()
    {
        if (!$this->file_extension && $this->file_path > '') {
            $path_info = pathinfo($this->file_path);
            $extension = strtolower($path_info['extension']);
            if (!isset($path_info['extension'])) {
                throw new \Exception(sprintf(
                    'Filename "%s" has invalid extension',
                    $this->file_path
                ));
            }
            $this->file_extension = $extension;
        }

        return $this->file_extension;
    }

    /**
     * Validate if file path is valid.
     *
     * @param $file_path
     * @throws \Exception
     */
    protected function validate($file_path)
    {
        if (!file_exists($file_path)) {
            throw new \Exception(sprintf(
                'Filename "%s" cannot be found',
                $file_path
            ));
        }
        if (!is_readable($file_path)) {
            throw new \Exception(sprintf(
                "File '%s' is not readable",
                $file_path
            ));
        }
    }
}
