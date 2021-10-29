<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'category_index')]
    public function categoryIndex()
    {
        $categorys = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render(
            'category/index.html.twig',
            [
                'categorys' => $categorys
            ]
        );
    }

    #[Route('/category/detail/{id}', name: 'category_detail')]
    public function categoryDetail($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if ($category == null) {
            $this->addFlash('Error', 'category not found !');
            return $this->redirectToRoute('category_index');
        } else { 
            return $this->render(
                'category/detail.html.twig',
                [
                    'category' => $category
                ]
            );
        }
    }

    /**
     * @Route("category/delete/{id}", name="category_delete")
     */
    public function deletecategory($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if ($category == null) {
            $this->addFlash('Error', 'category not found !');
        } else { 
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($category);
            $manager->flush();
            $this->addFlash('Success', 'category has been deleted !');
        }
        return $this->redirectToRoute('category_index');
    }

    /**
     * @Route("category/add", name="category_add")
     */
    public function addcategory(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $category->getImage();
            $imgName = uniqid(); 
            $imgExtension = $image->guessExtension();
            $imageName = $imgName . "." . $imgExtension;
            try {
                $image->move(
                    $this->getParameter('category_image'),
                    $imageName
                );
            } catch (FileException $e) {
                //throwException($e);
            }
            $category->setImage($imageName);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('Success', "Add category successfully !");
            return $this->redirectToRoute("category_index");
        }

        return $this->render(
            "category/add.html.twig",
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("category/edit/{id}", name="category_edit")
     */
    public function editcategory(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if ($category == null) {
            $this->addFlash('Error', 'category not found !');
            return $this->redirectToRoute('category_index');
        } else { 
            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form['avatar']->getData();
                if ($file != null) {
                    $image = $category->getImage();
                    $imgName = uniqid();
                    $imgExtension = $image->guessExtension();
                    $imageName = $imgName . "." . $imgExtension;
                    try {
                        $image->move(
                            $this->getParameter('category_image'),
                            $imageName
                        );
                    } catch (FileException $e) {
                        //throwException($e);
                    }
                    $category->setImage($imageName);
                }

                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($category);
                    $manager->flush();

                    $this->addFlash('Success', "Update category successfully !");
                    return $this->redirectToRoute("category_index");
            }

            return $this->render(
                "category/edit.html.twig",
                [
                    'form' => $form->createView()
                ]
            );
        }
    }
}