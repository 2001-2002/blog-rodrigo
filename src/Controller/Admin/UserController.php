<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/users")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('Admin/users/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder, MailerService $mailerService): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pass = $user->getPassword();
            $password = $encoder->encodePassword(new User(), $user->getPassword());
            $user->setPassword($password);
            $user->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));
            $user->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));
            $user->setRoles(array('ROLE_AUTHOR'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

//            $mailer = $this->get('App\Service\MailerService');

            $data = [
                'subject' => 'Sua conta foi criada com sucesso!',
                'name' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'password' => $pass
            ];

            $view = $this->renderView('Emails/register.html.twig', $data);

            $mailerService->send($data, $view);

            $this->addFlash('success', "Usuario salvo com sucesso!");
            return $this->redirectToRoute('login');
        }

        return $this->render('Admin/users/new.html.twig', [
            'users' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/show/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('Admin/users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $encoder->encodePassword(new User(), $user->getPassword());
            $user->setPassword($password);

            $user->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "Usuario atualizado com sucesso!");
            return $this->redirectToRoute('admin_post');
        }

        return $this->render('Admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="user_delete")
     */
    public function delete(Request $request, User $user): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('success', "Usuario excluido com sucesso!");
        return $this->redirectToRoute('user_index');
    }
}
