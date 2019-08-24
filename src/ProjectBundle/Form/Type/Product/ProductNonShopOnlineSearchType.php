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

use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class ProductNonShopOnlineSearchType extends ProductSearchType
{
    protected $request_stack;

    public function __construct(RequestStack $request_stack)
    {
        $this->request_stack = $request_stack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('ddlPriceSort', ChoiceType::class, array(
            'required' => false,
            'attr' => array('class'=>'ddl-list form-input'),
            'choices' => array('product.default_sorting'=>'',
                        'product.default_sorting_high_to_low' => 'TYPE_DESC',
            ),
            'expanded'  => false,
            'multiple'  => false,
        ));

        $builder->add('ddlPriceSortMobile', ChoiceType::class, array(
            'required' => false,
            'label_attr' => [ 'class' => 'btn-default' ],
            'attr' => array('class'=>'form-input'),
            'choices' => array('product.default_sorting'=>'',
                        'product.default_sorting_high_to_low' => 'TYPE_DESC',
            ),
            'choice_attr' => function($choice, $key, $value) {
                // adds a class like attending_yes, attending_no, etc
                return ['class' => 'ddlPriceSortMobile'];
            },
            'expanded'  => true,
            'multiple'  => false,
        ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'product_search';
    }

}
