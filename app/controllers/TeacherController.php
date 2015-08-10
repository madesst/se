<?php

namespace SE;

use Model\Teacher;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class TeacherController extends BaseController
{
    public function listAction()
    {
        $success = $this->getParam('success') === '1' ? true : false;

        return $this->render('teacher/list', [
            'pager' => $this->preparePager($this->getRepository('Model\Teacher')->findAllOrdered()),
            'success' => $this->getParam('success') !== null ? $success : null
        ]);
    }

    public function specialListAction()
    {
        return $this->render('teacher/specialList', [
            'teachers' => $this->getRepository('Model\Teacher')->findSpecial()
        ]);
    }

    public function mostIntersectsAction()
    {
        $intersectsTeachersIds = $this->getRepository('Model\Teacher')->findMostIntersects();
        $teachers = [];
        $students = [];
        if (!empty($intersectsTeachersIds) && !empty($intersectsTeachersIds[0]['left_teacher_id'])) {
            $teachers = $this->getRepository('Model\Teacher')->findById([
                $intersectsTeachersIds[0]['left_teacher_id'],
                $intersectsTeachersIds[0]['right_teacher_id']
            ]);
            $students = $this->getRepository('Model\Student')->findIntersectsByTeachersIds(
                $intersectsTeachersIds[0]['left_teacher_id'],
                $intersectsTeachersIds[0]['right_teacher_id']
            );
        }
        return $this->render('teacher/intersects', [
            'teachers' => $teachers,
            'students' => $students
        ]);
    }

    public function createAction()
    {
        $success = false;
        $teacher = new Teacher();
        $form = $this->app['form.factory']->createNamedBuilder('teacher', 'form', $teacher, array('data_class' => 'Model\Teacher'))
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
            ->add('sex', 'checkbox', ['required' => false, 'label' => 'Male?'])
            ->add('phone', 'text', [
                'constraints' => [
                    new NotBlank(),
                    new Regex(['pattern' => '/\+([0-9]){1}\-([0-9]){3}\-([0-9]){7}$/'])
                ],
                'attr' => ['placeholder' => '+1-111-1111111']
            ])
            ->add('send', 'submit')
            ->getForm();

        if ('POST' == $this->app['request']->getMethod()) {
            $form->bind($this->app['request']);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $teacher = $form->getData();
                $em->persist($teacher);
                $em->flush();
                $success = true;
            }
        }
        return $this->render('teacher/create', [
            'form' => $form->createView(),
            'success' => $success
        ]);
    }

    public function assignAction()
    {
        $success = false;
        $student = $this->getEntityManager()->getRepository('Model\Student')->find($this->getParam('student_id'));
        $teacher = $this->getEntityManager()->getRepository('Model\Teacher')->find($this->getParam('teacher_id'));
        if ($student && $teacher) {
            if (!$student->getTeachers()->contains($teacher)) {
                $student->getTeachers()->add($teacher);
                $em = $this->getEntityManager();
                $em->persist($student);
                $em->flush();

                $success = true;
            }
        }

        return $this->app->redirect('/?success='.$success);
    }
}