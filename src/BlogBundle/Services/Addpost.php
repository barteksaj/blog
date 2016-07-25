<?php

namespace BlogBundle\Services;

use BlogBundle\Entity\Posts;

class Addpost
{
    protected $post;

    public function __construct($title,$content)
    {
        $post = new Posts();
        $post->setTitle($title);
        $post->setContent($content);

        $this->post = $post;     
    }
    
    public function getPost()
    {
        return $this->post;    
    }
}