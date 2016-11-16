<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 15/11/2016
 * Time: 23:23
 */

namespace CMS\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
class CreateNewPromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('name', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 4

                    ))
                ),
                'attr' => array(
                    'placeholder' => 'name of promo'
                )
            ))
            ->add('description', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 3
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'short description of the promo'
                )
            ))
            ->add('item1', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 2
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'first listed item'
                )
            ))
            ->add('item2', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 2
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'second listed item'
                )
            )) ->add('item3', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 2
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'third listed item'
                )
            ))
            ->add('item4', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 2
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'fourth listed item'
                )
            ))
            ->add('item5', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 2
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'fifth listed item'
                )
            ));
    }
}
