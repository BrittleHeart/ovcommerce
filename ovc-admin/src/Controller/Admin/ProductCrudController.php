<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Enum\ProductAvailableOnEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(NumericFilter::new('price'))
            ->add(NumericFilter::new('quantity'))
            ->add(BooleanFilter::new('is_on_sale'))
            ->add(NumericFilter::new('points'))
            ->add(ChoiceFilter::new('available_on')
                ->setChoices([
                    'Digital' => ProductAvailableOnEnum::Digital->value,
                    'Shop' => ProductAvailableOnEnum::Shop->value,
                    'Both' => ProductAvailableOnEnum::Both->value,
                ]))
            ->add(EntityFilter::new('category'));
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['name', 'uuid'])
            ->setDefaultSort(['id' => 'ASC'])
            ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('uuid')->onlyOnDetail();
        yield TextField::new('name');
        yield TextEditorField::new('description');
        yield MoneyField::new('price')
            ->setCurrency('PLN');
        yield IntegerField::new('quantity');
        yield ImageField::new('cover_url')
            ->setBasePath('/uploads/products')
            ->setUploadDir('/public/uploads/products')
            ->setUploadedFileNamePattern(function (UploadedFile $file) {
                return $this->setProductFileName($file);
            })
            ->hideOnIndex();
        yield ImageField::new('background_url')
            ->setBasePath('/uploads/products')
            ->setUploadDir('/public/uploads/products')
            ->setUploadedFileNamePattern(function (UploadedFile $file) {
                return $this->setProductFileName($file);
            })
            ->hideOnIndex();
        yield ImageField::new('merged_url')
            ->onlyOnDetail();
        yield BooleanField::new('is_on_sale');
        yield IntegerField::new('points')->hideOnIndex();
        yield ChoiceField::new('available_on')
            ->setChoices(ProductAvailableOnEnum::cases())
            ->hideOnIndex();
        yield DateTimeField::new('created_at')->hideOnForm();
        yield DateTimeField::new('updated_at')->onlyOnDetail();
        yield AssociationField::new('category')->hideOnIndex();
        yield AssociationField::new('orderItems')
            ->onlyOnDetail();
        yield AssociationField::new('userFavorites')
            ->onlyOnDetail();
        yield AssociationField::new('userProductOrderPointHistories')
            ->onlyOnDetail();
        yield AssociationField::new('coupon')
            ->setRequired(false)
            ->hideOnIndex();
        yield AssociationField::new('opinions')
            ->onlyOnDetail();
        yield AssociationField::new('visitedUrls')
            ->onlyOnDetail();
    }

    private function setProductFileName(UploadedFile $file): string
    {
        $checksum = hash_file('sha256', $file->getFilename());

        return "{$checksum}_{$file->getClientOriginalName()}.{$file->getExtension()}";
    }
}
