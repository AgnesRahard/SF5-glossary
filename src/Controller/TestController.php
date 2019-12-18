<?php

namespace App\Controller;

use App\Entity\Number;
use App\Form\NumberTestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/test/", 
     * name="test_page"
     * )
     */
    public function index(Request $request)
    {

        $number = new Number();

        $formulaireTest = $this->createForm(NumberTestType::class, $number)
                        ->add('save', SubmitType::class);
        $formulaireTest->handleRequest($request);

        if ($formulaireTest->isSubmitted() && $formulaireTest->isValid()) {
            // dump($number);
            return $this->render('test/result.html.twig', [
                'num' => $number->getValue(),
                ]);
        }

        return $this->render('test/index.html.twig', [
            'formulaireTest' => $formulaireTest->createView(),
            ]);
    }
}
