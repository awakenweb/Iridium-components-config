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

class Loader
{

    /**
     *
     * @var array
     */
    protected $loaders = array();

    /**
     *
     * @var Iridium\Components\Config\FileResolver
     */
    protected $resolver;

    /**
     * Add a resolver to the file loader
     * 
     * @param \Iridium\Components\Config\LoaderResolver $resolver
     */
    public function __construct(LoaderResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Actually loads the file to get a php array
     * 
     * @param string $filename
     * 
     * @return array
     * 
     * @throws \RuntimeException @see \Iridium\Components\Config\LoaderResolver
     */
    public function load($filename)
    {
        $loader = $this->resolver->resolve($filename);
        return $loader->load($filename);
    }

}
