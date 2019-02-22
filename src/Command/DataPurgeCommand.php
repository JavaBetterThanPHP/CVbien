<?php
    namespace App\Command;

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Style\SymfonyStyle;

    use App\Entity\User;
    use App\Repository\UserRepository;

    use Doctrine\Common\Persistence\ObjectManager;


    class DataPurgeCommand extends Command
    {
        protected static $defaultName = 'app:data-purge';
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
                'GDPR - Purges',
                '============',
                '',
            ]);

            $em = $this->objectManager;
            $users = $this->objectManager->getRepository(User::class)->getUserToDelete(3);

            /** Traitement de tous les utilisateurs inactifs dans le foreach */
            foreach ($users as $user)
            {
                $user->setIsActive(true);

                $em->persist($user);
                $em->flush();
            }

            $output->writeln('Data purge successfully completed');
        }
    }