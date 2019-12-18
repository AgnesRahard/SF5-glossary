<?php

namespace App\Controller;

use App\Entity\Term;
use App\Form\TermType;
use App\Service\MessageGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TermController extends AbstractController
{
    /**
     * @Route("/term", name="term")
     */
    public function index()
    {

        $repository = $this->getDoctrine()
            ->getRepository(Term::class);

        $terms = $repository->findAll();

        return $this->render('term/index.html.twig', [
            'terms' => $terms,
        ]);
    }

    /**
     * @Route("/term/{id}", name="term_show",
     * requirements={"id"="\d+"}
     * )     * 
     */
    public function show($id)
    {

        $repository = $this->getDoctrine()
            ->getRepository(Term::class);

        $term = $repository->find($id);

        return $this->render('term/show.html.twig', [
            'term' => $term,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="term_delete",
     * requirements={"id"="\d+"}
     * )      
     */
    public function delete(MessageGenerator $messageGenerator, EntityManagerInterface $manager, $id)
    {

        $repository = $this->getDoctrine()
            ->getRepository(Term::class);
        $term = $repository->find($id);

        $manager->remove($term);
        $manager->flush();

        $message = $messageGenerator->getMessage('success');
        $this->addFlash(
            'success',
            $message
        );

        return $this->redirectToRoute('term');
    }

    /**
     * @Route("/add", name="term_add") 
     */
    public function add(MessageGenerator $messageGenerator, Request $request, EntityManagerInterface $manager)
    {
        $term = new Term();

        $formulaireTerm = $this->createForm(TermType::class, $term)
            ->add('save', SubmitType::class);
        $formulaireTerm->handleRequest($request);

        if ($formulaireTerm->isSubmitted() && $formulaireTerm->isValid()) {
            // dump($term);
            // $term->setUpdate();
            $persist = $manager->persist($term);
            $flush = $manager->flush();

            $message = $messageGenerator->getMessage('success');
            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('term');
            // dump($persist);
            // dump($flush);
        }

        return $this->render('term/add.html.twig', [
            'formulaireTerm' => $formulaireTerm->createView(),
        ]);
    }

    /**
     * @Route("/update/{id}", name="term_update") 
     */
    public function update(Request $request, EntityManagerInterface $manager, $id)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Term::class);
        $term = $repository->find($id);

        $formulaireTerm = $this->createForm(TermType::class, $term)
            ->add('save', SubmitType::class);
        $formulaireTerm->handleRequest($request);

        if ($formulaireTerm->isSubmitted() && $formulaireTerm->isValid()) {
            // dump($term);

            $manager->persist($term);
            $manager->flush();
            //$request->getSession()->getFlashBag()->add();
            $this->addFlash(
                'success',
                'Modification enregistrée avec succès'
            );

            return $this->redirectToRoute('term');
        }

        return $this->render('term/add.html.twig', [
            'formulaireTerm' => $formulaireTerm->createView(),
        ]);
    }
}
