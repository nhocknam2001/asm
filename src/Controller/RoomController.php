<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class RoomController extends AbstractController
{
    /**
     * @Route("/room", name="room_index")
     */
    public function magazineIndex() {
        $rooms = $this->getDoctrine()->getRepository(Room::class)->findAll();
        if ($rooms == null) {
            $this->addFlash('Error','room list is empty');
        }
        return $this->render(
            'room/index.html.twig',
            [
              'rooms' => $rooms
            ]
        );
    }

    /**
     * 
     * @Route("/room/detail/{id}", name="room_detail")
     * 
     */
    public function roomDetail($id) {
        $room = $this->getDoctrine()->getRepository(Room::class)->find($id);
        if ($room == null) {
            $this->addFlash('Error','room not found');
            return $this->redirectToRoute('room_index');
        } else {
            return $this->render(
                'room/detail.html.twig',
                [
                    'room' => $room
                ]
            );
        }
    }

    /**
     * @IsGranted("ROLE_ADMIN");
     * @Route("room/delete/{id}", name="room_delete")
     * 
     */
    public function deleteroom($id) {
        $room = $this->getDoctrine()->getRepository(Room::class)->find($id);
        if ($room == null) {
            $this->addFlash('Error','room not found');
        } else {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($room);
            $manager->flush();
            $this->addFlash('Success', 'room has been deleted');
        }
        return $this->redirectToRoute('room_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN");
     * @Route("room/add", name="room_add")
     * 
     */
    public function addroom (Request $request) {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($room);
            $manager->flush();

            $this->addFlash('Success', "room has been added successfully !");
            return $this->redirectToRoute("room_index");
        }

        return $this->render (
            "room/add.html.twig", 
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @IsGranted("ROLE_ADMIN");
     * @Route("room/edit/{id}", name="room_edit")
     * 
     */
    public function editroom(Request $request, $id) {
        $room = $this->getDoctrine()->getRepository(Room::class)->find($id);
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($room);
            $manager->flush();

            $this->addFlash('Success', "room has been updated successfully !");
            return $this->redirectToRoute("room_index");
        }

        return $this->render (
            "room/edit.html.twig", 
            [
                'form' => $form->createView()
            ]
        );
    }
}
