<?php

namespace AnonymizeCustomers\Controller;

use AnonymizeCustomers\Form\AnonymizeForm;
use Propel\Runtime\Propel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\Translation\Translator;
use Thelia\Exception\TheliaProcessException;
use Thelia\Log\Tlog;
use Thelia\Model\AddressQuery;
use Thelia\Model\CustomerQuery;


class AnonymizeController extends BaseFrontController
{
    /**
     * @Route("/delete", name="anonymize_form", methods={"POST"})
     */
    public function anonymizeCustomerAction(Request $request)
    {
        $customer = $this->getSecurityContext()->getCustomerUser();
        if (!$customer) {
            return new RedirectResponse($this->generateUrl("login"));
        }

        $form = $this->createForm(AnonymizeForm::getName());


        try {
            $vform = $this->validateForm($form);
            $confirmValue = $vform->get('confirm')->getData();

            if (!$confirmValue) {
                throw new \InvalidArgumentException("Confirmation is required");
            }

            $con = Propel::getConnection();
            $con->beginTransaction();

            try {
                $customer = CustomerQuery::create()->findPk($customer->getId());
                if (!$customer) {
                    throw new TheliaProcessException("Customer not found.");
                }

                $customer->setFirstname('Anonymized');
                $customer->setLastname('Customer');
                //setEmail necessite $force a true
                $customer->setEmail('anonymized_' . $customer->getId() . '@rgpd.com', true);
                $customer->save($con);

                $addresses = AddressQuery::create()->findByCustomerId($customer->getId());
                foreach ($addresses as $address) {
                    $address->setFirstname('Anonymized');
                    $address->setLastname('Customer');
                    $address->setAddress1('Anonymized Address');
                    $address->setAddress2('');
                    $address->setAddress3('');
                    $address->setZipcode('00000');
                    $address->setCity('Anonymized City');
                    $address->setPhone('0000000000');
                    $address->setCellphone('0000000000');
                    $address->setCompany('');
                    $address->save($con);
                }

                $con->commit();

                $this->getSession()->getFlashBag()->add(
                    'success',
                    Translator::getInstance()->trans('Your account has been successfully anonymized.', [], 'anonymizecustomers.fo.default')
                );

                if ($form->hasSuccessUrl()) {
                    return $this->generateRedirect($this->retrieveSuccessUrl($form));
                }

                return $this->generateRedirect(
                    $this->getRouteFromRouter(
                        'router.front',
                        'customer.home'
                    )
                );
            } catch (PropelException $e) {
                $con->rollBack();
                throw new TheliaProcessException("Database error during anonymization", $e);
            }
        } catch (FormValidationException $e) {
            $error_message = $e->getMessage();
            Tlog::getInstance()->error("Form validation error: " . $error_message);
        } catch (TheliaProcessException $e) {
            $error_message = $e->getMessage();
            Tlog::getInstance()->error("Anonymization process error: " . $error_message);
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            Tlog::getInstance()->error("Unexpected error during anonymization: " . $error_message);
        }

        $this->getSession()->getFlashBag()->add(
            'error',
            Translator::getInstance()->trans('An error occurred during the anonymization process. Please try again later.', [], 'anonymizecustomers.fo.default')
        );

        $form->setErrorMessage($error_message);
        $this->getParserContext()
            ->addForm($form)
            ->setGeneralError($error_message);

        if ($form->hasErrorUrl()) {
            return $this->generateErrorRedirect($form);
        }

        return $this->generateErrorRedirect($form);
    }
}
