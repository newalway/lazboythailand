<?php

namespace ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RequestStack;

use ProjectBundle\Entity\ProductCategory;
use ProjectBundle\Entity\ProductType;
use ProjectBundle\Entity\ProductStyleNumber;

use ProjectBundle\Entity\Showroom;
use ProjectBundle\Entity\ProductOption;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;


class AdminProductType extends AbstractType
{
    private $kernel;
    protected $container;
    protected $request_stack;

    public function __construct($kernel, RequestStack $request_stack)
    {
        $this->request_stack = $request_stack;
        $this->container = $kernel->getContainer();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $local = $this->request_stack->getCurrentRequest()->getLocale();

        $builder->add('status', ChoiceType::class, array(
                        'choices' => array('Available' => '1', 'Unavailable' => '0'),
                        'expanded' => true,
                        'multiple' => false,
                        // 'label_attr' => array('class' => 'radio-inline'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a status')))
        ));

        $builder->add('publishDate', DateTimeType::class, array(
                        'required' => true,
                        'input'  => 'datetime',
                        'widget' => 'single_text',
                        'format' => 'YYYY-MM-dd HH:mm',
                        'attr' => array('class' => 'form-control-static'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a publish date')))
        ));

        $builder->add('translations', 'A2lix\TranslationFormBundle\Form\Type\TranslationsType', array(
            'fields' => array(
                'title' => array(
                    'field_type' => TextType::class,
                    'label' => '* Title',
                    'locale_options' => array(
                        // 'en' => array('required' => true),
                        // 'th' => array('required' => true)
                    ),
                    'constraints' => array(
                        new NotBlank(array('message' => 'Please enter title')))
                ),
                'shortDesc' => array(
                    'field_type' => TextareaType::class,
                    'label' => 'Short Description',
                    'locale_options' => array()
                ),
                'description' => array(
                    'field_type' => CKEditorType::class,
                    'label' => 'Description',
                    'locale_options' => array()
                ),
                'resources' => array(
                    'field_type' => CKEditorType::class,
                    'label' => 'Resources',
                    'locale_options' => array()
                )
            ),
            //'required_locales' => ['en','th'],
            //'exclude_fields' => array('description')
        ));

        $builder->add('price', MoneyType::class, array(
                        'attr'      => array('ng-model'=> 'glob_price', 'class'=>''),
                        'currency'  => '',
                        'scale'     => 2,
                        'required'  => true,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Please enter price')))
        ));

        $builder->add('compareAtPrice', MoneyType::class, array(
                        'attr'      => array('ng-model'=> 'glob_compare_at_price', 'class'=>''),
                        'currency'  => '',
                        'scale'     => 2,
                        'required'  => false,
        ));

        $builder->add('sku', TextType::class, array(
                        'attr'      => array('ng-model'=> 'glob_sku', 'class' => ''),
                        'required'  => false,
        ));

        $builder->add('inventoryPolicyStatus', ChoiceType::class, array(
                        'attr'      => array('ng-model'=> 'glob_inventory_policy_status'),
                        // 'attr'      => array('ng-model'=> 'glob_inventory_policy_status', 'ng-change' => 'changedInventoryPolicyStatus(glob_inventory_policy_status)'),
                        'choices'   => array("Don't track inventory" => '0', "Tracks this product's inventory" => '1'),
                        'expanded'  => false,
                        'multiple'  => false,
                        'required'  => true,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a inventory policy status')))
        ));

        $builder->add('inventoryQuantity', NumberType::class, array(
                        'attr'      => array('ng-model'=> 'glob_inventory_quantity', 'class' => ''),
                        'required'  => false,
        ));

        // $builder->add('inventoryQuantity', HiddenType::class, array(
        //                 'mapped' => false
        // ));

        $builder->add('weight', NumberType::class, array(
                        'attr'      => array('class' => 'form-control-static'),
                        'required'  => false,
        ));

        $builder->add('weightUnit', ChoiceType::class, array(
                        'attr'      => array(),
                        'choices'   => array("kg" => 'kg', "lb" => 'lb', "g" => 'g'),
                        'expanded'  => false,
                        'multiple'  => false,
                        'required'  => true
        ));

        // $builder->add('image', TextType::class, array(
        //                 'attr'      => array('class' => ''),
        //                 'required'  => false,
        // ));

        $builder->add('image', HiddenType::class, array(
                        'required'  => false,
        ));

        $builder->add('productCategories', EntityType::class, array(
            'attr'=>array('class'=>''),
            'required' => false,
            // query choices from this entity
            'class' => ProductCategory::class,
            'query_builder' => function (EntityRepository $er) {
              $product_category_root_id = $this->container->getParameter('product_category_root_id');
              return $er->findDataByRootId($product_category_root_id);
            },
            'choice_attr' => function($choiceValue, $key, $value) {
                // adds a class like attending_yes, attending_no, etc
                // return ['class' => 'attending_'.strtolower($key)];
                return ['class' => 'level_'.$choiceValue->getLvl()];
            },
            // use the User.username property as the visible option string
            'choice_label' => function ($product_category) {
                return $product_category->getTitle();
            },
            // 'choice_label' => 'translations['.$local.'].title',
            // 'choice_label' => 'title',
            // used to render a select box, check boxes or radios
            'multiple' => true,
            'expanded' => true, //false for select multiple
        ));

        // // productCategory one to many
        // $builder->add('productCategory', EntityType::class, array(
        //     'attr'=>array('class' => ''),
        //     'label_attr' => array('class' => ''),
        //     'required' => true,
        //     // query choices from this entity
        //     'class' => ProductCategory::class,
        //     'query_builder' => function (EntityRepository $er) {
        //         $product_category_root_id = $this->container->getParameter('product_category_root_id');
        //         return $er->findDataByRootId($product_category_root_id);
        //     },
        //     // use the User.username property as the visible option string
        //     'choice_label' => function ($product_category) {
        //         return $product_category->getTitle();
        //     },
        //     'choice_attr' => function($choiceValue, $key, $value) {
        //         return ['class' => 'level_'.$choiceValue->getLvl()];
        //     },
        //     // used to render a select box, check boxes or radios
        //     'multiple' => false,
        //     'expanded' => false,
        // ));

        $builder->add('showrooms', EntityType::class, array(
            'attr'=>array('class'=>''),
            'label_attr' => array('class' => ''),
            'required' => false,
            // query choices from this entity
            'class' => Showroom::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->findAllData();
            },
            'choice_attr' => function($choiceValue, $key, $value) {
                // adds a class like attending_yes, attending_no, etc
                // return ['class' => 'attending_'.strtolower($key)];
                return ['class' => 'showroom_check_item'];
            },
            // use the User.username property as the visible option string
            'choice_label' => 'translations['.$local.'].title',
            // 'choice_label' => 'title',
            // used to render a select box, check boxes or radios
            'multiple' => true,
            'expanded' => true, //false for select multiple
        ));

        $builder->add('productOptions', EntityType::class, array(
            'attr'=>array('class'=>''),
            'label_attr' => array('class' => 'checkbox-inline'),
            'required' => false,
            // query choices from this entity
            'class' => ProductOption::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->findAllActiveData();
            },
            'choice_attr' => function($choiceValue, $key, $value) {
                // adds a class like attending_yes, attending_no, etc
                // return ['class' => 'attending_'.strtolower($key)];
                return [
                    'class' => 'product_option_check_item',
                ];
            },
            'group_by' => function($choiceValue, $key, $value) {
                return ($choiceValue->getProductOptionCategory()->getTitle());
            },
            // use the User.username property as the visible option string
            'choice_label' => function ($choiceValue) {
                $option_category = $choiceValue->getProductOptionCategory();
                $price = $choiceValue->getPrice();
                $str_price = '';
                if($price || $price>0){
                    $str_price = ' (+'.$price.')' ;
                }

                return (
                    $choiceValue->getTitle().$str_price.'%&%'.
                    $choiceValue->getImage().'%&%'.
                    $option_category->getTitle().'%&%'.
                    $option_category->getImage().'%&%'.
                    $choiceValue->getDefaultOption()
                );
            },
            // 'choice_label' => 'translations['.$local.'].title',
            // 'choice_label' => 'title',
            // used to render a select box, check boxes or radios
            'multiple' => true,
            'expanded' => true, //false for select multiple
            'block_name' => 'custom_product_option',
        ));

        $builder->add('productType', EntityType::class, array(
            'attr'=>array('class'=>'', 'ng-model'=> 'product_type', 'ng-change' => 'setSkuData()'),
            'label_attr' => array('class' => ''),
            'required' => true,
            'class' => ProductType::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->findAllData();
            },
            'choice_label' => 'title',
            'multiple' => false,
            'expanded' => false, //false for select multiple
        ));
        $builder->add('productStyleNumber', EntityType::class, array(
            'attr'=>array('class'=>'', 'ng-model'=> 'product_style_number', 'ng-change' => 'setSkuData()'),
            'label_attr' => array('class' => ''),
            'required' => true,
            'class' => ProductStyleNumber::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->findAllData();
            },
            'choice_label' => 'title',
            'multiple' => false,
            'expanded' => false, //false for select multiple
        ));

        $builder->add('isOnlineShopping', CheckboxType::class, array(
            'label'    => 'Online Shopping',
            'required' => false,
        ));

        $builder->add('isNew', CheckboxType::class, array(
            'label'    => 'Show a New icon on the site',
            'required' => false,
        ));

        $builder->add('isSale', CheckboxType::class, array(
            'label'    => 'Show a Sale icon on the site',
            'required' => false,
        ));

        $builder->add('isTopSeller', CheckboxType::class, array(
            'label'    => 'Show a Top Seller on the home page',
            'required' => false,
        ));

        $builder->add('isImported', CheckboxType::class, array(
            'label'    => 'Show a Imported icon on the site',
            'required' => false,
        ));

        $builder->add('dimBodyDepth', NumberType::class, array(
            'attr'      => array('class' => ''),
            'required'  => false,
        ));
        $builder->add('dimBodyHeight', NumberType::class, array(
            'attr'      => array('class' => ''),
            'required'  => false,
        ));
        $builder->add('dimBodyWidth', NumberType::class, array(
            'attr'      => array('class' => ''),
            'required'  => false,
        ));
        $builder->add('dimSeatDepth', NumberType::class, array(
            'attr'      => array('class' => ''),
            'required'  => false,
        ));
        $builder->add('dimSeatHeight', NumberType::class, array(
            'attr'      => array('class' => ''),
            'required'  => false,
        ));
        $builder->add('dimSeatWidth', NumberType::class, array(
            'attr'      => array('class' => ''),
            'required'  => false,
        ));
        $builder->add('dimFullExtension', NumberType::class, array(
            'attr'      => array('class' => ''),
            'required'  => false,
        ));


        $builder->add('imageDimension', HiddenType::class, array(
                        'required'  => false,
        ));




        $builder->add('save_and_add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save_and_edit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }

}
