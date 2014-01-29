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

class LoaderResolver
{

    /**
     *
     * @var array
     */
    protected $loaders;

    /**
     * Add an authorized loader to the loaders list.
     * When trying to load a config file, the file will be matched against
     * every loader to determine which one is the better to handle the file
     * loading
     * 
     * @param array $loaders
     */
    public function __construct(array $loaders)
    {
        if (empty($loaders)) {
            throw new \InvalidArgumentException('Some configuration loaders are invalid');
        }
        $result = array_filter($loaders, function($load) {
            return ($load instanceof Loaders\LoaderInterface) ? true : false;
        });
        if (empty($result)) {
            throw new \InvalidArgumentException('Some configuration loaders are invalid');
        }

        $this->loaders = $loaders;
    }

    /**
     * Analyze the file to determine the best loader to use
     * 
     * @param string $filename
     * @return Loaders\LoaderInterface
     * 
     * @throws \RuntimeException
     */
    public function resolve($filename)
    {
        foreach ($this->loaders as $loader) {
            if ($loader->canLoad($filename)) {
                return $loader;
            }
        }
        throw new \RuntimeException("No available loader is able to handle the configuration file $filename");
    }

}
