<?php

namespace Iridium\Components\Config\tests\units\Loaders;

require_once __DIR__ . '/../../../vendor/autoload.php';

use atoum,
    Iridium\Components\Config\Loaders\Yaml as IrYaml;

/**
 * Description of DependenciesInjector
 *
 * @author Mathieu
 */
class Yaml extends atoum
{

    public function testCanLoadYmlFile()
    {
        $test = new IrYaml();
        $this->boolean($test->canLoad(realpath(__DIR__ . '/../../testfiles/test.yml')))
                ->isTrue();
    }

    public function testCanNotLoadJsonFile()
    {
        $test = new IrYaml();
        $this->boolean($test->canLoad(realpath(__DIR__ . '/../../testfiles/test.json')))
                ->isFalse();
    }

    public function testCanNotLoadInexistantFile()
    {
        $test = new IrYaml();
        $this->boolean($test->canLoad(realpath(__DIR__ . '/../../some/inexistant/path/test.yml')))
                ->isFalse();
    }

    public function testCanParseGoodYamlFile()
    {
        $test = new IrYaml();
        $this->array($test->load(realpath(__DIR__ . '/../../testfiles/test.yml')))
                ->hasKey('hello')
                ->array($test->load(realpath(__DIR__ . '/../../testfiles/test.yml'))['hello'])
                ->hasKeys(array('planet', 'people'))
                ->contains('world', 'user');
    }

    public function testCannotParseBadYamlFile()
    {
        $test = new IrYaml();
        $this->exception(
                        function()use($test) {
                    $test->load(realpath(__DIR__ . '/../../testfiles/testBad.yml'));
                })
                ->isInstanceOf('\RuntimeException')
                ->exception(
                        function()use($test) {
                    $test->load(realpath(__DIR__ . '/../../testfilesthatnotexists/testBad.yml'));
                })->isInstanceOf('\RuntimeException')
                ->exception(
                        function()use($test) {
                    $test->load(realpath(__DIR__ . '/../../testfiles/test.json'));
                })
                ->isInstanceOf('\RuntimeException');
    }

}
