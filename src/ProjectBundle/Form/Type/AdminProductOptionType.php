<?php

namespace ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use ProjectBundle\Entity\ProductOptionCategory;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class AdminProductOptionType extends AbstractType
{
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

        // print_r($options['data']);

        $builder->add('translations', 'A2lix\TranslationFormBundle\Form\Type\TranslationsType', array(
            'fields' => array(
                'title' => array(
                    'field_type' => TextType::class,
                    'label' => '* Title',
                    'locale_options' => array(),
                    'constraints' => array(
                        new NotBlank(array('message' => 'Please enter title')))
                ),
                'shortDesc' => array(
                    'field_type' => TextareaType::class,
                    'label' => 'Short desc',
                    'locale_options' => array()
                ),
            )
        ));

        $builder->add('image', HiddenType::class, array(
            'required'  => false,
        ));

        $builder->add('productOptionCategory', EntityType::class, array(
            'attr'=>array('class'=>''),
            'label_attr' => array('class' => ''),
            'required' => true,
            // query choices from this entity
            'class' => ProductOptionCategory::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->findAllData();
            },
            'choice_attr' => function($choiceValue, $key, $value) {
                // adds a class like attending_yes, attending_no, etc
                return ['class' => 'template_customer_group_item'];
                // return ['class' => 'attending_'.strtolower($key)];
                // return ['class' => 'level_'.$choiceValue->getLvl()];
            },
            // use the User.username property as the visible option string
            'choice_label' => 'translations['.$local.'].title',
            // 'choice_label' => 'title',
            // used to render a select box, check boxes or radios
            'multiple' => false,
            'expanded' => false, //false for select multiple
        ));

        // $builder->add('discountCode', TextType::class, array(
        //                 'attr' => array('class'=>'form-control'),
        //                 'required' => false,
        //                 'constraints' => array(
        //                     new NotBlank(array('message' => 'Please enter discount_code')))
        // ));

        // $cons_discount_type = $this->container->getParameter('cons_discount_type');
        // $builder->add('discountType', ChoiceType::class, array(
        //                 'choices' => $cons_discount_type,
        //                 'expanded' => false,
        //                 'multiple' => false,
        //                 'constraints' => array(
        //                     new NotBlank(array('message' => 'Enter a Discount type')))
        // ));

        // $builder->add('discountValue', NumberType::class, array(
        //                 'attr'      => array('class'=>'form-control'),
        //                 'required'  => true,
        //                 'constraints' => array(
        //                     new NotBlank(array('message' => 'Please enter value')))
        // ));
        //
        // $builder->add('onlyAppliesOnceItemPerProduct', CheckboxType::class, array(
        //                 'label'    => 'Only apply discount once item per product',
        //                 'required' => false,
        // ));

        /*

        $builder->add('image', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));
        */

        $builder->add('defaultOption', CheckboxType::class, array(
                        'label'    => 'Set as Default Option',
                        'required' => false,
        ));

        $builder->add('status', ChoiceType::class, array(
                        'choices' => array('Publish' => '1', 'Unpublish' => '0'),
                        'expanded' => true,
                        'multiple' => false,
                        'attr' => array('class' => 'form-control-static'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a status')))
        ));

        $builder->add('price', MoneyType::class, array(
                        'attr'      => array('class'=>''),
                        'currency'  => '',
                        'scale'     => 2,
                        'required'  => false,
        ));

        $builder->add('save_and_add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save_and_edit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\ProductOption'
        ));
    }

}
