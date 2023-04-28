<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Poll;
use App\Entity\PollResults;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create Poll
        $poll = new Poll();
        // generate question with type, multiple, expanded, answers and libelle for each question
        $questions = [
            // make unique choice not expanded question
            [
                'question' => 'Quelle est votre couleur préférée ?',
                'multiple' => false,
                'expanded' => false,
                'type' => ChoiceType::class,
                'answers' => [
                    'Rouge',
                    'Vert',
                    'Bleu',
                    'Jaune',
                    'Orange',
                    'Violet',
                    'Noir',
                    'Blanc',
                    'Rose',
                    'Marron',
                    'Gris',
                ],
            ],
//           make multichoice not expanded question
            [
                'question' => 'Quels sont vos langages de programmation préférés ?',
                'multiple' => true,
                'expanded' => false,
                'type' => ChoiceType::class,
                'answers' => [
                    'PHP',
                    'JavaScript',
                    'Java',
                    'Python',
                    'C',
                    'C++',
                    'C#',
                    'Ruby',
                    'Go',
                    'Swift',
                    'Kotlin',
                    'Rust',
                    'TypeScript',
                    'Scala',
                    'Perl',
                    'R',
                    'Objective-C',
                    'Visual Basic',
                    'Dart',
                    'Lua',
                    'Haskell',
                    'Julia',
                    'Delphi',
                    'Assembly language',
                    'PowerShell',
                    'Visual Basic .NET',
                    'Clojure',
                    'Groovy',
                    'Elixir',
                    'Erlang',
                    'F#',
                    'Racket',
                    'Scheme',
                    'COBOL',
                    'Fortran',
                    'Ada',
                    'Lisp',
                    'Prolog',
                    'Scratch',
                    'Logo',
                    'LabVIEW',
                    'ABAP',
                    'PL/SQL',
                    'Transact-SQL',
                    'Apex',
                    'Bash',
                    'Forth',
                    'Ladder Logic',
                    'Objective-J',
                    'OpenEdge ABL',
                    'Smalltalk',
                    'Verilog',
                    'VHDL',
                    'Awk',
                    'BASIC',
                    'Caml',
                    'D',
                    'Forth',
                    'Hack',
                    'Icon',
                    'IDL',
                    'J',
                    'Julia',
                    'Ladder Logic',
                    'Lasso',
                    'LiveScript',
                    'Logtalk',
                    'Mathematica',
                    'MATLAB',
                    'ML',
                    'Nim',
                    'Oberon',
                    'OpenCL',
                    'OpenEdge ABL',
                    'Oz',
                    'Pascal',
                    'PostScript',
                    'PowerShell',
                    'Processing',
                    'Puppet',
                    'PureScript',
                    'RPG',
                    'SAS',
                    'Sass',
                    'Scilab',
                    'Sed',
                    'Shell',
                    'Simula',
                    'Simulink',
                    'Smalltalk',
                    'Solidity',
                    'SQL',
                    'Stata']
            ],
            // make expanded unique choice question (yes/no/maybe) :
            [
                'question' => 'Aimez-vous Symfony ?',
                'multiple' => false,
                'expanded' => true,
                'type' => ChoiceType::class,
                'answers' => [
                    'Oui',
                    'Non',
                    'Peut-être',
                ],
            ],
            // make expanded multichoice question :
            [
                'question' => 'Quels sont vos frameworks PHP préférés ?',
                'multiple' => true,
                'expanded' => true,
                'type' => ChoiceType::class,
                'answers' => [
                    'Symfony',
                    'Laravel',
                    'Zend',
                    'CakePHP',
                    'CodeIgniter',
                ],
            ],
            // make checkbox question
            [
                'question' => 'êtes-vous un développeur ?',
                'type' => CheckboxType::class,
            ],
            // make text question
            [
                'question' => 'Quel est votre nom ?',
                'type' => TextType::class,
                'placeholder' => 'Votre nom',
            ],
            // make mail question
            [
                'question' => 'Quel est votre mail ?',
                'type' => EmailType::class,
            ],
            // make teltype question
            [
                'question' => 'Quel est votre numéro de téléphone ?',
                'type' => TelType::class,
            ],
            // make dateType question
            [
                'question' => 'Quel est votre date de naissance ?',
                'type' => DateType::class,
            ],
        ];

        foreach ($questions as $question) {
            $questionObj = new Question();
            $questionObj->setLibelle($question['question']);
            $questionObj->setType($question['type']);
            $questionObj->setPoll($poll);
            if (!empty($question["multiple"])) $questionObj->setMultiple($question["multiple"]);
            if (!empty($question["expanded"])) $questionObj->setExpanded($question["expanded"]);
            if (!empty($question["answers"])) {
                foreach ($question['answers'] as $answer) {
                    $answerObj = new Answer();
                    $answerObj->setLibelle($answer);
                    $answerObj->setQuestion($questionObj);
                    $manager->persist($answerObj);
                }
            }
            $manager->persist($questionObj);
        }

        $manager->persist($poll);

        $pollResults = new PollResults();

        $pollResults->setPoll($poll);
        $pollResults->setUuid(Uuid::v4());
        $pollResults->setClientNumber(123456);
        $pollResults->setCustomerMail('john.doe@mail.com');
        $pollResults->setPollData('');


        $manager->persist($pollResults);


        $manager->flush();
    }
}
