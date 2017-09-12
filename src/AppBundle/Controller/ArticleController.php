<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\Type\ArticleType;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// alias pour toutes les annotations

class ArticleController extends Controller
{
    /**
     * @Rest\View(serializerGroups = {"article"})
     *
     * @param Request $request
     * @return Response
     */
    public function getArticlesAction(Request $request)
    {
        /** @var Article[] $articles */
       $articles = $this->getDoctrine()
           ->getRepository(Article::class)
           ->findAllOrderedByTitle();

       /*$formatted = [];

       foreach($articles as $article) {
           $formatted[] = [
               'id' => $article->getId(),
               'title' => $article->getTitle(),
               'content' => $article->getContent(),
               'author' => $article->getAuthor()
           ];
       }*/

       return $articles;
    }


    /**
     * @Rest\View(serializerGroups = {"article"})
     *
     * @param Request $request
     * @param $id
     * @return Article|null|object|JsonResponse
     */
    public function getArticleAction($id, Request $request)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($request->get('id'));

        if(empty($article)) {
            return new JsonResponse(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        return $article;
    }

    /**
     * @Rest\View(statusCode = Response::HTTP_CREATED, serializerGroups = {"article"})
     *
     * @param Request $request
     * @return Article
     */
    public function postArticlesAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->submit($request->request->all());

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $article;
        }

        return $form;
    }

    /**
     * @Rest\View(statusCode = Response::HTTP_NO_CONTENT, serializerGroups = {"article"})
     *
     * @param Request $request
     */
    public function deleteArticleAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)
            ->find($request->get('id'));

        if($article) {
            $em->remove($article);
            $em->flush();
        }
    }

    /**
     * @Rest\View(serializerGroups = {"article"})
     *
     * @param $id
     * @param Request $request
     * @return Article|null|object|\Symfony\Component\Form\Form|JsonResponse
     */
    public function putArticleAction($id, Request $request)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($request->get('id'));

        if(empty($article)) {
            return new JsonResponse(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($request->request->all());

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $article;
        } else {
            return $form;
        }
    }
}