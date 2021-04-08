<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passEncoder): Response
    {
        $form = $this->createFormBuilder() 
            ->add('name',TextType::class)
            ->add('email')
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password'],
            ])
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success float-right'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $data = $form->getData();

            $user = new User();

         //   $user->setRoles();
            $user->setEmail($data['email']);
           // $user->setRoles(["ROLE_USER"]);
          //  $user->setRoles([]);
            $user->setPassword(
                  $passEncoder->encodePassword($user, $data['password'])
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em-> flush();
            return $this->redirect($this->generateUrl('app_login'));
            
        }

       // return $this->render('register/index.html.twig',[
        return $this->render('registration/registration_layout.html.twig',[

                        'form' => $form->createView()
        ]);

    }
}
