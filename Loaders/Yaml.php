<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Iridium\Components\Config\Loaders;

use Symfony\Component\Yaml\Yaml as SfYaml;

/**
 * Description of Yaml
 *
 * @author Administrateur
 */
class Yaml implements LoaderInterface
{

    /**
     * Check if this loader is able to handle the file loading
     * 
     * @param string $filename
     * 
     * @return boolean
     */
    public function canLoad($filename)
    {
        $file = new \SplFileInfo($filename);

        if ('yml' === $file->getExtension()) {
            return true;
        }

        return false;
    }

    /**
     * Parse the file configuration file to retrieve its values as a PHP array
     * 
     * @param string $filename
     * @return array
     * 
     * @throws \RuntimeException
     */
    public function load($filename)
    {
        $file = new \SplFileInfo($filename);
        if (!$file->isReadable()) {
            throw new \RuntimeException(
            "Unable to read configuration file '$filename'");
        }

        try {
            $content = SfYaml::parse($filename);
            return $content;
        } catch (\Exception $e) {
            throw new \RuntimeException(
            "Error while parsing '$filename' configuration file", $e->getCode(), $e);
        }
    }

}
