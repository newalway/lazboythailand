<?php
namespace ProjectBundle\Form\Type\Cart;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PlaceOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('note', TextareaType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false,
        ));

        $builder->add('omise_token', HiddenType::class, []);

        $builder->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary')
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'allow_extra_fields' => true,
                'data_class' => 'ProjectBundle\Entity\CustomerOrder'
        ));
    }
}
?>
