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

use ProjectBundle\Entity\NewsCategory;
use ProjectBundle\Entity\News;
use ProjectBundle\Entity\NewsImage;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class AdminNewsType extends AbstractType
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

        $builder->add('newsCategory', EntityType::class, array(
           'attr'=>array('class' => 'form-control'),
           'label_attr' => array('class' => ''),
           'required' => true,
           // query choices from this entity
           'class' => NewsCategory::class,
           'query_builder' => function (EntityRepository $er) {
               $news_category_root_id = $this->container->getParameter('news_category_root_id');
               return $er->findDataByRootId($news_category_root_id);
           },
           // use the User.username property as the visible option string
           'choice_label' => function ($news_category) {
               return $news_category->getTitle();
           },
           // 'choice_label' => 'translations['.$local.'].title',
           'choice_attr' => function($choiceValue, $key, $value) {
               return ['class' => 'level_'.$choiceValue->getLvl()];
           },
           // used to render a select box, check boxes or radios
           'multiple' => false,
           'expanded' => false,
       ));

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

        $builder->add('embed', TextareaType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('public_date', DateType::class, array(
                        'required' => true,
                        'input'  => 'datetime',
                        'widget' => 'single_text',
                        'attr' => array('class' => 'form-control-static'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a publish date')))
        ));

        $builder->add('isHighlight', CheckboxType::class, array(
            'label'    => 'Top PR News',
            'required' => false,
        ));

        $builder->add('author', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('status', ChoiceType::class, array(
                        'choices' => array('Publish' => '1', 'Unpublish' => '0'),
                        'expanded' => true,
                        'multiple' => false,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a status')))
        ));

        $builder->add('save_and_add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save_and_edit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\News'
        ));
    }

}
