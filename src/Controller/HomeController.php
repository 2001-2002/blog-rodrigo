<?php
namespace App\Controller;
use App\Entity\Category;
use App\Entity\Post;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class HomeController extends AbstractController
{
    use \App\Traits\Category;
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $status = 1;
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findByStatus($status, ['id' => 'DESC']);
        $postsCarousel = $posts;
//        $paginator = $this->get('knp_paginator');
        $posts = $paginator->paginate($posts, $request->query->getInt('page', 1), 3);
        $categories = $this->getCategories($this->getDoctrine());
        return $this->render('site/posts.html.twig', ['postsCarousel' => $postsCarousel, 'posts' => $posts, 'categories' => $categories]);
    }
////    /**
////     * @Route("/search", name="search")
////     */
////    public function search(Request $request)
//    {
//        $term = $request->query->get('term');
//        $posts = $this->getDoctrine()
//            ->getRepository(Post::class)
//            ->searchPost($term);
//        $paginator = $this->get('knp_paginator');
//        $posts = $paginator->paginate($posts, $request->query->getInt('page', 1), 2);
//        $categories = $this->getCategories($this->getDoctrine());
//        return $this->render('site/search.html.twig',
//            ['posts' => $posts, 'categories' => $categories, 'term' => $term]);
//    }
    /**
     * @Route("/slug/{id}/{slug}", name="single")
     */
    public function single($id, $slug)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);
        $categories = $this->getCategories($this->getDoctrine());
        return $this->render('site/single.html.twig', ['post' => $post, 'categories' => $categories]);
    }
}