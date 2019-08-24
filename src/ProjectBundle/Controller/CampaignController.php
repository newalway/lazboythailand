<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Intl\Locale;

class CampaignController extends Controller
{
    public function minimal_collectionAction(Request $request)
    {
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_campaign').':minimal_collection.html.twig', array(
            ''=>''
        ));
    }
}
