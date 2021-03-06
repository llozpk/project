<?php

namespace App\Controller;

use App\Entity\TfdFilaAtendimento;
use App\Form\PostFilaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilaController extends AbstractController
{


    /**
     * @Route("filac", name="filac")
     */
    public function createFila()
    {
        $posts = $this->getDoctrine()->getRepository('App:TfdFilaAtendimento')->findAll();

        return $this->render('fila/index.html.twig', [
            'posts' => $posts
        ]);

    }


    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("filad/{id}", name="filad")
     */

    public function deleteActionFila($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('App:TfdFilaAtendimento')->find($id);

        if (!$post) {
            return $this->redirectToRoute('filac');
        }

        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('filac');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("filam/{id}", name="filam")
     */

    public function updateActionFila($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fila = $em->getRepository('App:TfdFilaAtendimento')->find($id);

        if (!$fila) {
            throw $this->createNotFoundException(
                'Fila nao encontrada para o Id '.$id
            );
        }

        $form = $this->createForm(PostFilaType::class,$fila);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fila = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fila);
            $entityManager->flush();

            return $this->redirectToRoute('filac');

        }

        return $this->render('post/postFaixa.html.twig',
            [
                'formFaixa' => $form->createView()
            ]);


        return $this->redirectToRoute('filac');
    }

}
