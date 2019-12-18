<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {
        $contact = new Contact();

        $formulaireContact = $this->createForm(ContactType::class, $contact)
            ->add('save', SubmitType::class);
        $formulaireContact->handleRequest($request);

        if ($formulaireContact->isSubmitted() && $formulaireContact->isValid()) {
            // dump($number);
            mail('formation@cefii.fr', 'sujet', $contact->getMessage());

            // création du email
            // $email = (new Email())
            //     ->from('a.rahard@cefii.fr')
            //     ->to('formation@cefii.fr')
            //     ->cc('projets@cefii.fr')
            //     ->replyTo('a.rahard@cefii.fr')
            //     ->priority(Email::PRIORITY_HIGH)
            //     ->subject('Important Notification')
            //     ->text('Lorem ipsum...')
            //     ->html('<h1>Lorem ipsum</h1> <p>...</p>');

            // // envoi
            // $transport = new EsmtpTransport('localhost');
            // $mailer = new Mailer($transport);
            // $mailer->send($email);

            return $this->redirectToRoute('home_page');
        }

        return $this->render('contact/index.html.twig', [
            'formulaireContact' => $formulaireContact->createView(),
        ]);
    }
}
