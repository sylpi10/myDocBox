<?php

namespace App\Form;

use App\Entity\Folder;
use App\Entity\ResearchFolder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class DateFolderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'createdAt',
                DateType::class,
                [
                    "required" => false,
                    'widget' => 'choice',
                    'input'  => 'datetime_immutable',
                    "label" => 'Dossiers créés à partir du',
                    'format' => 'dd, MM, yyy'
                ]
                // )->add(
                //     'updatedAt',
                //     DateType::class,
                //     [
                //         "required" => false,
                //         'widget' => 'choice',
                //         'input'  => 'datetime_immutable',
                //         "label" => 'Dossiers modifiés à partir du',
                //         'format' => 'dd, MM, yyy'
                //     ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResearchFolder::class,
        ]);
    }
}
