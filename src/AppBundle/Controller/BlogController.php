<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 08/09/17
 * Time: 15:20
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("/test/accueil", name="accueil")
     *
     * @Template
     */
    public function listAction()
    {
        return [];
    }

    /**
     * @Route(
     *     path = "/test/liste",
     *     name = "liste"
     * )
     *
     * @Template
     */
    public function listeAction()
    {
        $articles = [1, 2, 3, 4, 5];

        return [
            'articles' => $articles,
        ];
    }

    /**
     * @Route("/test/specific/{page}", name="specific", requirements={"page": "\d+"})
     *
     * @param Request $request
     * @param int     $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pageAction(Request $request, $page)
    {
        return $this->render('/test/page.html.twig', array(
            'page' => $page,
        ));
    }
}