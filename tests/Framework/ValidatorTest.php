<?php


namespace Tests\Framework;


use Framework\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private function makeValidator(array $params){
        return new Validator($params);
    }
    public function testRequired(){
        $errors = $this->makeValidator([
            'name' => 'nit',
        ])
            ->required('name','content')
            ->getErrors();
        $this->assertCount(1,$errors);
    }

    public function testRequiredIfSuccess(){
        $errors = $this->makeValidator([
            'name' => 'nit',
            'content' => 'kikou les amis'
        ])
            ->required('name','content')
            ->getErrors();
        $this->assertCount(0,$errors);
    }

    public function testSlugSuccess(){
        $errors = $this->makeValidator([
            'slug' => 'kikou-les-amis69',
        ])->slug('slug')
            ->getErrors();
        $this->assertCount(0,$errors);
    }

    public function testSlugError(){
        $errors = $this->makeValidator([
            'slug1' => 'kikou-les-Amis69',
            'slug2' => 'kikou-les_amis69',
            'slug3' => 'kikou--les-amis',
        ])->slug('slug1')
            ->slug('slug2')
            ->slug('slug3')
            ->getErrors();
        $this->assertCount(3,$errors);
    }

    public function testNotEmpty(){
        $errors = $this->makeValidator([
            'name' => 'nit',
            'content' => ''
        ])
            ->notEmpty('content')
            ->getErrors();
        $this->assertCount(1,$errors);
    }

    public function testLength(){
        $params = [
            'slug' => '123456789',
        ];
        $this->assertCount(0,$this->makeValidator($params)->length('slug',3)->getErrors());
        $this->assertCount(1,$this->makeValidator($params)->length('slug',12)->getErrors());
        $this->assertCount(1,$this->makeValidator($params)->length('slug',3,4)->getErrors());
        $this->assertCount(0,$this->makeValidator($params)->length('slug',3,20)->getErrors());
        $this->assertCount(1,$this->makeValidator($params)->length('slug',null, 8)->getErrors());

        $errors = $this->makeValidator($params)->length('slug',12)->getErrors();
        $this->assertCount(1,$errors);
        $this->assertEquals('Le champs slug doit contenir plus de 12 caractères',(string)$errors['slug']);
    }

    public function testDateTime(){
        $this->assertCount(0, $this->makeValidator(['date' => '2012-12-12 11:12:13'])->dateTime('date')->getErrors());
        $this->assertCount(0, $this->makeValidator(['date' => '2012-12-12 00:00:00'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2012-21-12 11:12:13'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2012-13-29 11:12:13'])->dateTime('date')->getErrors());

    }


}