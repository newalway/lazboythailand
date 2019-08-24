<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use JMS\SecurityExtraBundle\Annotation\Secure;
use FOS\OAuthServerBundle\Propel\TokenQuery;

use ProjectBundle\Form\Type\ReviewSettingType;


use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\Finder\Finder;

use GuzzleHttp\Client;

use ProjectBundle\Entity\Review;
use ProjectBundle\Entity\ReviewSetting;



class AdminReviewController extends Controller
{
	const ROUTER_INDEX = 'admin_review';
	const ROUTER_ADD = self::ROUTER_INDEX.'_new';
	const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';
	const ROUTER_PREFIX = 'review';
	const ROUTER_CONTROLLER = 'AdminReview';

	protected function getQuerySearchData($arr_query_data)
	{
		$repository = $this->getDoctrine()->getRepository(Review::class);
		$query = $repository->findAllData($arr_query_data);
		return $query;
	}

	/**
  * @Secure(roles="ROLE_EDITOR")
  */
	public function indexAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$session = $request->getSession();
		try {
			$acctoken = $util->getAccessToken();
		} catch(\Exception $e) {
			return $this->redirectToRoute('admin_user_generate_token');
		}

		$arr_query_data = $util->prepare_query_data($request);
		$query = $this->getQuerySearchData($arr_query_data);
		$paginated = $util->setPaginatedOnPagerfanta($query);
		// dump($paginated->getCurrentPageResults());
		// exit;
		$util->setBackToUrl();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array(
			'paginated' =>$paginated
		));
	}

	/**
  * @Secure(roles="ROLE_EDITOR")
  */
	public function viewAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$acctoken = $util->getAccessToken();

		$data = $this->getDoctrine()->getRepository(Review::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

// dump($data);
// exit;
		//$form = $this->createForm(AdminPromotionType::class, $data, array('allow_extra_fields'=>true));
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':view.html.twig', array(
			'data' =>$data
		));




		// $this->setCkAuthorized();
		// $data = ReviewQuery::create()->findPk($request->get('id'));
		// if (!$data) {
		// throw $this->createNotFoundException('This data doesn\'t exist');
		// }
		// return $this->render('ProjectBundle:AdminReview:view.html.twig', array('data' =>$data));
	}

	/**
  * @Secure(roles="ROLE_EDITOR")
  */
	public function publishAction(Request $request)
	{

		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$acctoken = $util->getAccessToken();

		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(Review::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$data->setStatus(1);
		$em->flush();

		//set product review and rating
		$product = $data->getProduct();

		$util->setProductRatingAndReview($product);

		$this->get('session')->getFlashBag()->add('notice', 'Publish');



		return $this->redirectToRoute('admin_review_view',array('id'=>$data->getId()));

	    // $data = ReviewQuery::create()->findPk($request->get('id'));
	    // if (!$data) {
	    //   throw $this->createNotFoundException('This data doesn\'t exist');
	    // }
		//
		// $data->setStatus(1);
		// $data->save();
		//
		// //set product review and rating
		// $product = $data->getProduct();
		// $this->setProductRatingAndReview($product);
		//
		// $this->get('session')->getFlashBag()->add('notice', 'Publish');
		// return $this->redirectToRoute('admin_review_view',array('id'=>$data->getId()));
	}

	/**
  * @Secure(roles="ROLE_EDITOR")
  */
	public function unpublishAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$acctoken = $util->getAccessToken();

		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(Review::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$data->setStatus(0);
		$em->flush();

		//set product review and rating
		$product = $data->getProduct();
		$util->setProductRatingAndReview($product);

		$this->get('session')->getFlashBag()->add('notice', 'Unpublish');



		return $this->redirectToRoute('admin_review_view',array('id'=>$data->getId()));
	}

	/**
  * @Secure(roles="ROLE_EDITOR")
  */
	public function deleteAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(Review::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		try {
			$em->remove($data);
			$em->flush();

			//set product review and rating
			$product = $data->getProduct();
			$util->setProductRatingAndReview($product);

			$util->setRemoveNotice();
		} catch(\Doctrine\DBAL\DBALException $e) {
			$util->setCustomeFlashMessage('warning', $msg="Can't delete ".$data->getTitle());
		}

		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));

	}

	/**
  * @Secure(roles="ROLE_EDITOR")
  */
	public function group_deleteAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data_ids = $request->get('data_ids');

		if ($data_ids) {
			$flg_del = false;
			foreach ($data_ids as $data_id) {
				$data = $em->getRepository(Review::class)->find($data_id);
				if ($data) {
					try {
						$em->remove($data);
						$em->flush();

						//set product review and rating
						$product = $data->getProduct();
						$util->setProductRatingAndReview($product);

						$flg_del = true;
					} catch(\Doctrine\DBAL\DBALException $e) {
						$util->setCustomeFlashMessage('warning', $msg="Can't delete ".$data->getTitle());
					}
				}
			}
			if ($flg_del) {
				$util->setRemoveNotice();
			}
		}
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
  * @Secure(roles="ROLE_EDITOR")
  */
	public function group_enableAction(Request $request)
	{
		$data_ids = $request->get('data_ids');
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		if ($data_ids) {
			$flg_pub = false;
			foreach ($data_ids as $data_id) {
				$data = $em->getRepository(Review::class)->find($data_id);
				if ($data) {
					$data->setStatus(1);
					$em->flush();

					//set product review and rating
					$product = $data->getProduct();
					$util->setProductRatingAndReview($product);

					$flg_pub = true;
				}
			}
			if ($flg_pub) {
				$this->get('session')->getFlashBag()->add('notice', 'Publish');
			}
		}
			return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
  * @Secure(roles="ROLE_EDITOR")
  */
	public function group_disableAction(Request $request)
	{
		$data_ids = $request->get('data_ids');
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		if ($data_ids) {
			$flg_pub = false;
			foreach ($data_ids as $data_id) {
				$data = $em->getRepository(Review::class)->find($data_id);
				if ($data) {
					$data->setStatus(0);
					$em->flush();

					//set product review and rating
					$product = $data->getProduct();
					$util->setProductRatingAndReview($product);

					$flg_pub = true;
				}
			}
			if ($flg_pub) {
				$this->get('session')->getFlashBag()->add('notice', 'Unpublish');
			}
		}
			return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
  * @Secure(roles="ROLE_ADMIN")
  */
	public function settingAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$session = $request->getSession();
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(ReviewSetting::class)->createQueryBuilder('rst')->getQuery()->getOneOrNullResult();
		$form = $this->createForm(ReviewSettingType::class, $data);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em->flush();
			$util->setUpdateNotice();
		}

		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':setting.html.twig', array(
			'form' => $form->createView()
		));
	}

}
