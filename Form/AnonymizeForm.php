<?php

namespace AnonymizeCustomers\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Thelia\Form\BaseForm;

class AnonymizeForm extends BaseForm
{
    public function buildForm()
    {
        $this->formBuilder
            ->add('confirm', CheckboxType::class, [
                'label' => $this->translator->trans('I confirm that I want to anonymize my data', [], 'anonymizecustomers.fo.default'),
                'required' => true,
                'label_attr' => [
                    'for' => 'anonymize_confirm'
                ],
                'attr' => [
                    'id' => 'anonymize_confirm'
                ]
            ]);
    }

    public static function getName()
    {
        return "anonymize_customers";
    }
}
