<?php

namespace ProjectBundle\Form\Type\Product;

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

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

// use ProjectBundle\Entity\Brand;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class ProductSearchType extends AbstractType
{
    protected $request_stack;

    const SHOP_BY = array(
        'new_product'   => 'new',
        'sale_product'  => 'sale',
        'top_saller'    => 'top_saller'
    );

    public function __construct(RequestStack $request_stack)
    {
        $this->request_stack = $request_stack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $local = $this->request_stack->getCurrentRequest()->getLocale();
        $builder->add('searchBox', TextType::class, array(
            'required' => false,
        ));
        $builder->add('startprice', TextType::class, array(
            'required' => false,
            'attr' => array('class'=>'rd-range-input-value-1 form-control form-control-sm'),
        ));
        $builder->add('endprice', TextType::class, array(
            'required' => false,
            'attr' => array('class'=>'rd-range-input-value-2 form-control form-control-sm'),
        ));

        $builder->add('shop_by', ChoiceType::class, array(
            'choices'  => self::SHOP_BY,
            'expanded' => true,
            'multiple' => true,
            // 'choice_translation_domain' => false //not translate
        ));

        $builder->add('ddlPriceSort', ChoiceType::class, array(
            'required' => false,
            'attr' => array('class'=>'ddl-list form-input'),
            'choices' => array('product.default_sorting'=>'',
                        'product.price_low_to_high' => 'ASC',
                        'product.price_high_to_low' => 'DESC',
            ),
            'expanded'  => false,
            'multiple'  => false,
        ));

        $builder->add('ddlPriceSortMobile', ChoiceType::class, array(
            'required' => false,
            'label_attr' => [ 'class' => 'btn-default' ],
            'attr' => array('class'=>'form-input'),
            'choices' => array('product.default_sorting'=>'',
                        'product.price_low_to_high' => 'ASC',
                        'product.price_high_to_low' => 'DESC',
            ),
            'choice_attr' => function($choice, $key, $value) {
                // adds a class like attending_yes, attending_no, etc
                return ['class' => 'ddlPriceSortMobile'];
            },
            'expanded'  => true,
            'multiple'  => false,
        ));

        $builder->add('hashtag', NumberType::class, array(
            'required' => false,
        ));

        $builder->setMethod('GET');



        // $builder->add('age_groups', EntityType::class, array(
        //     // 'choice_attr' => function($choiceValue, $key, $value) {
        //     //     // adds a class like attending_yes, attending_no, etc
        //     //     return ['ng-model'=>'age'.".no-".$value];
        //     // },
        //     'label_attr' => array('class' => ''),
        //     'required' => false,
        //     // query choices from this entity
        //     'class' => AgeGroup::class,
        //     'query_builder' => function (EntityRepository $er) {
        //         return $er->findAllData();
        //     },
        //     // 'choice_attr' => function($choiceValue, $key, $value) {
        //     //     // adds a class like attending_yes, attending_no, etc
        //     //     // return ['class' => 'attending_'.strtolower($key)];
        //     //     return ['class' => 'find_job'];
        //     // },
        //     // use the  User.username property as the visible option string
        //     'choice_label' => 'translations['.$local.'].title',
        //     // used to render a select box, check boxes or radios
        //     'multiple' => true,
        //     'expanded' => true,
        // ));

        // $builder->add('brands', EntityType::class, array(
        //     // 'choice_attr' => function($choiceValue, $key, $value) {
        //     //     // adds a class like attending_yes, attending_no, etc
        //     //     return ['ng-model'=>'brands'.".no-".$value];
        //     // },
        //     'label_attr' => array('class' => ''),
        //     'required' => true,
        //     // query choices from this entity
        //     'class' => Brand::class,
        //     'query_builder' => function (EntityRepository $er) {
        //         return $er->findBrandAllActiveByProduct();
        //     },
        //     // use the User.username property as the visible option string
        //     'choice_label' => 'translations['.$local.'].title',
        //     // used to render a select box, check boxes or radios
        //     'multiple' => true,
        //     'expanded' => true,
        // ));

        // $builder->add('equipment', EntityType::class, array(
        //     // 'choice_attr' => function($choiceValue, $key, $value) {
        //     //     // adds a class like attending_yes, attending_no, etc
        //     //     return ['ng-model'=>'equipment'.".no-".$value];
        //     // },
        //     'required' => false,
        //     // query choices from this entity
        //     'class' => Equipment::class,
        //     'query_builder' => function (EntityRepository $er) {
        //         return $er->findAllData();
        //     },
        //     // use the User.username property as the visible option string
        //     'choice_label' => 'translations['.$local.'].title',
        //     // 'choice_label' => 'title',
        //     // used to render a select box, check boxes or radios
        //     'multiple' => true,
        //     'expanded' => true,
        // ));

        // $builder->add('power', EntityType::class, array(
        //     // 'choice_attr' => function($choiceValue, $key, $value) {
        //     //     // adds a class like attending_yes, attending_no, etc
        //     //     return ['ng-model'=>'power'.".no-".$value];
        //     // },
        //     'required' => false,
        //     // query choices from this entity
        //     'class' => Power::class,
        //     'query_builder' => function (EntityRepository $er) {
        //         return $er->findAllData();
        //     },
        //     // use the User.username property as the visible option string
        //     'choice_label' => 'translations['.$local.'].title',
        //     // 'choice_label' => 'title',
        //     // used to render a select box, check boxes or radios
        //     'multiple' => true,
        //     'expanded' => true,
        // ));

        // $builder->add('muscles', EntityType::class, array(
        //     // 'choice_attr' => function($choiceValue, $key, $value) {
        //     //     // adds a class like attending_yes, attending_no, etc
        //     //     return ['ng-model'=>'muscles'.".no-".$value];
        //     // },
        //     'label_attr' => array('class' => ''),
        //     'required' => true,
        //     // query choices from this entity
        //     'class' => Muscle::class,
        //     'query_builder' => function (EntityRepository $er) {
        //         return $er->findAllData();
        //     },
        //     'choice_attr' => function($choiceValue, $key, $value) {
        //         // adds a class like attending_yes, attending_no, etc
        //         // return ['class' => 'attending_'.strtolower($key)];
        //         return ['class' => 'muscle_check_item'];
        //     },
        //     // use the User.username property as the visible option string
        //     'choice_label' => 'translations['.$local.'].title',
        //     // 'choice_label' => 'title',
        //     // used to render a select box, check boxes or radios
        //     'multiple' => true,
        //     'expanded' => true,
        // ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

}
