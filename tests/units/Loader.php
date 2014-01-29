<?php

namespace Iridium\Components\Config\tests\units;

require_once __DIR__ . '/../../vendor/autoload.php';

use atoum,
    Iridium\Components\Config\Loader as IrLoader;

/**
 * Description of DependenciesInjector
 *
 * @author Mathieu
 */
class Loader extends atoum
{

    public function testLoad()
    {
        $load     = new \mock\Iridium\Components\Config\Loaders\LoaderInterface;

        $load->getMockController()->load = function ($param) {
            return array();
        };
        $load->getMockController()->canLoad = function ($param) {
            return true;
        };
        
        $resolver = new \mock\Iridium\Components\Config\LoaderResolver(array($load));
        
        
        $test = new IrLoader($resolver);
        $this->array($test->load('test.ext'));
    }

}
