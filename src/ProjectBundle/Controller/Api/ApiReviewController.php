<?php

namespace ProjectBundle\Controller\Api;

use ProjectBundle\Controller\Api\ApiApplicationController;
use ProjectBundle\Controller\ApplicationController;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Translation\TranslatorInterface;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\SecurityContext;
use \Criteria;

use ProjectBundle\Entity\User;
use ProjectBundle\Entity\Review;
use ProjectBundle\Entity\Product;


use ProjectBundle\Form\Type\ReviewType;


class ApiReviewController extends FOSRestController
{
	/**
		 * Post review data by user.
		 *
     * @ApiDoc(
		 *   resource = true,
     *   description = "Post review data by user",
     * )
     *
	   *
	   * @param Request $request the request object
	   *
	   * @return FormTypeInterface|RouteRedirectView
	   *
	   * @throws NotFoundHttpException when user not exist
	   */
	public function postReviewsAction(Request $request)
  {
		$user = $this->getUser(); //not all user_data
		$email = $user->getUsername();

		$em = $this->container->get('doctrine')->getEntityManager();
		$util = $this->container->get('utilities');



		$user = $em->getRepository(User::class)
			->getActiveMemberByEmail($email)
			->getQuery()
			->getSingleResult();
		//$user = UserQuery::create()->filterByEmail($email)->findOne();
		if(!$user){
			throw new AccessDeniedException();
		}


		$first_name = $user->getFirstName();
		$last_name = $user->getLastName();
		$client_ip = $request->getClientIp();

		$reviewer_name = $util->makeReviewerName($first_name, $last_name);

		$review_data = $request->get('review');
		$rating = $review_data['ratingScore'];
		$product_id = $review_data['product_id'];
		$title = (isset($review_data['title'])) ? $review_data['title'] : '' ;
		$content = (isset($review_data['content'])) ? $review_data['content'] : '' ;
		$user_session = (isset($review_data['user_session'])) ? $review_data['user_session'] : false ;

		$review = new Review();
		$param = $request->request->get('review');
		$review_form = $this->createForm(ReviewType::class, $review, array('allow_extra_fields'=>true));
		$review_form->submit($param);


		// $review_form = $this->createForm(ReviewType::class, $review, array('allow_extra_fields'=>true));
		// $review_form->handleRequest($request);

		$message = '';
		$errors = '';
		$success = false;
		if ($review_form->isValid()) {
			//valid
			//$product = ProductQuery::create()->getPublicDataById($product_id)->findOne();
			$product = $em->getRepository(Product::class)
				->getPublicDataById($product_id)
				->getQuery()
				->getOneOrNullResult();
			if($product){
				$user_review = $em->getRepository(Review::class)->getReviewByMember(false,false,$product_id, $user->getId())->getQuery()->getOneOrNullResult();
				//$user_review = ReviewQuery::create()->getReviewByMember($product_id, $user->getId())->findOne();
				if($user_review){

					if(!$user_review->getContent() && $content){
						//user rating again with content
						$user_review->setRatingScore($rating);
						$user_review->setTitle($title);
						$user_review->setContent($content);
						$user_review->setUserSession($user_session);
						$user_review->setStatus(0);
						$user_review->setCreatedAt(date('Y-m-d H:i:s'));
						$em->persist($user_review);
						$em->flush($user_review);

						//set product review and rating
						//$application = new ApplicationController();
						$util->setProductRatingAndReview($product);

						//send email to approve
						$util->sendMailProductReview($request, $user_review, $product);
					}

				}else{
					//new user review
					$review->setProduct($product);
					$review->setUser($user);
					$review->setReviewerName($reviewer_name);
					$review->setReviewerEmail($email);
					$review->setIpAddress($client_ip);
					$review->setUserSession($user_session);

					if(!$content){
						//only rating no content, no approve
						$review->setStatus(1);
						$em->persist($review);
						$em->flush($review);

						//set product review and rating
						//$application = new ApplicationController();
						$util->setProductRatingAndReview($product);

					}else{
						$em->persist($review);
						$em->flush($review);
					}
					if($content){
						//send email to approve
						$util->sendMailProductReview($request, $review, $product);
					}
				}
			}
			$translator = $this->get('translator');
			$message_trans = $translator->trans('review.review_thankyou');

			$message = $first_name.' '.$last_name.' '.$message_trans;
			$success = true;
		}else{
			//invalid

			$errors = $util->getFormErrorMessage($review_form);
			//$errors = $form->getErrors(true);
			//dump((string) $review_form->getErrors());     // Main errors
			//dump((string) $review_form->getErrors(true)); // Main and child errors
		}

		return new JsonResponse([
			'review_data' => $review_data,
			'email' => $email,
			'message' => $message,
			'errors' => $errors,
			'user' => true,
			'success' => $success,
			'time' => date('Y/m/d H:i:s')
		]);
	}

	/**
		 * Post review data by non user
		 *
     * @ApiDoc(
		 *   resource = true,
     *   description = "Post review data by non user",
     * )
     *
	   *
	   * @param Request $request the request object
	   *
	   * @return FormTypeInterface|RouteRedirectView
	   *
	   * @throws NotFoundHttpException when user not exist
	   */
	public function postPublicCreateReviewsAction(Request $request)
  {
		$reviewer_name = 'anonymously';
		$client_ip = $request->getClientIp();

		$errors = '';
		$message = '';
		$success = false;



		$em = $this->container->get('doctrine')->getEntityManager();
		$util = $this->container->get('utilities');

		$review_data = $request->get('review');
		$rating = $review_data['ratingScore'];
		$product_id = $review_data['product_id'];
		$title = (isset($review_data['title'])) ? $review_data['title'] : '' ;
		$content = (isset($review_data['content'])) ? $review_data['content'] : false ;
		$user_session = (isset($review_data['user_session'])) ? $review_data['user_session'] : false ;

		$review = new Review();


		//$review_form->handleRequest($request);

		//validate content
		if(!$content){
      		$review_form->get('content')->addError(new FormError('Required field'));
    	}
		$param = $request->request->get('review');
		$review_form = $this->createForm(ReviewType::class, $review, array('allow_extra_fields'=>true));
		//print_r($param);
		$review_form->submit($param);
		//$review_form->handleRequest($param);


		if ($review_form->isValid()) {


			//$product = ProductQuery::create()->getPublicDataById($product_id)->findOne();
			$product = $em->getRepository(Product::class)
				->getPublicDataById($product_id)
				->getQuery()
				->getOneOrNullResult();
			// $product = $em->getRepository(Product::class)
			// 	->getActiveDataById($product_id, $request->getLocale())
			// 	->getQuery()
			// 	->getSingleResult();

			if($product){
				//validate user
				//$count_user_review = $em->getRepository(Review::class)->getReviewByAnonymously(false,false,$product_id, $user_session, $client_ip)->getQuery()-getResult();
				$count_user_review = $em->getRepository(Review::class)->getReviewByAnonymously(false,false,$product_id, $user_session, $client_ip)->getQuery()->getResult();
				if(count($count_user_review)<=0){
					//$review = new Review();
					$review->setProduct($product);
					$review->setReviewerName($reviewer_name);
					$review->setIpAddress($client_ip);
					$review->setUserSession($user_session);
					$em->persist($review);
					$em->flush($review);

					//send email to approve
					$util->sendMailProductReview($request, $review, $product);
				}
			}
			$translator = $this->get('translator');
			$message = $translator->trans('review.review_thankyou');

			//$message = 'ขอบคุณสำหรับรีวิวสินค้า <br/>การรีวิวของคุณจะได้รับการตรวจทานและอนุมัติภายใน 48 ชั่วโมงถัดไป';
			$success = true;
		}else{
			//invalid
			$errors = $util->getFormErrorMessage($review_form);

		}


		return new JsonResponse([
			'review_data' => $review_data,
			'message' => $message,
			'errors' => $errors,
			'user' => false,
			'success' => $success,
			'time' => date('Y/m/d H:i:s')
		]);
	}

	/**
   * List all review.
   *
	 * @ApiDoc(
   *  resource=true,
   *  description="List all review",
	 *   statusCodes = {
   *     200 = "Returned when successful"
   *   }
   * )
	 *
   * @Annotations\View()
   *
   * @param Request               $request      the request object
   *
   * @return array
   */
  public function getPublicReviewsAction(Request $request)
  {
		$arr_data = array();
		$product_id = $request->get('product_id');
		$list_per_page = $request->get('list_per_page');
        $max_per_page = ($list_per_page) ? $list_per_page : $this->container->getParameter('max_per_review') ;

		$em = $this->container->get('doctrine')->getEntityManager();
		$util = $this->container->get('utilities');
		$query = $em->getRepository(Review::class)->getAllReviewByProduct(false,false,$product_id)->getQuery();

		//$query = ReviewQuery::create()->getAllReviewByProduct($product_id);

		$paginated = $util->setPaginatedOnPagerfanta($query, $max_per_page);

		$count_review = $paginated->count();
		$nb_pages = $paginated->getNbPages();

		$currentPageResults = $paginated->getCurrentPageResults();
		foreach ($currentPageResults as $key => $data) {

			if($data->getUser()){
				$user = $data->getUser();
				$first_name = $user->getFirstName();
				$last_name = $user->getLastName();


				$reviewer_name = $util->showReviewerName($first_name,$last_name);
			}else{
				$reviewer_name = 'ผู้เยี่ยมชม';
			}

			// dump($data->getId());
			// exit;
			// 			if($data->getId()){
			// 				$arr_data[$key]['id'] = $data->getId();
			// 			}else{
			// 				$arr_data[$key]['id'] = " ";
			// 			}
			$arr_data[$key]['id'] = $data->getId();
			$arr_data[$key]['product_id'] = $data->getProduct()->getId();
			//$arr_data[$key]['user_id'] = $data->getUser()->getId();
			$arr_data[$key]['rating'] = $data->getRatingScore();
			$arr_data[$key]['title'] = $data->getTitle();
      		$arr_data[$key]['content'] = $data->getContent();
      		$arr_data[$key]['reviewer_name'] = $reviewer_name;
			$arr_data[$key]['created_at'] = $data->getCreatedAt()->format("Y-m-d");
			// dump($data->getContent());
			// exit;
		}
		// dump($arr_data);
		// exit;
    $response = new JsonResponse();
    $response->setData(array(
			'review_data'  => $arr_data,
			'count_review' => $count_review,
			'list_per_page' => $nb_pages,
			'time' => date('Y/m/d H:i:s'),
    ));
    $response->setSharedMaxAge(600);
    return $response;

  }
}
