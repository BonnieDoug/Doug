<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Post controller.
 *
 * @Route("blog")
 */
class PostController extends Controller {

    /**
     * Lists all post entities.
     *
     * @Route("/", name="blog_index")
     * @Method("GET")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

//        $posts = $em->getRepository('AppBundle:Post')->findAll();
//        $posts = $em->getRepository('AppBundle:Post')->paginateFindAll($request, $this->get('knp_paginator'));


        return $this->render('post/index.html.twig', array(
                    'posts' => $em->getRepository('AppBundle:Post')->paginateFindAll($request, $this->get('knp_paginator')),
        ));
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/new", name="blog_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $post = new Post();
        $form = $this->createForm('AppBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog_show', array('id' => $post->getId()));
        }

        return $this->render('post/new.html.twig', array(
                    'post' => $post,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a post entity.
     *
     * @Route("/{id}", name="blog_show")
     * @Method("GET")
     */
    public function showAction(Post $post) {
        $deleteForm = $this->createDeleteForm($post);

        $product = $this->getDoctrine()
                ->getRepository('AppBundle:Post')
                ->withTopLevelComments($post);

        return $this->render('post/show.html.twig', array(
                    'post' => $post,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     * @Route("/{id}/edit", name="blog_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Post $post) {
        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('AppBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_edit', array('id' => $post->getId()));
        }

        return $this->render('post/edit.html.twig', array(
                    'post' => $post,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/{id}", name="blog_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Post $post) {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('blog_index');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('blog_delete', array('id' => $post->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
