<?php

namespace App\Controller\Admin;

use App\Entity\Report;
use App\Enum\ReportDataTypeEnum;
use App\Enum\ReportTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;

class ReportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Report::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Report')
            ->setEntityLabelInPlural('Reports');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('report_type', 'Type')
                ->setChoices([
                    'Product Selling' => ReportTypeEnum::ProductSelling->value,
                    'New Users' => ReportTypeEnum::NewUsers->value,
                    'Savings' => ReportTypeEnum::Savings->value,
                    'New Loyal Users' => ReportTypeEnum::NewLoyalUsers->value,
                    'Refunds' => ReportTypeEnum::Refunds->value,
                ]))
            ->add(ChoiceFilter::new('report_data_type', 'Data Type')
                ->setChoices([
                    'Json' => ReportDataTypeEnum::Json->value,
                    'CSV' => ReportDataTypeEnum::Csv->value,
                    'PDF' => ReportDataTypeEnum::Pdf->value,
                ]))
            ->add(DateTimeFilter::new('report_date'))
            ->add(DateTimeFilter::new('start_date', 'From date'))
            ->add(DateTimeFilter::new('end_date', 'To Date'))
            ->add(DateTimeFilter::new('created_at'))
            ->add(DateTimeFilter::new('updated_at'));
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnDetail();
        yield TextField::new('report_name','Name');
        yield ChoiceField::new('report_type', 'Type')
            ->setChoices(ReportTypeEnum::cases());
        yield ChoiceField::new('report_data_type', 'Data Type')
            ->setChoices(ReportDataTypeEnum::cases());
        yield DateTimeField::new('start_date', 'From date');
        yield DateTimeField::new('end_date', 'To date');
        yield DateTimeField::new('report_date');

        if (Crud::PAGE_DETAIL === $pageName) {
            yield DateTimeField::new('created_at');
            yield DateTimeField::new('updated_at');
        }
    }
}
