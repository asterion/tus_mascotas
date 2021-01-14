<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('chip')
            ->add('type', ChoiceType::class, array(
                'choices' => \AppBundle\Entity\Pet::choicesType()
            ))
            ->add('firstname')
            ->add('lastname')
            ->add('gender', ChoiceType::class, array(
                'choices' => \AppBundle\Entity\Pet::choicesGender()
            ))
            ->add('color')
            ->add('birthdate')
            ->add('kind')
            ->add('steril')
            ->add('human')
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
