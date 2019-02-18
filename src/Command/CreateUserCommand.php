<?php
    namespace App\Command;

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
    use Symfony\Component\Console\Style\SymfonyStyle;

    use App\Entity\User;

    use Doctrine\Common\Persistence\ObjectManager;



    class CreateUserCommand extends Command
    {
        // the name of the command (the part after "bin/console")
        protected static $defaultName = 'app:create-user';
        private $objectManager;
        private $passwordEncoder;

        public function __construct(ObjectManager $objectManager, UserPasswordEncoderInterface $passwordEncoder)
        {

            parent::__construct();
            $this->objectManager = $objectManager;
            $this->passwordEncoder = $passwordEncoder;
        }

        protected function configure()
        {
            $this   ->setDescription('Creates a new user')
                    ->setHelp('This command allows you to create a user')
                    ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
                    ->addArgument('password',InputArgument::OPTIONAL, 'User password')
            ;
        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $output->writeln([
                'User Creator',
                '============',
                '',
            ]);

            $io = new SymfonyStyle($input, $output);
            $io->title('Creates a User');


            $email = $input->getArgument('email');
            $passwordToEncode = $input->getArgument('password');
            $user = new User();
            $password = $this->passwordEncoder->encodePassword($user, $passwordToEncode);

            $user->setEmail($email);
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);



            $em = $this->objectManager;
            $em->persist($user);
            $em->flush();

            $output->writeln('User successfully generated!');
        }
    }