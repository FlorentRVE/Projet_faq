<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Departement;
use App\Repository\DepartementRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\SecurityBundle\Security;

class CategorieType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'label',
                'required' => true,
                'label' => 'Departement',
                'query_builder' => function (DepartementRepository $dr) {

                    $user = $this->security->getUser()->getUserIdentifier();

                    return $dr->getUserDepartments($user);
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
