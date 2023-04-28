<?php

namespace App\Controller;

use App\Entity\PollResults;
use App\Repository\PollResultsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PollController extends AbstractController
{
    #[Route('/poll/{uuid}', name: 'app_poll')]
    public function index($uuid): Response
    {
        return $this->render('poll/index.html.twig', [
            'controller_name' => 'PollController',
            'uuid' => $uuid,
        ]);
    }

    #[Route('/api/poll/{uuid}', name: 'api_get_poll')]
    public function getPoll($uuid, PollResultsRepository $pollResultsRepository): Response
    {
        $poll = $pollResultsRepository->findOneBy(['uuid' => $uuid]);

        if ($poll) {
            foreach ($poll->getPoll()->getQuestions() as $question) {
                $answers = $question->getAnswers();
            }
            return $this->json($poll, 200, [], ['groups' => 'poll:read']);
        } else {
            return $this->json(['error' => 'Poll not found'], 404);
        }
    }
}
