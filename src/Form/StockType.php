<?php

namespace App\Form;
use App\Controller\StockController;
use App\Entity\Product;
use App\Entity\Size;
use App\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', NumberType::class, array(
                    'label'=> 'Stock')
                    )
            ->add('size', EntityType::class, [
                  'class' => size::class,
                  'choice_label' => function($size)
                  {
                     return $size->getName();
                  }
            ])
            ->add('product', EntityType::class, [
                  'class' => product::class,
                  'choice_label' => function($product)
                  {
                     return $product->getName();
                  }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
