<?php

namespace App\Tests;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class UserTypeTest extends TypeTestCase
{
    //this tests are based on this tutorial
    //https://symfony.com/doc/current/form/unit_testing.html
    protected function getExtensions()
    {
        $validator = Validation::createValidator();

        // or if you also need to read constraints from annotations
        // $validator = Validation::createValidatorBuilder()
        //     ->enableAnnotationMapping(true)
        //     ->addDefaultDoctrineAnnotationReader()
        //     ->getValidator();

        return [
            new ValidatorExtension($validator),
        ];
    }

    public function testSubmitValidData()
    {
        //FORM DATA
        $formData = array(
            'username' => 'tony',
            'password' => ['first' => 'password', 'second' => 'password'],
            'email' => 'tony@gmail.com',
            // 'roles' => ['ROLE_USER']
        );

        //INIT FORM
        $userForm = new User();
        $form = $this->factory->create(UserType::class, $userForm);
        $form->submit($formData);

        //CREATE USER EXPECTED FOR COMPARE
        $userExpected = new User();
        $userExpected->setUsername('tony');
        $userExpected->setPassword('password');
        $userExpected->setEmail('tony@gmail.com');

        //ASSERT FORM
        
        $this->assertTrue($form->isValid());
        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($userExpected, $userForm);

        $view = $form->createView();
        $children = $view->children;

        //ASSERT VIEW
        $this->assertArrayHasKey("username", $children);
        $this->assertArrayHasKey("email", $children);
        $this->assertArrayHasKey("password", $children);

    }

}
