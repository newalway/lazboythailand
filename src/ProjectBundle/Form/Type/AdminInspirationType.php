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

use ProjectBundle\Entity\Inspiration;
use ProjectBundle\Entity\InspirationCategory;
use ProjectBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class AdminInspirationType extends AbstractType
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
                    'locale_options' => array(
                        //'th' => array('label' => 'ไทย')
                        //'th' => array('display' => false)
                    ),
                    'attr' => array('class' => 'form-control'),
                    'constraints' => array(
                        new NotBlank(array('message' => 'Please enter title')))
                ),
                'shortDesc' => array(
                    'field_type' => TextareaType::class,
                    'label' => 'Short Description',
                    'locale_options' => array(
                        //'th' => array('label' => 'ไทย')
                        //'th' => array('display' => false)
                    ),
                    'attr' => array('class' => 'form-control'),
                ),
                'description' => array(
                    'field_type' => CKEditorType::class,
                    'label' => 'Content',
                    'locale_options' => array(
                        //'th' => array('label' => 'ไทย')
                        //'th' => array('display' => false)
                    )
                )
            ),
            'label_attr'=>array('class'=>'hide')
            //'exclude_fields' => array('details')
        ));

        $builder->add('image', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('products', EntityType::class, array(
            'attr'=>array('class'=>''),
            'label_attr' => array('class' => ''),
            'required' => false,
            // query choices from this entity
            'class' => Product::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->findAllData();
            },
            'choice_attr' => function($choiceValue, $key, $value) {
                // adds a class like attending_yes, attending_no, etc
                // return ['class' => 'attending_'.strtolower($key)];
                return ['class' => 'product_check_item'];
            },
            // use the User.username property as the visible option string
            'choice_label' => 'translations['.$local.'].title',
            // 'choice_label' => 'title',
            // used to render a select box, check boxes or radios
            'multiple' => true,
            'expanded' => true, //false for select multiple
            'label_attr' => array('class' => 'checkbox-inline'),
        ));

        $builder->add('inspirationCategory', EntityType::class, array(
           'attr'=>array('class' => 'form-control'),
           'label_attr' => array('class' => ''),
           'required' => true,
           // query choices from this entity
           'class' => InspirationCategory::class,
           'query_builder' => function (EntityRepository $er) {
               $category_root_id = $this->container->getParameter('inspiration_category_root_id');
               return $er->findDataByRootId($category_root_id);
           },
           // use the User.username property as the visible option string
           'choice_label' => function ($inspiration_category) {
               return $inspiration_category->getTitle();
           },
           // 'choice_label' => 'translations['.$local.'].title',
           'choice_attr' => function($choiceValue, $key, $value) {
               return ['class' => 'level_'.$choiceValue->getLvl()];
           },
           // used to render a select box, check boxes or radios
           'multiple' => false,
           'expanded' => false,
       ));

        $builder->add('isHighlight', CheckboxType::class, array(
            'label'    => 'Top page',
            'required' => false,
        ));

        $builder->add('status', ChoiceType::class, array(
                        'choices' => array('Publish' => '1', 'Unpublish' => '0'),
                        'expanded' => true,
                        'multiple' => false,
                        'label_attr' => array('class' => 'radio-inline'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a status')))
        ));

        $builder->add('save_and_add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary margin-bottom-10')));
        $builder->add('save_and_edit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary margin-bottom-10')));
        $builder->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary margin-bottom-10')));
    }

}
