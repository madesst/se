<?php


namespace SE;


use Model\Student;
use Symfony\Component\Validator\Constraints\NotBlank;

class StudentController extends BaseController
{
    public function createAction()
    {
        $success = false;
        $student = new Student();
        $form = $this->app['form.factory']->createNamedBuilder('student', 'form', $student, array('data_class' => 'Model\Student'))
            ->add('first_name', 'text', [
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => ['placeholder' => 'First Name']
            ])
            ->add('last_name', 'text', [
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => ['placeholder' => 'Last Name']
            ])
            ->add('email', 'email', [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('birthday', 'date', [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('language_level_id', 'text', [
                'mapped' => false
            ])
            ->add('send', 'submit')
            ->getForm();

        if ('POST' == $this->app['request']->getMethod()) {
            $form->bind($this->app['request']);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $student = $form->getData();
                $languageLevel = $this->getEntityManager()->getRepository('Model\LanguageLevel')->find($this->getParam('language_level_id', 1));
                $student->setLanguageLevel($languageLevel);
                $em->persist($student);
                $em->flush();
                $success = true;
            }
        }
        return $this->render('student/create', [
            'form' => $form->createView(),
            'success' => $success
        ]);
    }
}