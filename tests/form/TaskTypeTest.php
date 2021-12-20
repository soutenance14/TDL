<?php

namespace App\Tests;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class TaskTypeTest extends TypeTestCase
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
        $taskForm = new Task();
        $form = $this->factory->create(TaskType::class, $taskForm);
        $form->submit($formData);

        //CREATE USER EXPECTED FOR COMPARE
        $taskExpected = $this->getTask();
        
        // $taskExpected->setCreatedAt($taskForm->getCreatedAt());
        //ASSERT FORM
        $this->assertTrue($form->isValid());
        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($taskExpected->getTitle(), $taskForm->getTitle());
        $this->assertEquals($taskExpected->getContent(), $taskForm->getContent());

        $view = $form->createView();
        $children = $view->children;

        //ASSERT VIEW
        // existing field
        $this->assertArrayHasKey("title", $children);
        $this->assertArrayHasKey("content", $children);
    }

    // // All Error test (assertFalse, assertNotEquals...)
    public function testErrorMinTitleLength()
    {
        //title min length is 3
        $title = "12";
        //FORM DATA
        $taskForm = new Task();
        $form = $this->factory->create(TaskType::class, $taskForm);
        $formData = $this->getFormData();
        $formData["title"] = $title;
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    public function testErrorMinCOntentLength()
    {
        //content min length is 5
        $content = "1234";
        //FORM DATA
        $taskForm = new Task();
        $form = $this->factory->create(TaskType::class, $taskForm);
        $formData = $this->getFormData();
        $formData["content"] = $content;
        $form->submit($formData);
        $this->assertFalse($form->isValid());
    }

    // //utils private function for getting var
    private function getTask($title = "Ma nouvelle tâche",  $content= "Apprendre React JS") : Task
    {
        $task = new Task();
        $task->setTitle($title);
        $task->setContent($content);
        return $task; 
    }

    private function getFormData(): array
    {
        $formData = array(
            'title' => 'Ma nouvelle tâche',
            'content' => 'Apprendre React JS',
        );
        return $formData;
    }

}
