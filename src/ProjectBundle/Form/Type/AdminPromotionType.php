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

use ProjectBundle\Entity\BrandType;
use ProjectBundle\Entity\Showroom;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class AdminPromotionType extends AbstractType
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

        $builder->add('translations', 'A2lix\TranslationFormBundle\Form\Type\TranslationsType', array(
            'fields' => array(
                'title' => array(
                    'field_type' => TextType::class,
                    'label' => '* Title',
                    'locale_options' => array(),
                    'constraints' => array(
                        new NotBlank(array('message' => 'Please enter title')))
                ),
                'image' => array(
                    'field_type' => TextType::class,
                    'label' => 'Image (Size: 1000x620 px )',
                    'locale_options' => array(),
                    'attr' => array('class' => 'image-input-group')
                ),
                'shortDesc' => array(
                    'field_type' => TextareaType::class,
                    'label' => 'Short Desc.',
                    'locale_options' => array()
                ),
                'description' => array(
                    'field_type' => CKEditorType::class,
                    'label' => 'Description',
                    'locale_options' => array(),
                ),
            )
        ));
        // $builder->add('title', TextType::class, array(
        //                 'attr' => array('class'=>'form-control'),
        //                 'required' => false,
        //                 'constraints' => array(
        //                     new NotBlank(array('message' => 'Please enter title')))
        // ));
        //
        // $builder->add('image', TextType::class, array(
        //                 'attr' => array('class' => 'form-control'),
        //                 'required' => false,
        // ));
        //
        // $builder->add('short_desc', TextareaType::class, array(
        //                 'attr' => array('class'=>'form-control'),
        //                 'required' => false
        // ));
        //
        // $builder->add('description', CKEditorType::class, array(
        //                 'attr' => array('class'=>'form-control'),
        //                 'required' => false
        // ));

        $builder->add('filepath', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('startDate', DateType::class, array(
                        'required' => true,
                        'input'  => 'datetime',
                        'widget' => 'single_text',
                        'format' => 'YYYY-MM-dd',
                        'attr' => array('class' => 'form-control-static'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a publish date')))
        ));

        $builder->add('isEndDate', CheckboxType::class, array(
                        'label'    => 'Set end date',
                        'required' => false,
        ));

        $builder->add('endDate', DateType::class, array(
                        'required' => false,
                        'input'  => 'datetime',
                        'widget' => 'single_text',
                        'format' => 'YYYY-MM-dd',
                        'attr' => array('class' => 'form-control-static')
        ));

        $builder->add('status', ChoiceType::class, array(
                        'choices' => array('Publish' => '1', 'Unpublish' => '0'),
                        'expanded' => true,
                        'multiple' => false,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a status')))
        ));

        $builder->add('statusCustomShow', ChoiceType::class, array(
                        'choices' => array('Show' => '1', 'Not Show' => '0'),
                        'expanded' => true,
                        'multiple' => false,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a status')))
        ));

        $builder->add('showrooms', EntityType::class, array(
            'attr'=>array('class'=>''),
            'label_attr' => array('class' => 'checkbox'),
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

        $builder->add('save_and_add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save_and_edit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }

}
