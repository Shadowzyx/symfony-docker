<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 12/09/17
 * Time: 09:55
 */

namespace AppBundle\Controller;

use AppBundle\Form\Type\UserType;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Rest\View
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        /*$formatted = [];

        foreach($users as $user) {
            $formatted[] = [
                'id' => $user->getId(),
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
            ];
        }*/

        return $users;
    }

    /**
     * @Rest\View
     *
     * @param $id
     * @param Request $request
     * @return User|object|JsonResponse
     */
    public function getUserAction($id, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($request->get('id'));

        if(empty($user)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @Rest\View(statusCode = Response::HTTP_CREATED)
     *
     * @param Request $request
     * @return User|\Symfony\Component\Form\Form
     */
    public function postUsersAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all());

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $user;
        }

        return $form;
    }

    /**
     * @Rest\View(statusCode = Response::HTTP_NO_CONTENT)
     * @Rest\Put("/users/{id}")
     *
     * @param $id
     * @param Request $request
     */
    public function deleteUserAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)
            ->find($request->get('id'));

        if($user) {
            $em->remove($user);
            $em->flush();
        }
    }

    /**
     * @Rest\View
     * @Rest\Put("/users/{id}")
     *
     * @param Request $request
     * @return User|object|\Symfony\Component\Form\Form|JsonResponse
     */
    public function putUserAction(Request $request)
    {
        return $this->updateUser($request, true);
    }

    /**
     * @Rest\View
     * @Rest\Patch("/users/{id}")
     *
     * @param Request $request
     * @return User|object|\Symfony\Component\Form\Form|JsonResponse
     */
    public function patchUserAction(Request $request)
    {
        return $this->updateUser($request, false);
    }

    /**
     * @param Request $request
     * @param bool $clearMissing
     *
     * @return User|object|\Symfony\Component\Form\Form|JsonResponse
     */
    public function updateUser(Request $request, $clearMissing)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($request->get('id'));

        if (empty($user)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $user;
        }

        return $form;
    }
}