<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Demande1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Question')
            ->add('Reponse')
            ->add('Categorie', ChoiceType::class, [
                'choices' => [
                    'Velo' => 'velo',
                    'CityKER' => 'city_ker',
                    'Vert' => 'vert',
                ],
                'data' => $builder->getData()->getCategorie(),
            ])
            ->add('SousCategorie', ChoiceType::class, [
                'choices' => [
                    'INFORMATIONS GENERALES SUR LE SERVICE ' => 'infos_generales',
                    "GESTION DES RECLAMATIONS ET DEMANDES D'INFORMATIONS" => 'reclamations_informations',
                    'SOUS CATEGORIE TEST' => 'sous_categorie_test',
                ],
                'data' => $builder->getData()->getSousCategorie(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
