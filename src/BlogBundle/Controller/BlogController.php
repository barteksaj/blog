<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{

    /**
     * @Route("/{page}", name="index", defaults={"page" = 1}, requirements={"page": "\d+"})
     */

    public function indexAction(Request $request, $page)
    {
        $posts = $this->getDoctrine()->getManager();
        $query = $posts->createQuery(
                  'SELECT p FROM BlogBundle:Posts p ORDER BY p.id DESC'
                );
 
                   
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->get('page', $page)/*page number*/,
            10/*limit per page*/
        );
    
    
        return $this->render('BlogBundle:Blog:index.html.twig', array('pagination' => $pagination));
    }
    
    
    /**
     * @Route("/post/{id}", name="post", requirements={"id": "\d+"})
     */
     
    public function postAction($id)
    {    
        $post = $this->getDoctrine()
                     ->getRepository('BlogBundle:Posts')
                     ->find($id);

        if (!$post) {
            throw $this->createNotFoundException('Nie znaleziono wpisu o id: '.$id);
        }
        $title = $post->getTitle();
        $content = $post->getContent();
        
        return $this->render('BlogBundle:Blog:post.html.twig', array(
            'content' => $content, 
            'title' => $title, 
            'id' => $id
        ));
    }    
}
