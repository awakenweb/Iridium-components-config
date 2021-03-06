<?php

namespace Iridium\Components\Config\tests\units\Loaders;

require_once __DIR__ . '/../../../vendor/autoload.php';

use atoum ,
    Iridium\Components\Config\Loaders\Json as IrJson;

/**
 * Description of DependenciesInjector
 *
 * @author Mathieu
 */
class Json extends atoum
{

    public function testCanLoadJsonFile()
    {
        $test = new IrJson();
        $this->boolean( $test->canLoad( realpath( __DIR__ . '/../../testfiles/test.json' ) ) )
                ->isTrue();
    }

    public function testCanNotLoadYmlFile()
    {
        $test = new IrJson();
        $this->boolean( $test->canLoad( realpath( __DIR__ . '/../../testfiles/test.yml' ) ) )
                ->isFalse();
    }

    public function testCanNotLoadInexistantFile()
    {
        $test = new IrJson();
        $this->boolean( $test->canLoad( realpath( __DIR__ . '/../../some/inexistant/path/test.json' ) ) )
                ->isFalse();
    }

    public function testCanParseGoodJsonFile()
    {
        $test = new IrJson();
        $this->array( $test->load( realpath( __DIR__ . '/../../testfiles/test.json' ) ) )
                ->hasKey( 'hello' )
                ->array( $test->load( realpath( __DIR__ . '/../../testfiles/test.json' ) )[ 'hello' ] )
                ->hasKeys( array( 'planet' , 'people' ) )
                ->contains( 'world' , 'user' );
    }

    public function testCannotParseBadJsonFile()
    {
        $test = new IrJson();
        $this->exception(
                        function()use($test) {
                    $test->load( realpath( __DIR__ . '/../../testfiles/testBad.json' ) ); // test invalid file
                } )
                ->isInstanceOf( '\RuntimeException' )
                ->exception(
                        function()use($test) {
                    $test->load( realpath( __DIR__ . '/../../testfilesthatnotexists/testBad.json' ) ); // test inexistant file
                } )->isInstanceOf( '\RuntimeException' )
                ->exception(
                        function()use($test) {
                    $test->load( realpath( __DIR__ . '/../../testfiles/test.yml' ) ); // test incorrect format file
                } )
                ->isInstanceOf( '\RuntimeException' );
    }

}
