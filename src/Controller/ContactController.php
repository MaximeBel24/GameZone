<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $userEmail = $data['email'];
            $firstName = $data['firstname'];
            $lastName = $data['lastname'];
            $subject = $data['subject'];
            $content = $data['message'];

            $email = (new Email())
                ->from($userEmail)
                ->to('maxime.b2494@gmail.com')
                ->subject($subject)
                ->text("$userEmail \n\n Bonjour Madame, Monsieur,\n\nJe suis $firstName $lastName.\n\n$content");

            $mailer->send($email);

            return $this->redirectToRoute('contact');
        }

        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contactForm' => $form
        ]);
    }
}
