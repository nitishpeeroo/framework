<?php
    namespace Tests\Framework\Twig;

    use Framework\Twig\TextExtension;
    use PHPUnit\Framework\TestCase;

    class TextExtensionTest extends  TestCase{

        /**
         * @var TextExtension
         */
        private $textExtension;

        public function setUp()
        {
          $this->textExtension = new TextExtension();
        }

        public function testExcerptWithShortText(){
        $text = "salut";
        $this->assertEquals('salut', $this->textExtension->excerpt($text, 10));
        }


        public function testExcerptWithMediumText(){
            $text = "Salut les amis";
            $this->assertEquals('Salut les...', $this->textExtension->excerpt($text, 12));
        }
    }