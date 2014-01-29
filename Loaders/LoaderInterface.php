<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Iridium\Components\Config\Loaders;

/**
 *
 * @author Administrateur
 */
interface LoaderInterface
{

    /**
     * @param string $filename
     * @return array
     */
    public function load($filename);

    /**
     * @return boolean
     */
    public function canLoad($filename);
}
