<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request,
        MailerInterface $mailerInterface
    ): Response {
        if ($request->isMethod('POST')) {
            // php bin/console messenger:consume async -vv

            $sender = $request->request->get('email');
            $subject = $request->request->get('subject');
            $message = $request->request->get('message');

            $email = (new Email())
                // email address as a simple string
                ->from($sender)
                ->to('contact@example.com')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                // ->priority(Email::PRIORITY_HIGH)
                ->subject($subject)
                ->text($message);

            $mailerInterface->send($email);
        }
        return $this->render('contact/index.html.twig');
    }
}
