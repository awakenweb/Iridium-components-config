<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Iridium\Components\Config\Loaders;

/**
 * Description of Yaml
 *
 * @author Administrateur
 */
class Json implements LoaderInterface
{

    /**
     * Check if this loader is able to handle the file loading
     * 
     * @param string $filename
     * 
     * @return boolean
     */
    public function canLoad( $filename )
    {
        $file = new \SplFileInfo( $filename );

        if ( 'json' === $file->getExtension() ) {
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
    public function load( $filename )
    {
        $file = new \SplFileInfo( $filename );
        if ( ! $file->isReadable() ) {
            throw new \RuntimeException(
            "Unable to read configuration file '$filename'" );
        }


        $content = json_decode( file_get_contents( $file->getRealPath() ) , true );
        if ( JSON_ERROR_NONE !== json_last_error() ) {
            throw new \RuntimeException(
            "Error while parsing '$filename' configuration file" , json_last_error() );
        }
        return $content;
    }

}
