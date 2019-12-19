<?php

namespace App\Controller;

use Exception;
use App\Entity\Langue;
use App\Form\LangueType;
use App\Repository\LangueRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

/**
 * @Route("/langue")
 */
class LangueController extends AbstractController
{
    /**
     * @Route("/", name="langue_index", methods={"GET"})
     */
    public function index(LangueRepository $langueRepository): Response
    {
        return $this->render('langue/index.html.twig', [
            'langues' => $langueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="langue_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $langue = new Langue();
        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * gestion de l'image
             */

            /** @var UploadedFile $flagFile */
            $flagFile = $form['flag']->getData();

            // this condition is needed because the 'flag' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($flagFile) {
                $originalFilename = pathinfo($flagFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $flagFile->guessExtension();

                // Move the file to the directory where flags are stored
                try {
                    $flagFile->move(
                        $this->getParameter('flags_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'flagFilename' property to store the PDF file name
                // instead of its contents
                $langue->setflag($newFilename);
            }

            /**
             * suite
             */
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($langue);
            $entityManager->flush();

            return $this->redirectToRoute('langue_index');
        }

        return $this->render('langue/new.html.twig', [
            'langue' => $langue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="langue_show", methods={"GET"})
     */
    public function show(Langue $langue): Response
    {
        return $this->render('langue/show.html.twig', [
            'langue' => $langue,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="langue_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Langue $langue): Response
    {
        // try {
        //     $langue->setFlag(
        //         new File($this->getParameter('flags_directory') . '/' . $langue->getFlag())
        //     );
        // } catch (FileNotFoundException $e) {
        //     $langue->setFlag(null);
        // } catch (Exception $e) {
        //     $langue->setFlag(null);
        // }

        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * gestion de l'image
             */

            /** @var UploadedFile $flagFile */
            $flagFile = $form['flag']->getData();

            // this condition is needed because the 'flag' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($flagFile) {
                $originalFilename = pathinfo($flagFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $flagFile->guessExtension();

                // Move the file to the directory where flags are stored
                try {
                    $flagFile->move(
                        $this->getParameter('flags_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'flagFilename' property to store the PDF file name
                // instead of its contents
                $langue->setflag($newFilename);
            }

            /**
             * suite
             */
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('langue_index');
        }

        dump($langue);
        return $this->render('langue/edit.html.twig', [
            'langue' => $langue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="langue_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Langue $langue): Response
    {
        if ($this->isCsrfTokenValid('delete' . $langue->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($langue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('langue_index');
    }
}
