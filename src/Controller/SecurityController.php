<?php
namespace App\Controller;
use App\Entity\User;
use App\Service\MailerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error
        ));
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/esqueci/{username}", name="esqueci_senha")
     */
    public function esqueciSenha($username,UserPasswordEncoderInterface $encoder, MailerService $mailerService){


//        $usuario->setFirstName();
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findUsername($username);

        $pass = 'blog'.rand(0, 1000);

        $password = $encoder->encodePassword($user[0], $pass);

        $user[0]->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));
        $user[0]->setPassword($password);
        $entityManager->flush();

        $data = [
            'subject' => 'Esqueceu sua senha?',
            'name' => $user[0]->getFirstName(),
            'email' => $user[0]->getEmail(),
            'username' => $user[0]->getUsername(),
            'password' => $pass
        ];

        $view = $this->renderView('Emails/esqueci_senha.html.twig', $data);

        $mailerService->send($data, $view);
        $this->addFlash('success', "Senha enviada para seu email!");

        return $this->redirectToRoute('login');
    }
}