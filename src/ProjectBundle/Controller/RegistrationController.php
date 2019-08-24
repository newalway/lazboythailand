<?php

namespace ProjectBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

use ProjectBundle\Entity\SettingOption;
use Symfony\Component\Intl\Locale;

class RegistrationController extends BaseController
{
	/**
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Request $request)
    {
        $user = $this->getUser();
		if($user){
			throw $this->createAccessDeniedException('You are not permitted to use that link to directly access that page');
		}

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

    			//start custome register user
    			$util = $this->container->get('utilities');
    			$form_data = $form->getData();
    			$email = $form_data->getEmail();
    			$plainpass = $form_data->getPlainPassword();
                $roles = array('ROLE_CUSTOMER');

                // we set username in user entity
                // $user->setUsername($email);
                // $user->setUsernameCanonical($email);

                $user->setRoles($roles);
                $user->setIsSetPassword(1);
                //end custome register user

                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                //get user scope
                $scope = $this->container->getparameter('access_token_customer_scope');

                //set oauth token
                $util->setAccessToken($email, $plainpass, $scope);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('@FOSUser/Registration/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param Request $request
     * @param string  $token
     *
     * @return Response
     */
    public function confirmAction(Request $request, $token)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        //send welcome our customer email
        $this->sendWelcomeMail($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    protected function sendWelcomeMail($user)
    {
        //default subject, body
        $subject = $this->get('translator')->trans('registration.welcome_email.subject', array('%name%' => $user->getFirstName()), 'FOSUserBundle');
        $body = '';

        $locale = Locale::getDefault();
        $em = $this->getDoctrine()->getManager();
        $setting_repo = $em->getRepository(SettingOption::class);

        //subject
        $email_subject = $setting_repo->findOneByOptionName('fos_registration_welcome_email_subject_'.$locale);
        if($email_subject){
			$subject = $email_subject->getOptionValue();
		}

        //mail content
        $email_body = $setting_repo->findOneByOptionName('fos_registration_welcome_email_message_'.$locale);
        if($email_body){
			$body = $email_body->getOptionValue();
		}

        //replace parameter
        $patterns = $this->container->getParameter('param_registration_welcome_email_pattern');
        $value_array['email'] = $user->getEmail();
		$value_array['first_name'] = $user->getFirstName();
		$value_array['last_name'] = $user->getLastName();
        $subject = preg_replace($patterns, $value_array, $subject);
        $body = preg_replace($patterns, $value_array, $body);

        //Default sender email
        $sender_mail_address = $this->container->getParameter('default_sender_mail_address');
        $default_sender_mail_name = $this->container->getParameter('default_sender_mail_name');

        $message = (new \Swift_Message($subject))
        ->setFrom(array($sender_mail_address => $default_sender_mail_name))
        ->setTo($value_array['email'])
        ->setBody(
            $this->renderView(
                'ProjectBundle:'.$this->container->getParameter('view_main').':_email_welcome_our_customer.html.twig',
                array(
                    'user'=>$user,
                    'subject'=>$subject,
                    'body'=>$body
                )
            ),
            'text/html'
        );

        try{
            $this->get('mailer')->send($message);
            $response['success'] = true;
            $response['message'] = $this->get('translator')->trans('contact.send.thank');
        }catch(\Exception $e){
            #Do nothing
            $response['success'] = false;
            $response['message'] = $this->get('translator')->trans('contact.cannot.send');
        }

        return $response;
    }
}
