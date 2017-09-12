<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 12/09/17
 * Time: 14:32
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use AppBundle\Entity\Comment;
use AppBundle\Form\Type\ArticleType;
use AppBundle\Form\Type\CommentType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @Rest\View(serializerGroups = {"comment"})
     * @Rest\Get("/articles/{id}/comments")
     *
     * @param Request $request
     * @return View
     */
    public function getCommentsAction(Request $request)
    {
      $article = $this->getDoctrine()
          ->getRepository(Article::class)
          ->find($request->get('id'));

      if(empty($article)) {
          return $this->placeNotFound();
      }

      return $article->getComments();
    }

    /**
     * @Rest\View(serializerGroups = {"comment"})
     * @Rest\Post("/articles/{id}/comments")
     *
     * @param Request $request
     * @return View
     */
    public function postCommentsAction(Request $request)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($request->get('id'));

        if (empty($article)) {
           return $this->placeNotFound();
        }

        $comment = new Comment();
        $comment->setArticle($article);
        $form = $this->createForm(CommentType::class, $comment);
        $form->submit($request->request->all());

        if ($form->isValid()) {
           $em = $this->getDoctrine()->getManager();
           $em->persist($comment);
           $em->flush();
           return $comment;
        }

        return $form;
    }

    /**
     * @return View
     */
    private function placeNotFound()
    {
        return View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
    }
}