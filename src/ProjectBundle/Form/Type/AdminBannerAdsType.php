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

use ProjectBundle\Entity\BannerAds;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminBannerAdsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Fixed id
        // id 5 is Product Top Ad
        // id 13 is Shop Online Top Ad
        $obj_data = $options['data'];
        $id = $obj_data->getId();
        if(($id==5) || ($id==13)){
            $builder->add('translations', 'A2lix\TranslationFormBundle\Form\Type\TranslationsType', array(
                'fields' => array(
                    'website' => array(
                        'field_type' => TextType::class,
                        'label' => 'Website',
                        'locale_options' => array()
                    ),
                    // 'exclude_fields' => array('caption_title', 'caption_description')
                )
            ));
        }else{
            $builder->add('translations', 'A2lix\TranslationFormBundle\Form\Type\TranslationsType', array(
                'fields' => array(
                    'website' => array(
                        'field_type' => TextType::class,
                        'label' => 'Website',
                        'locale_options' => array()
                    ),
                    'captionTitle' => array('display' => false),
                    'captionDescription' => array('display' => false),
                ),
            ));
        }

        $builder->add('image', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
                        'constraints' => array(
                            new NotBlank(array('message' => 'Enter a image')))
        ));

        $builder->add('image_mobile', TextType::class, array(
                        'attr' => array('class' => 'form-control'),
                        'required' => false,
        ));

        $builder->add('save_and_add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save_and_edit', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
        $builder->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')));
    }

}
