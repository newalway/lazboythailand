<?php

namespace ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use ProjectBundle\Entity\Zone;
use ProjectBundle\Entity\DistributorCategory;

use Doctrine\ORM\EntityRepository;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class AdminDistributorType extends AbstractType
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

        $builder->add('translations', 'A2lix\TranslationFormBundle\Form\Type\TranslationsType', array(
            'fields' => array(
                'title' => array(
                    'field_type' => TextType::class,
                    'label' => '* Title',
                    'locale_options' => array(),
                    'constraints' => array(
                        new NotBlank(array('message' => 'Please enter title')))
                ),
                'description' => array(
                    'field_type' => CKEditorType::class,
                    'label' => 'Description',
                    'locale_options' => array(),
                    'display' => false
                ),
                'address' => array(
                    'field_type' => TextType::class,
                    'label' => 'Address/ Branch / Area',
                    'locale_options' => array()
                ),
                'province' => array(
                    'field_type' => TextType::class,
                    'label' => 'province',
                    'locale_options' => array()
                ),




            ),
            //'exclude_fields' => array('description')
        ));

        $builder->add('phone', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('fax', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('mobile', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('email', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('website', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('latitude', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Please enter latitude')))
        ));

        $builder->add('image', HiddenType::class, array(
                        'required'  => false,
        ));

        $builder->add('longitude', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Please enter latitude')))
        ));

        $builder->add('placeId', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false
        ));

        $builder->add('status', ChoiceType::class, array(
                        'choices' => array('Publish' => '1', 'Unpublish' => '0'),
                        'expanded' => true,
                        'multiple' => false,
                        'label_attr' => array('class' => 'radio-inline'),
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a status')))
        ));

        $builder->add('zone', EntityType::class, array(
            'attr'=>array('class'=>''),
            'label_attr' => array('class' => ''),
            'required' => true,
            // query choices from this entity
            'class' => Zone::class,
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

        $builder->add('distributorCategory', EntityType::class, array(
            'attr'=>array('class'=>''),
            'label_attr' => array('class' => ''),
            'required' => true,
            // query choices from this entity
            'class' => DistributorCategory::class,
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

        $builder->add('save_and_add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save_and_edit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\Distributor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'projectbundle_distributor';
    }


}
