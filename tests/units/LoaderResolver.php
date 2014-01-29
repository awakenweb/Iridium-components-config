<?php

namespace Iridium\Components\Config\tests\units;

require_once __DIR__ . '/../../vendor/autoload.php';

use atoum,
    Iridium\Components\Config\LoaderResolver as IrLoaderResolver,
    \Iridium\Components\Config\Loaders\LoaderInterface;

/**
 * Description of DependenciesInjector
 *
 * @author Mathieu
 */
class LoaderResolver extends atoum
{

    public function testCreateThrowsExceptionWhenBadLoaderProvided()
    {
        $this->exception(
                        function() {
                    new IrLoaderResolver(array('string'));
                })
                ->isInstanceOf('\InvalidArgumentException');

        $this->exception(
                        function() {
                    new IrLoaderResolver(array());
                })
                ->isInstanceOf('\InvalidArgumentException');
    }

    public function testResolveSelectsGoodLoader()
    {
        $goodmock = new \mock\Iridium\Components\Config\Loaders\LoaderInterface();
        $badmock  = new \mock\Iridium\Components\Config\Loaders\LoaderInterface();

        $goodmock->getMockController()->load = function($filename) {
            return array('goodLoader');
        };
        $goodmock->getMockController()->canLoad = function($filename) {
            return true;
        };

        $badmock->getMockController()->load = function($filename) {
            return array('badLoader');
        };
        $badmock->getMockController()->canLoad = function($filename) {
            return false;
        };
        $test = new IrLoaderResolver(array($badmock, $goodmock));
        $this->object($test->resolve('/some/test/file'))
                ->isIdenticalTo($goodmock);
    }

    public function testResolveThrowsExceptionWhenNoLoaderCanHandleFile()
    {
        $goodmock = new \mock\Iridium\Components\Config\Loaders\LoaderInterface();
        $badmock  = new \mock\Iridium\Components\Config\Loaders\LoaderInterface();

        $badmock->getMockController()->load = function($filename) {
            return array('badLoader');
        };
        $badmock->getMockController()->canLoad = function($filename) {
            return false;
        };
        $test = new IrLoaderResolver(array($badmock));
        $this->exception(function()use($test) {
                    $test->resolve('/some/test/file');
                })
                ->isInstanceOf('\RuntimeException')
                ->hasMessage('No available loader is able to handle the configuration file /some/test/file');
    }

}
