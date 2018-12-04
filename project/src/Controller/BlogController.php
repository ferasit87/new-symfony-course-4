<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/blog")
 */
class  BlogController extends AbstractController
{

    const POSTS = [
        [
            "id" => 1,
            "slug" => "hello-world",
            "title" => "Hello world",
        ],
        [
            "id" => 2,
            "slug" => "hello-world2",
            "title" => "Hello world2",
        ],
        [
            "id" => 3,
            "slug" => "hello-world3",
            "title" => "Hello world3",
        ],
    ];

    /**
     * @Route("/{page}", name="blog_list")
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function list($page = 1)
    {
        return $this->json([
           'data' => self::POSTS,
            'page' => $page,
        ]);
    }

    /**
     * @Route("/{id}", name="blog_by_id",requirements={"id"="\d+"})
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function post(string $id)
    {

        return $this->json(self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]);
    }

    /**
     * @Route("/{slug}", name="blog_by_slug")
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postBySlug(string $slug)
    {

        return $this->json(self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]);
    }

}