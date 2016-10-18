<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 18/10/2016
 * Time: 21:18
 */

namespace CMS\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactType extends  AbstractType
{
    /**
     * Contact form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return FormBuilderInterface
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        return $builder
            ->add('name', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array(
                        'min' => 3
                    ))),
                'attr' => array(
                    'placeholder' => 'Name',
                    'class' => 'uk-width-1-1'
                )))
            ->add('email', EmailType::class, array(
                'constraints' => new Assert\Email(),
                'attr' => array(
                    'placeholder' => 'Yourname@somethingmail.com',
                    'class' => 'uk-width-1-1'
                )))
            ->add('message', TextareaType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(), new Assert\Length(array(
                        'min' => 20
                    ))),
                'attr' => array(
                    'placeholder' => 'Your Message',
                    'class' => 'uk-width-1-1',
                    'rows' => 5,
                    'cols' => 65
                )
            ));
    }
    public function getName()
    {
        return 'contact';
    }
}
