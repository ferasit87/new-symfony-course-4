<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param $page
     * @return JsonResponse
     */
    public function list($page = 1)
    {
        return new JsonResponse([
           'data' => self::POSTS,
            'page' => $page,
        ]);
    }

    /**
     * @Route("/{id}", name="blog_by_id",requirements={"id"="\d+"})
     * @param string $id
     * @return JsonResponse
     */
    public function post(string $id): JsonResponse
    {

        return new JsonResponse(self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]);
    }

    /**
     * @Route("/{slug}", name="blog_by_slug")
     * @param string $slug
     * @return JsonResponse
     */
    public function postBySlug(string $slug): JsonResponse
    {

        return new JsonResponse(self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]);
    }

}