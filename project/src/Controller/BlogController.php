<?php

namespace App\Controller;

use App\Entity\BlogPost;
use Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;


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
     * @Route("/{page}", name="blog_list", requirements={"page"="/d+"})
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function list($page = 1)
    {
        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $items = $repository->findAll();
        return $this->json([
           'data' => $items,
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
     * @Route("/{slug}", name="blog_by_slug" , methods={"GET"})
     * @param string $slug
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postBySlug(string $slug)
    {

        return $this->json(self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]);
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"} )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function add(Request $request)
    {
        /** @var Serializer $serializer */
        $serializer = $this->get("serializer");

        $blogPost = $serializer->deserialize($request->getContent(),BlogPost::class,'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($blogPost);
        $em->flush();

        return $this->json($blogPost);
    }

}