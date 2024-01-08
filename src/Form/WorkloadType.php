<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Worker;
use App\Entity\Workload;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkloadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hours_planned')
            ->add('week')
            ->add('work_done')
            ->add('worker', EntityType::class, [
                'class' => Worker::class,
'choice_label' => 'id',
            ])
            ->add('project', EntityType::class, [
                'class' => Project::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workload::class,
        ]);
    }
}
