<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class StudentController extends AbstractController
{
    #[Route('/student', name: 'student_index')]
    public function studentIndex()
    {
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();

        return $this->render(
            'student/index.html.twig',
            [
                'students' => $students
            ]
        );
    }
    

    #[Route('/student/detail/{id}', name: 'student_detail')]
    public function studentDetail($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('Error', 'Student not found !');
            return $this->redirectToRoute('student_index');
        } else { //$author != null
            return $this->render(
                'student/detail.html.twig',
                [
                    'student' => $student
                ]
            );
        }
    }

    /**
     * @IsGranted("ROLE_ADMIN");
     * @Route("student/delete/{id}", name="student_delete")
     * 
     */
    public function deleteStudent($id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('Error', 'Student not found !');
        } else { 
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($student);
            $manager->flush();
            $this->addFlash('Success', 'Student has been deleted !');
        }
        return $this->redirectToRoute('student_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN");
     * @Route("student/add", name="student_add")
     * 
     */
    public function addStudent(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $student->getAvatar();
            $imgName = uniqid(); 
            $imgExtension = $image->guessExtension();
            $imageName = $imgName . "." . $imgExtension;
            try {
                $image->move(
                    $this->getParameter('student_avatar'),
                    $imageName
                );
            } catch (FileException $e) {
                //throwException($e);
            }
            $student->setAvatar($imageName);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();

            $this->addFlash('Success', "Add student successfully !");
            return $this->redirectToRoute("student_index");
        }

        return $this->render(
            "student/add.html.twig",
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @IsGranted("ROLE_ADMIN");
     * @Route("student/edit/{id}", name="student_edit")
     * 
     */
    public function editStudent(Request $request, $id)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        if ($student == null) {
            $this->addFlash('Error', 'Student not found !');
            return $this->redirectToRoute('student_index');
        } else { 
            $form = $this->createForm(StudentType::class, $student);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form['avatar']->getData();
                if ($file != null) {
                    $image = $student->getAvatar();
                    $imgName = uniqid();
                    $imgExtension = $image->guessExtension();
                    $imageName = $imgName . "." . $imgExtension;
                    try {
                        $image->move(
                            $this->getParameter('student_avatar'),
                            $imageName
                        );
                    } catch (FileException $e) {
                        //throwException($e);
                    }
                    $student->setAvatar($imageName);
                }

                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($student);
                    $manager->flush();

                    $this->addFlash('Success', "Update student successfully !");
                    return $this->redirectToRoute("student_index");
            }

            return $this->render(
                "student/edit.html.twig",
                [
                    'form' => $form->createView()
                ]
            );
        }
    }
}
