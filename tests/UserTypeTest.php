<?php

namespace App\Tests;

use App\Entity\User;
use App\Form\UserType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class UserTypeTest extends TypeTestCase
{
    private $objectManager;

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
        $formData = array(
            'username' => 'bob',
            'password' => ['first' => 'root', 'second' => 'root'],
            'email' => 'email@email.fr',
            // 'roles' => ['ROLE_USER']
        );

        $userForm = new User();
        // Instead of creating a new instance, the one created in
        // getExtensions() will be used.
        $form = $this->factory->create(UserType::class, $userForm);
        $form->submit($formData);

        $userExpected = new User();
        $userExpected->setUsername('bob');
        $userExpected->setPassword('root');
        $userExpected->setEmail('email@email.fr');

        print("Form user: " . $userForm->getPassword() ."\n");
        print("\n");
        print("expected user: " . $userExpected->getPassword() ."\n");


        $this->assertTrue(true);
        $this->assertEquals($userExpected, $userForm);
    }


    // public function testSomething(): void
    // {
    //     $this->assertTrue(true);
    // }
}
