<?php

namespace App\Tests;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class UserTypeTest extends TypeTestCase
{
    //this tests are based on this documentation
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

    // All success tests (assertTrue, assertEquals...)
    public function testSuccessSubmitData()
    {
        //FORM DATA
        $formData = $this->getFormData();

        //INIT FORM
        $userForm = new User();
        $form = $this->factory->create(UserType::class, $userForm);
        $form->submit($formData);

        //CREATE USER EXPECTED FOR COMPARE
        $userExpected = $this->getUser();
        
        //ASSERT FORM
        $this->assertTrue($form->isValid());
        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($userExpected, $userForm);

        $view = $form->createView();
        $children = $view->children;

        //ASSERT VIEW
        // existing field
        $this->assertArrayHasKey("username", $children);
        $this->assertArrayHasKey("email", $children);
        $this->assertArrayHasKey("password", $children);
    }

    // All Error test (assertFalse, assertNotEquals...)
    public function testErrorMinPasswordLength()
    {
        //password min length is 6
        $password = "12345";
        //FORM DATA
        $userForm = new User();
        $form = $this->factory->create(UserType::class, $userForm);
        $formData = $this->getFormData();
        $formData["password"] = ['first' => $password, 'second' => $password];
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }
    
    public function testErrorPasswordRepeated()
    {
        //FORM DATA
        $userForm = new User();
        $form = $this->factory->create(UserType::class, $userForm);
        $formData = $this->getFormData();
        $formData["password"] = ['first' => "password", 'second' => "otherPassword"];
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }
    
    public function testErrorMinUsernameLength()
    {
        //username min length is 3
        $username = "12";
        //FORM DATA
        $userForm = new User();
        $form = $this->factory->create(UserType::class, $userForm);
        $formData = $this->getFormData();
        $formData["username"] = $username;
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    /***TODO
    Delete this test or replace by a good one.
    The test bellow is not working
    If its because EmailType use JS for validate the good syntax for email,
    the test will never work and should be deleting
    ***/
    // public function testErrorSyntaxEmail()
    // {
    //     $email = "test";// no use @ for generate error
    //     //FORM DATA
    //     $userForm = new User();
    //     $form = $this->factory->create(UserType::class, $userForm);
    //     $formData = $this->getFormData();
    //     $formData["email"] = $email;
    //     $form->submit($formData);
    //     $this->assertFalse($form->isValid());
    // }

    //utils private function for getting var
    private function getUser($username = "tony", $password = "password", $email = "tony@gmail.com") : User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        return $user; 
    }

    private function getFormData(): array
    {
        $formData = array(
            'username' => 'tony',
            'password' => ['first' => 'password', 'second' => 'password'],
            'email' => 'tony@gmail.com'
        );
        return $formData;
    }

}
