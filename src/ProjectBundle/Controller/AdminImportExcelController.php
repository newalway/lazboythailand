<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectBundle\Entity\Pages;
use ProjectBundle\Entity\Product;
use ProjectBundle\Entity\ProductCategory;
use ProjectBundle\Entity\Showroom;
use ProjectBundle\Entity\ProductOption;
use ProjectBundle\Entity\Hashtag;
use ProjectBundle\Entity\ProductStyleNumber;
use ProjectBundle\Entity\ProductType;

use ProjectBundle\Form\Type\AdminImportExcelType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

use PhpOffice\PhpSpreadsheet\Shared\Date;

class AdminImportExcelController extends Controller
{
    const ROUTER_INDEX = 'admin_import_excel';
	const ROUTER_CONTROLLER = 'AdminImportExcel';

	/**
	 * @Secure(roles="ROLE_ADMIN")
	 */
	public function indexAction(Request $request)
	{
		$util = $this->container->get('utilities');
        $product_util = $this->container->get('app.product');
		$util->setCkAuthorized();
		$form = $this->createForm(AdminImportExcelType::class);
		$form->handleRequest($request);

		$em = $this->getDoctrine()->getManager();

		//$repository = $this->getDoctrine()->getRepository(Pages::class);
		if ($form->isSubmitted() && $form->isValid()) {
			$file = $form['file']->getData();
			$type = $file->getMimeType();
			$mime_type = $this->container->getParameter('source_path_spreadsheet_mime_type');

			$import_excel = $this->container->get('importexcel');
            $worksheet= false;
			if(in_array($type, $mime_type)){
				$worksheet = $import_excel->importExcelFile($file);
			}

            $web_path = $this->getParameter('web_path');
            $imagePathPrefix = '/uploads/userfiles';

            if($worksheet){
                // $worksheet->getCell('A2');
                foreach ($worksheet->getRowIterator() as $row)
                {
                	$row_number = $row->getRowIndex();
                	if($row_number==1){ // skip first row title
                		continue;
                    }

                    $product = new Product();
                    $inventory_policy_status = 0;
                    $imagePath = null;
                    $arr_tags_encode = null;
                    $arr_image_gallery_path = array();
                    $sku = null;
                    $sku_by_type_style_number = null;

                	$cellIterator = $row->getCellIterator();
                	$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
                	foreach ($cellIterator as $cell)
                    {
                		if (!is_null($cell)) {

                			if (!is_null($cell->getValue()) && $cell->getValue() != '') {
                            // if (!is_null($cell->getCalculatedValue()) && $cell->getCalculatedValue() != '') {

                				$cell_coordinate = $cell->getCoordinate();
                				$cell_column = str_replace($row_number, "", $cell_coordinate);
                				$cell_value = $cell->getValue();
                				// $cell_calculate_value = $cell->getCalculatedValue();

                				switch ($cell_column) {
                                    case 'A':
                                        $product->translate('en')->setTitle($cell_value);
                                        break;
                                    case 'B':
                                        $product->translate('th')->setTitle($cell_value);
                                        break;
                                    case 'C':
                                        $product->translate('en')->setShortDesc($cell_value);
                                        break;
                                    case 'D':
                                        $product->translate('th')->setShortDesc($cell_value);
                                        break;
                                    case 'E':
                                        $product->translate('en')->setDescription($cell_value);
                                        break;
                                    case 'F':
                                        $product->translate('th')->setDescription($cell_value);
                                        break;
                                    case 'G':
                                        $product->translate('en')->setResources($cell_value);
                                        break;
                                    case 'H':
                                        $product->translate('th')->setResources($cell_value);
                                        break;
                                    case 'I':
                                        if (preg_match("/^\/uploads\/userfiles/", $cell_value)){
                                            $imagePath = $cell_value;
                                        }else{
                                            $imagePath = $imagePathPrefix.$cell_value;
                                        }

                                        if($imagePath){
                                            if (file_exists($web_path.$imagePath)) {
                                                $product->setImage($imagePath);
                                            }else{
                                                $imagePath = null;
                                            }
                                        }
                                        break;
                                    case 'J':
                                        $product->setPrice($cell_value);
                                        break;
                                    case 'K':
                                        $product->setCompareAtPrice($cell_value);
                                        break;
                                    case 'L':
                                        $product->setSku($cell_value);
                                        $sku = $cell_value;
                                        break;
                                    case 'M':
                                        $inventory_policy_status = $cell_value;
                                        $product->setInventoryPolicyStatus($inventory_policy_status);
                                        break;
                                    case 'N':
                                        if ($inventory_policy_status > 0) {
                                            $product->setInventoryQuantity($cell_value);
                						}
                                        break;
                                    case 'O':
                                        $product->setWeight($cell_value);
                                        break;
                                    case 'P':
                                        $product->setWeightUnit($cell_value);
                                        break;
                                    case 'Q':
                                        $product->setStatus($cell_value);
                                        break;
                                    case 'R':
                    					if(is_numeric($cell_value)){
                    						$publish_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cell_value);
                    					}else{
                    						$publish_date = new \DateTime();
                    					}
                                        $product->setPublishDate($publish_date);
                                        // $str_date = $publish_date->format('Y-m-d H:i:s');
                                        // if( \PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell) ){
                                        //     $cell->getWorksheet()->getStyle($cell->getCoordinate())->getNumberFormat()->getFormatCode();
                                        // }
                                        break;
                                    case 'S':
                                        $product->setIsOnlineShopping($cell_value);
                                        break;
                                    case 'T':
                                        $product->setIsNew($cell_value);
                                        break;
                                    case 'U':
                                        $product->setIsSale($cell_value);
                                        break;
                                    case 'V':
                                        $product->setIsImported($cell_value);
                                        break;
                                    case 'W':
                                        $product->setIsTopSeller($cell_value);
                                        break;
                                    case 'X':
                                        $product->setDimBodyDepth($cell_value);
                                        break;
                                    case 'Y':
                                        $product->setDimBodyHeight($cell_value);
                                        break;
                                    case 'Z':
                                        $product->setDimBodyWidth($cell_value);
                                        break;
                                    case 'AA':
                                        $product->setDimSeatDepth($cell_value);
                                        break;
                                    case 'AB':
                                        $product->setDimSeatHeight($cell_value);
                                        break;
                                    case 'AC':
                                        $product->setDimSeatWidth($cell_value);
                                        break;
                                    case 'AD':
                                        $product->setDimFullExtension($cell_value);
                                        break;

                                    case 'AE':
                                        $product_cate_ids = array_map('trim', explode(',', $cell_value));
                                        if(sizeof($product_cate_ids)){
                                            $product_cat_repo = $em->getRepository(ProductCategory::class);
                                            foreach ($product_cate_ids as $product_cate_id) {
                                                $product_category = $product_cat_repo->find($product_cate_id);
                                                if($product_category){
                                                    $product->addProductCategories($product_category);
                                                }
                                            }
                                        }
                                        break;
                                    case 'AF':
                                        $gallery_ids = array_map('trim', explode(',', $cell_value));
                                        if(sizeof($gallery_ids)){
                                            $showroom_repo = $em->getRepository(Showroom::class);
                                            foreach ($gallery_ids as $gallery_id) {
                                                $showroom = $showroom_repo->find($gallery_id);
                                                if($showroom){
                                                    $product->addShowrooms($showroom);
                                                }
                                            }
                                        }
                                        break;
                                    case 'AG':
                                        $product_option_ids = array_map('trim', explode(',', $cell_value));
                                        if(sizeof($product_option_ids)){
                                            $product_option_repo = $em->getRepository(ProductOption::class);
                                            foreach ($product_option_ids as $product_option_id) {
                                                $product_option = $product_option_repo->find($product_option_id);
                                                if($product_option){
                                                    $product->addProductOptions($product_option);
                                                }
                                            }
                                        }
                                        break;

                                    case 'AH':
                                        $product_type_title = $cell_value;
                                        $product_type = $em->getRepository(ProductType::class)->findOneByTitle($product_type_title);
                                        if(!$product_type) {
                                            $product_type = new ProductType();
                                            $product_type->setTitle($product_type_title);
                                            $em->persist($product_type);
                                        }
                                        $product->setProductType($product_type);
                                        $sku_by_type_style_number = $product_type_title;
                                        break;

                                    case 'AI':
                                        $product_style_number_title = $cell_value;
                                        $product_style_number = $em->getRepository(ProductStyleNumber::class)->findOneByTitle($product_style_number_title);
                                        if(!$product_style_number) {
                                            $product_style_number = new ProductStyleNumber();
                                            $product_style_number->setTitle($product_style_number_title);
                                            $em->persist($product_style_number);
                                        }
                                        $product->setProductStyleNumber($product_style_number);
                                        if($sku_by_type_style_number){
                                            $sku_by_type_style_number = $sku_by_type_style_number.'-'.$product_style_number_title;
                                        }else{
                                            $sku_by_type_style_number = $product_style_number_title;
                                        }
                                        break;

                                    case 'AJ':
                                        $tags = array_map('trim', explode(',', $cell_value));
                                        if(sizeof($tags)){
                                            $tags_encode = json_encode($tags);
                                            $arr_tags_encode = array('tags' => $tags_encode);
                                        }
                                        break;
                                    case 'AK':
                                        $arr_tmp_image_gallery = array_map('trim', explode(',', $cell_value));
                                        if(sizeof($arr_tmp_image_gallery)){
                                            $tmp_image_gallery_path = null;
                                            foreach ($arr_tmp_image_gallery as $img_gallery_key => $image_gallery_path) {
                                                if (preg_match("/^\/uploads\/userfiles/", $image_gallery_path)){
                                                    $tmp_image_gallery_path = $image_gallery_path;
                                                }else{
                                                    $tmp_image_gallery_path = $imagePathPrefix.$image_gallery_path;
                                                }
                                                if (file_exists($web_path.$tmp_image_gallery_path)) {
                                                    $arr_image_gallery_path[$img_gallery_key] = $tmp_image_gallery_path;
                                                }
                                            }
                                        }
                                        break;
                			  	}
                			}
                		}
                	}//end foreach cellIterator

                    // set sku by style_number
                    if($sku==null && $sku_by_type_style_number){
                        $product->setSku($sku_by_type_style_number);
                    }

                    $em->persist($product);
                    $product->mergeNewTranslations();
                    $em->flush();

                    if($imagePath){
                        //save product image size s,m,l
                        $product_util->saveProductImageSize($product, null);
                    }
                    if($arr_tags_encode){
                        //tags
                        $product_util->saveProductHashtags($product, $arr_tags_encode);
                    }
                    if(sizeof($arr_image_gallery_path)){
                        //save image_gallery
            			$product_util->saveProductImageGallery($product, $arr_image_gallery_path);
                    }

                }//end foreach rowIterator

				$this->get('session')->getFlashBag()->add('notice', 'Data Import successfull.');
				$util->setBackToUrl();

            //end worksheet
            }else{
                $this->get('session')->getFlashBag()->add('error', 'Apcept file .xls or excel format only!!');
				$util->setBackToUrl();
            }

            $redirect_uri = $this->generateUrl('admin_import_excel');
			return $this->redirect($redirect_uri);
		}

    	$util->setBackToUrl();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':import.html.twig', array(
			'form' =>$form->createView(),
		));
	}


    public function downloadSampleSpreadsheetAction()
    {
        $pdfPath = $this->getParameter('dir.downloads').'/import_products.xlsx';
        return $this->file($pdfPath);
    }

}
