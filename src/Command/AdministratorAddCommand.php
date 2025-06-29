<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:administrator:add',
    description: 'Ajouter un administrateur à l\'application',
)]
class AdministratorAddCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly UserPasswordHasherInterface $hashes,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = new QuestionHelper();

        $io->title('Ajouter un administrateur à l\'application');

        $qEmail = new Question('Saisir l\'email de l\'administrateur : ');
        $qEmail->setValidator(function ($answer) {
            if (!filter_var($answer, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Cette adresse email n\'est pas valide');
            }

            return $answer;
        });

        $qPassword = new Question('Saisir le mot de passe de l\'administrateur : ');
        $qPassword->setHidden(true);
        $qPassword->setHiddenFallback(false);
        $qPassword->setValidator(function ($answer) {
            if ('' == trim($answer)) {
                throw new \Exception('Le mot de passe ne peut pas être vide');
            }

            return $answer;
        });

        $qGender = new ChoiceQuestion('Saisir la civilité de l\'administrateur : ', ['f' => 'Femme', 'm' => 'Homme']);
        $qGender->setErrorMessage('Le choix %s est invalide.');

        $qFirstname = new Question('Saisir le prénom de l\'administrateur : ');
        $qLastname = new Question('Saisir le nom de l\'administrateur : ');
        $qPhoneNumber = new Question('Saisir le numéro de téléphone de l\'administrateur : ');
        $qPostalCode = new Question('Saisir le code postal de l\'administrateur : ');
        $qBirthYear = new Question('Saisir l\'année de naissance de l\'administrateur : ');

        $email = $helper->ask($input, $output, $qEmail);
        $password = $helper->ask($input, $output, $qPassword);
        $firstname = $helper->ask($input, $output, $qFirstname);
        $lastname = $helper->ask($input, $output, $qLastname);
        $gender = $helper->ask($input, $output, $qGender);
        $phoneNumber = $helper->ask($input, $output, $qPhoneNumber);
        $postalCode = $helper->ask($input, $output, $qPostalCode);
        $birthYear = $helper->ask($input, $output, $qBirthYear);

        $user = new User();
        $user->setEmail($email)
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hashes->hashPassword($user, $password))
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setGender($gender)
            ->setPhoneNumber($phoneNumber)
            ->setPostalCode($postalCode)
            ->setBirthYear(intval($birthYear))
        ;

        $this->manager->persist($user);
        $this->manager->flush();

        $io->success('L\'administrateur a été créé avec succès !');

        return Command::SUCCESS;
    }
}
