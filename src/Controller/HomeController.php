<?php

namespace App\Controller;

use App\Repository\PollRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\returnArgument;

class HomeController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/', name: 'app_home')]
    public function index(MailerInterface $mailer, Request $request, PollRepository $pollRepository): Response
    {
        $poll = $pollRepository->findAll()[0];
        // get all polls Questions
        $questions = $poll->getQuestions();
        foreach ($questions as $question) {
            $answers = $question->getAnswers();
        }


//        return $this->json($polls, 200, [], ['groups' => 'poll:read']);

        // make a mail form here
        $form = $this->createFormBuilder();
        foreach ($poll->getQuestions() as $question) {
            switch ($question->getType()) {
                case TextType::class:
                case CheckboxType::class:
                    $form->add($question->getId(), $question->getType(), [
                        'label' => $question->getLibelle(),
                    ]);
                    break;
                case ChoiceType::class:
                    $choices = [];
                    foreach ($question->getAnswers() as $answer) {
                        $choices[$answer->getLibelle()] = $answer->getId();
                    }
                    $form->add($question->getId(), $question->getType(), [
                        'choices' => $choices,
                        'expanded' => $question->isExpanded() ?? false,
                        'multiple' => $question->isMultiple() ?? false,
                        'label' => $question->getLibelle(),
                    ]);
                    break;
                case DateType::class:
                    $form->add($question->getId(), $question->getType(), [
                        'label' => $question->getLibelle(),
                        'widget' => 'single_text',
                    ]);
                    break;
                case TelType::class:
                case EmailType::class:
                    $form->add($question->getId(), $question->getType(), [
                        'label' => $question->getLibelle(),
                        'attr' => [
                            'placeholder' => EmailType::class === $question->getType() ? 'mail@example.com' : '0123456789',
                        ],
                    ]);
                    break;
            }

        }

        $form = $form->getForm();

        // handle the form here
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // send the email here
            $data = $form->getData();
            $email = new Email();
            $email
                ->from('noobies@sender.org')
                ->to($data['email'])
                ->subject('Petit message pour toi !')
                ->text($data['message']);

            $mailer->send($email);

            // add a flash message here
            $this->addFlash('success', 'Email sent!');
            dd($data);
        }


        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'polls' => json_encode($this->json($poll, 200, [], ['groups' => 'poll:read'])->getContent()),
        ]);
    }
}
