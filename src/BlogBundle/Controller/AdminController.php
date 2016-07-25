<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Posts;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="administrator")
     */
    public function administratorAction(Request $request)
    {
        $post = $this->get('add_post')->getPost();

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('add', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($post);
          $em->flush();
          
          $id = $post->getId();
          return $this->redirectToRoute('post', array('id' => $id));
        }
        

        return $this->render('BlogBundle:Admin:administrator.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/admin/remove/{id}", name="remove", requirements={"id": "\d+"})
     */    
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BlogBundle:Posts')->find($id);
        
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('index');
    }
    
}
