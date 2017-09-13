<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ArticleType;
use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
     * */


    /**
     * @Route("/new_article", name = "new_article_form")
     *
     * @Template
     *
     * @param Request $request
     * @return array
     */
    public function newArticleAction(Request $request)
    {
        $form = $this->createForm(ArticleType::class);
        return ['form' => $form->createView()];
    }

    /**
     * @Route("/show_articles", name = "show_articles")
     *
     * @Template
     *
     * @param Request $request
     * @return array
     */
    public function showAll(Request $request)
    {
        $client = new Client();
        $res = $client->request(
            'GET',
            'db'.$this->generateUrl('get_articles', [], UrlGeneratorInterface::ABSOLUTE_PATH)
        );

        $articles = $res->getBody();

        return [
            'articles' => $articles,
            'count' => count($articles)
        ];
    }
}
