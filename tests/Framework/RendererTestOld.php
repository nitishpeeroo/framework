<?php
    namespace Tests\Framework;

    use Framework\PHPRenderer;
    use Framework\Renderer\TwigRenderer;
    use PHPUnit\Framework\TestCase;

    class RendererTestOld extends TestCase {

        /**
         * @var PHPRenderer
         */
        private $renderer;

        public function setUp()
        {
            $this->renderer = new TwigRenderer();
            $this->renderer->addPath( __DIR__.'/views');
        }

        public function testRenderTheRightPath(){
            $this->renderer->addPath('blog', __DIR__.'/views');
            $content = $this->renderer->render('@blog/demo');
            $this->assertEquals('Salut les gens', $content);
        }

        public function testRendererTheDefaultPath(){
            $content = $this->renderer->render('demo');
            $this->assertEquals('Salut les gens', $content);
        }

        public function testRenderWithParams(){
            $content = $this->renderer->render('demoparams', ['nom' => 'Nitish']);
            $this->assertEquals('salut Nitish', $content);
        }

        public function testGlobalParameters(){
            $this->renderer->addGlobal('nom', 'Nitish');
            $content = $this->renderer->render('demoparams');
            $this->assertEquals('salut Nitish', $content);
        }


    }