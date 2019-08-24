<?php

namespace ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ReviewType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

      $builder->add('ratingScore', NumberType::class, array(
                  //'mapped' => false,
                  'attr' => array('class' => 'form-control dark'),
                  'required' => false,
                  'constraints' => array(
                    new NotBlank(array('message' => 'Required field')),
                  )
      ));

      $builder->add('title', TextType::class, array(
                    'attr' => array(
                      'class'=>'form-control dark',
                      'ng-model'=>'formDataReview.title'
                    ),
                    'required' => false,
                    /*
                    'constraints' => array(
                      new NotBlank(array('message' => 'Enter a review title')),
                    )
                    */
      ));

      $builder->add('content', TextareaType::class, array(
                    'attr' => array(
                      'class'=>'form-control dark',
                      'rows'=> 5,
                      'ng-model'=>'formDataReview.content'
                    ),
                    'required' => false,
                    /*
                    'constraints' => array(
                      new NotBlank(array('message' => 'Required field')),
                    )
                    */
      ));

      $builder->add('save', SubmitType::class, array(
                    'attr' => array(
                      'class'=>'button button-primary',
                      'ng-disabled'=>'getItemRating()<=0'
                    )
      ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\Review'
        ));
    }

}
