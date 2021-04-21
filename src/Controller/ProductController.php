<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Product;
use App\Form\Type\CustomerType;
use App\Form\Type\ProductType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractApiController
{
    /**
     * @Route("/customer", name="customer")
     */
    public function indexAction(Request $request): Response
    {

        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->respond($products);
    }

    public function createAction(request $request): Response
    {
        $form = $this->buildForm(ProductType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            //throw exception
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /**
         * var Product $product
         */
        $product = $form->getData();

        $this->getDoctrine()->getManager()->persist($product);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond($product);
    }
}
