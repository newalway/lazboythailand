<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ProjectBundle\Entity\ProductOptionCategory;
use ProjectBundle\Entity\ProductOption;
use ProjectBundle\Form\Type\AdminProductOptionType;
use ProjectBundle\Form\Type\AdminSearchProductOptionType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

class AdminProductOptionController extends Controller
{
	const ROUTER_INDEX = 'admin_product_option';
	const ROUTER_ADD = self::ROUTER_INDEX.'_new';
	const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';
	const ROUTER_CONTROLLER = 'AdminProductOption';

	protected function getQuerySearchData($arr_query_data)
	{
		$repository = $this->getDoctrine()->getRepository(ProductOption::class);
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

		$form_search = $this->createForm(AdminSearchProductOptionType::class, null, array('allow_extra_fields'=>true));
		$form_search->handleRequest($request);

		$arr_query_data = $request->query->get('admin_search_product_option');
		$query = $this->getQuerySearchData($arr_query_data);

		$paginated = $util->setPaginatedOnPagerfanta($query);

		$util->setBackToUrl();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array(
			'paginated' =>$paginated,
			'form_search' =>$form_search->createView(),
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function newAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$data = new ProductOption();
		$arr_query_data = $request->query->get('admin_search_product_option');

		if( isset($arr_query_data['productOptionCategory']) && $arr_query_data['productOptionCategory']){
			$ProductOptionCategory = $em->getRepository(ProductOptionCategory::class)->find($arr_query_data['productOptionCategory']);
			if (!$ProductOptionCategory) { throw $this->createNotFoundException('No data found'); }
			$data->setProductOptionCategory($ProductOptionCategory);
			// $data->setStatus('0');
		}

		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$form = $this->createForm(AdminProductOptionType::class, $data);
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView()
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function createAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = new ProductOption();
		$form = $this->createForm(AdminProductOptionType::class, $data);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$form_data = $form->getData(); // print_r(dump($form_data));

			$defaultOption = $form_data->getDefaultOption();
			$productOptionCategory = $form_data->getProductOptionCategory();
			//reset default_option
			if ($defaultOption) {
				// reset default_option
				$em->getRepository(ProductOption::class)->setClearDefaultOptionValueByCategory($productOptionCategory);
			}

			$em->persist($data);
			$em->flush();

			$util->setCreateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView()
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function editAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$data = $this->getDoctrine()->getRepository(ProductOption::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminProductOptionType::class, $data);
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview()
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function updateAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(ProductOption::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminProductOptionType::class, $data);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$form_data = $form->getData(); // print_r(dump($form_data));

			$defaultOption = $form_data->getDefaultOption();
			$productOptionCategory = $form_data->getProductOptionCategory();
			//reset default_option
			if ($defaultOption) {
				// reset default_option
				$em->getRepository(ProductOption::class)->setClearDefaultOptionValueByCategory($productOptionCategory);
			}

			// $form_data = $form->getData();
			if($request->get('removefileimage')==1){
				$data->removeImage();
			}

			$em->flush();

			$util->setUpdateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array('form'=>$form->createview()));
	}

	/**
	 * @Secure(roles="ROLE_EDITOR")
	 */
	public function deleteAction(Request $request)
	{
    	$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

    	$data = $em->getRepository(ProductOption::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

	    $em->remove($data);
	    $em->flush();

		$util->setRemoveNotice();
    	return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
  	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function sortAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$arr_query_data = $request->query->get('admin_search_product_option');
		$datas = $this->getQuerySearchData($arr_query_data, $request->getLocale())->getQuery()->getResult();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':sort.html.twig', array('datas' =>$datas));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function sort_prosessAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$i=0;
		$sorted = $request->get('sort');
		if ($sorted) {
			foreach ($sorted as $data_id) {
				$data = $em->getRepository(ProductOption::class)->find($data_id);
				if ($data) {
					$i=$i+1;
					$data->setPosition($i);
				}
			}
			try {
				$em->flush();
				$status='complete';
			} catch(\Exception $e) {
				$status='error';
			}
			return new Response($status);
		}
	}
}
