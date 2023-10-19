<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Categorie;
use App\Entity\User;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;

class QuestionType extends AbstractType
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
            ->add('reponse', CKEditorType::class)
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'label',
                'placeholder' => '== Choisissez une catégorie ==',
                'required' => true,
                'label' => 'Category',
                'query_builder' => function (CategorieRepository $cr) {

                    $user = $this->security->getUser()->getUserIdentifier();
                    // dd($user);

                    return $cr->getCategoriesViaUserDepartement($user);
                    
                },
                'group_by' => function (?Categorie $categorie) {
                    return $categorie ? $categorie->getDepartement()->getLabel() : '';
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
