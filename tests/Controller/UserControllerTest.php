<?php

namespace App\Tests\Controller;


use App\Controller\Front\UserController;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;

final class UserControllerTest extends WebTestCase {

    public $floatValue = 8.5;
    public $boolValue = true;
    public $arrayValue = ["array"];
    public $intValue = 15;
    public $nullValue = null;
    public $emptyValue = "";
    public $validMail = "mail@mail.fr";
    public $validSurname = "Paul";
    public $validName = "Jacques";
    public $validSpaceName = 'mon_space_name';
    public $validPassword = 'mon_password';

    public $user;
    public $userAuthenticated;
    public $authenticated = true;

    public $request;
    public $validForm;
    public $submittedForm;
    public $form;


    public function testEdit()
    {

    }

    protected  function setUp(): void
    {
        //$this->userAuthenticated = $this->createMock(ControllerTrait::class);
        //$this->userAuthenticated->method('denyAccessUnlessGranted')->willReturn($this->authenticated);

        //$this->validForm = $this->createMock(FormInterface::class);
        //$this->validForm->method('isValid')->willReturn(true);

        //$this->submittedForm = $this->createMock(FormInterface::class);
        //$this->submittedForm->method('isSubmitted')->willReturn(true);

        //$this->form = $this->createMock(FormInterface::class);

        //$this->request = $this->createMock(Request::class);
        //$this->request->method('request')->willReturn(Response::class);


        /**
        $this->user = new User();
        $this->user->setFirstname($this->validSurname);
        $this->user->setLastname($this->validName);
        $this->user->setEmail($this->validMail);
        $this->user->setSpaceName($this->validSpaceName);
        $this->user->setPassword($this->validPassword);
        */

        $this->user = $this->createMock(User::class);
        $this->user->setFirstname($this->validSurname);
        $this->user->setLastname($this->validName);
        $this->user->setEmail($this->validMail);
        $this->user->setSpaceName($this->validSpaceName);
        $this->user->setPassword($this->validPassword);

        //print_r($this->user);die;
    }

}