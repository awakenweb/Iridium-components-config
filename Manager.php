<?php

/*
 * The MIT License
 *
 * Copyright (c) 2014 Mathieu SAVELLI <mathieu.savelli@awakenweb.fr>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Iridium\Components\Config;

class Manager
{

    /**
     *
     * @var Loader;
     */
    protected $loader;

    /**
     *
     * @var array 
     */
    protected $values = array();

    /**
     * Config\Manager is a class used to handle the whole process of loading a 
     * configuration file and accessing the values it contains
     * 
     * @param \Iridium\Components\Config\Loader $loader
     */
    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Load a set of configuration values from a configuration file
     * 
     * @param type $filename
     * @param type $config_namespace
     * 
     * @return \Iridium\Components\Config\Manager
     * 
     * @throws \RuntimeException @see \Iridium\Components\Config\LoaderResolver
     */
    public function load($filename, $config_namespace)
    {
        $vals = $this->loader->load($filename);

        $this->values[$config_namespace] = $vals;
        return $this;
    }

    /**
     * 
     * @param type $path
     */
    public function get($path)
    {
        return $this->ArrayGetPath($path);
    }

    /**
     * Find a value in a recursive associative array. You can access a value by
     * providing its path in the tree. Path are constructed this way:
     * 
     * main.authentication.database.username
     * or
     * webservices/twitter/password
     * 
     * In the first example, it will first find the namespace 'main', then the
     * 'authentication' branch, then go to the 'database' branch and finally will
     * retrieve the 'username' value.
     * 
     * @param string $path recursive path delimited by some caracters.
     * @param string $delimiter the delimiter used to separate branches in the path. '.' dots by default.
     * 
     * @return mixed
     * 
     * @throws \RuntimeException
     */
    protected function ArrayGetPath($pathstring, $delimiter = '.')
    {

        $found = true;
        $data  = $this->values;
        $path  = explode($delimiter, $pathstring);

        for ($x = 0; ($x < count($path) and $found); $x++) {

            $key = $path[$x];

            if (isset($data[$key])) {
                $data = $data[$key];
            } else {
                $found = false;
            }
        }

        if ($found === false) {
            throw new \RuntimeException("Invalid search path for configuration value '$pathstring'");
        }

        return $data;
    }

}
