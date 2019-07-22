<?php
namespace App\Command;

use App\Entity\ProgLanguage;
use App\Entity\UserProgLanguage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Entity\User;
use App\Repository\UserRepository;

use Doctrine\Common\Persistence\ObjectManager;


class AtributeFixturesCommand extends Command
{
    protected static $defaultName = 'app:atribute-fixtures';
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct();
        $this->objectManager = $objectManager;
    }

    protected function configure()
    {
        $this ->setDescription('Data Purge')
            ->setHelp('This command allows you to purge data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Atribute Fixtures',
            '============',
            '',
        ]);

        $em = $this->objectManager;
        $users = $this->objectManager->getRepository(User::class)->findAll();
        $progLanguages = $this->objectManager->getRepository(ProgLanguage::class)->findAll();


        foreach ($users as $user)
        {

            $userProgLanguage = new UserProgLanguage();
            $userProgLanguage->setLevel(rand(1, 10));
            $userProgLanguage->setProgLanguage($progLanguages[rand(1, 15)]);
            $userProgLanguage->setUser($user);

            $em->persist($userProgLanguage);
            $em->flush();
        }

        $output->writeln('fixtures atributed');
    }
}