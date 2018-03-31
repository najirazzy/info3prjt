<?php

namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/userformajt", name="userformajt")
     */
    public function afficherFormUser()
    {

        $form = $this->createForm(UserType::class);
        return $this->render('user/index.html.twig', [
            'formUserSend' => $form->createView(),
        ]);
    }
    /**
     * @Route("/adduser", name="adduser")
     */
    public function addTheUser(Request $request)
    {

        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        //handler request
        $user = new User();

        $nom = $form['nom']->getData();
        $email = $form['email']->getData();
        $login = $form['login']->getData();
        $password = $form['password']->getData();

        $user->setNom($nom);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setLogin($login);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $this->addFlash('notice', "Ajout reussit");

        return $this->render('user/userAdd.html.twig', [
            'user' => $user,
            'promotion' => 'INF3',
        ]);
    }
}
