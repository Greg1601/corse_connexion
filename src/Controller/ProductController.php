<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/product/{id}/show", name="product_show")
     */
    public function showProductAction($id)
    {
        $product = $this->getDoctrine()->getManager()->getRepository('App:Product')->findOneById($id);

        $data[] = array(
            'productName' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'picture' => $product->getPicture(),
        );

        return $this->json($data);

    }
}
