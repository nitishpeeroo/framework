<?php
namespace Tests\Framework\Session;

use Framework\Session\ArraySession;
use Framework\Session\FlashService;
use PHPUnit\Framework\TestCase;

class FlashServiceTest extends TestCase{

    /**
     * @var ArraySession
     */
    private $session;
    /**
     * @var FlashService
     */
    private $flashService;

    public function setUp()
    {
        $this->session = $session = new ArraySession();

        $this->flashService = new FlashService($this->session);
    }

    public function testDeleteFlashAfterAppendMessage(){
        $this->flashService->success('ok');
        $this->assertEquals('ok',$this->flashService->get('success'));
        $this->assertNull($this->session->get('flash'));
        $this->assertEquals('ok',$this->flashService->get('success'));
        $this->assertEquals('ok',$this->flashService->get('success'));
    }
}