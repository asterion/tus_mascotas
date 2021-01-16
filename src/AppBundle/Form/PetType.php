<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('chip')
            ->add('type', ChoiceType::class, array(
                'choices'     => \AppBundle\Entity\Pet::choicesType(),
                'placeholder' => 'Select an option',
            ))
            ->add('firstname')
            ->add('lastname')
            ->add('gender', ChoiceType::class, array(
                'choices'     => \AppBundle\Entity\Pet::choicesGender(),
                'placeholder' => 'Select an option',
            ))
            ->add('color')
            ->add('birthdate', DateType::class, array(
                'widget' => 'single_text',
                'html5'  => false,
                'format' => 'dd-mm-yyyy',
                'attr'   => ['class' => 'js-datepicker'],
            ))
            ->add('kind')
            ->add('steril')
            ->add('human', EntityType::class, array(
                'class'        => 'AppBundle:Human',
                'choice_label' => 'rut',
                'placeholder'  => 'Select an option'
            ))
            ->add('observations');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Pet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_pet';
    }


}
