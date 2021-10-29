<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
  /**
     * @Route("/course", name="course_index")
     */
    public function magazineIndex() {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll();
        if ($courses == null) {
            $this->addFlash('Error','Course list is empty');
        }
        return $this->render(
            'course/index.html.twig',
            [
              'courses' => $courses
            ]
        );
    }

    /**
     * @Route("/course/detail/{id}", name="course_detail")
     */
    public function courseDetail($id) {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        if ($course == null) {
            $this->addFlash('Error','course not found');
            return $this->redirectToRoute('course_index');
        } else {
            return $this->render(
                'course/detail.html.twig',
                [
                    'course' => $course
                ]
            );
        }
    }

    /**
     * @Route("course/delete/{id}", name="course_delete")
     */
    public function deletecourse($id) {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        if ($course == null) {
            $this->addFlash('Error','course not found');
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($course);
            $manager->flush();
            $this->addFlash('Success', 'course has been deleted');
        }
        return $this->redirectToRoute('course_index');
    }

    /**
     * @Route("course/add", name="course_add")
     */
    public function addcourse (Request $request) {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($course);
            $manager->flush();

            $this->addFlash('Success', "course has been added successfully !");
            return $this->redirectToRoute("course_index");
        }

        return $this->render (
            "course/add.html.twig", 
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("course/edit/{id}", name="course_edit")
     */
    public function editcourse(Request $request, $id) {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($course);
            $manager->flush();

            $this->addFlash('Success', "course has been updated successfully !");
            return $this->redirectToRoute("course_index");
        }

        return $this->render (
            "course/edit.html.twig", 
            [
                'form' => $form->createView()
            ]
        );
    }
}
