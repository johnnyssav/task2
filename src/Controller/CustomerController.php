<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\Type\CustomerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractApiController
{
    /**
     * @Route("/customer", name="customer")
     */
    public function indexAction(Request $request): Response
    {
    
        $customers = $this->getDoctrine()->getRepository(Customer::class)->findAll();

        return $this->respond($customers);
    }

    public function createAction(request $request): Response
    {
        $form = $this->buildForm(CustomerType::class);

        $form->handleRequest($request);
        
        if (!$form->isSubmitted() || !$form->isValid()) { 
            //throw exception
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
            
        }

        /**
         * var Customer $customer
         */
        $customer = $form->getData();

        $this->getDoctrine()->getManager()->persist($customer);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond($customer);

    }
}
