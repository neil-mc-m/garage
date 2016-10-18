<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 05/09/2016
 * Time: 22:17
 */

namespace CMS\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
class CreateNewCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('reg', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 4,
                        'max' => 9
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'e.g. 00x1234'
                )
            ))
            ->add('make', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 3
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'e.g. Mazda'
                )
            ))
            ->add('model', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 2
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'eg.323'
                )
            ))
            ->add('year', IntegerType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Type(array(
                        'type' => 'integer'
                    )),
                    new Assert\Range(array(
                        'min' => 1900,
                        'max' => 3000
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'e.g.2013'
                )
            ))
            ->add('mileage', IntegerType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Type(array(
                        'type' => 'integer'
                    )),
                    new Assert\Range(array(
                        'min' => 1000,
                        'max' => 500000
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'e.g.140000'
                )
            ))
            ->add('fuel', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 5
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'petrol or diesel'
                )
            ))
            ->add('engine', TextType::class, array(

                'constraints' => array(
                    new Assert\NotBlank(),

                ),
                'attr' => array(
                    'placeholder' => '1.6'
                )
            ))
            ->add('color', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 3
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'e.g. red'
                )
            ))
            ->add('body', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 3
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'e.g. estate'
                )
            ))
            ->add('owners', IntegerType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Type(array(
                        'type' => 'integer'
                    )),
                    new Assert\Range(array(
                        'min' => 1,
                        'max' => 50
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'e.g. 1'
                )
            ))
            ->add('price', IntegerType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Type(array(
                        'type' => 'integer'
                    )),
                    new Assert\Range(array(
                        'min' => 1,
                        'max' => 500000
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'eg 10000'
                )
            ))
            ->add('description', TextareaType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 3,
                        'max' => 500
                    ))
                ),
                'attr' => array(
                    'placeholder' => 'enter a short description of the car (max 500 chars)'
                )
            ));
    }
}