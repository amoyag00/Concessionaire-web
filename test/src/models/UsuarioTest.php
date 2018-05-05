<?php
namespace Models;
require '..\src\models\Usuario.php';
/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-05-05 at 18:17:34.
 */
class UsuarioTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Usuario
     */
    protected $usuario;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->usuario = new Usuario;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    public function getDataSet(){
        return $this->createXMLDataSet('UsuariosIniciales.xml');
    }
    

    /**
     * @covers Models\Usuario::checkPassword
     */
    public function testCheckPassword() {
        //checkPassword returns the type of the user if username+password matches
        $result=$this->usuario->checkPassword("admin","admin");
        $this->assertEquals("administrator",$result["tipo"]);
        
        $result=$this->usuario->checkPassword("admin","password");
        $this->assertEquals("",$result["tipo"]);
    }

    /**
     * @covers Models\Usuario::insert
     */
    public function testInsert() {
        $data=array("username"=>"test","password"=>"test","type"=>"provider");
        $this->usuario->setAttributes($data);
        $affectedRows=$this->usuario->insert();
        $this->assertEquals(1,$affectedRows);
    }

    /**
     * @covers Models\Usuario::getType
     */
    public function testGetType() {
        $this->assertEquals("administrator",$this->usuario->getType("admin"));
        $this->assertEquals("provider",$this->usuario->getType("prov"));
        $this->assertEquals("concessionaire",$this->usuario->getType("audi"));
        
    }

}
