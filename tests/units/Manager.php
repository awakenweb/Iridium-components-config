<?php

namespace Iridium\Components\Config\tests\units;

require_once __DIR__ . '/../../vendor/autoload.php';

use atoum,
    Iridium\Components\Config\Manager as IrManager;

/**
 * Description of DependenciesInjector
 *
 * @author Mathieu
 */
class Manager extends atoum
{

    public function testLoad()
    {

        $loader = new \mock\Iridium\Components\Config\Loader(
                new \mock\Iridium\Components\Config\LoaderResolver(
                array(
            new \mock\Iridium\Components\Config\Loaders\LoaderInterface)
                )
        );

        $loader->getMockController()->load = function($param) {
            return ['hello' => ['system' => ['name' => 'solar', 'planets' => ['first' => 'earth', 'second' => 'mars']]]];
        };

        $manager = new IrManager($loader);

        $this->object($manager->load('filename', 'testnamespace'))
                ->isIdenticalTo($manager);
    }

    public function testGoThroughTree()
    {
        $loader = new \mock\Iridium\Components\Config\Loader(
                new \mock\Iridium\Components\Config\LoaderResolver(
                array(
            new \mock\Iridium\Components\Config\Loaders\LoaderInterface)
                )
        );

        $loader->getMockController()->load = function($param) {
            return ['hello' => ['system' => ['name' => 'solar', 'planets' => ['first' => 'world', 'second' => 'mars']]]];
        };

        $manager = new IrManager($loader);
        $manager->load('filename', 'test');

        $this->string($manager->get('test.hello.system.name'))
                ->isEqualTo('solar')
                ->array($manager->get('test.hello.system.planets'))
                ->isNotEmpty();

        $this->exception(function()use($manager) {
                    $manager->get('test.wrong.path');
                })
                ->isInstanceOf('\RuntimeException');
    }

}
