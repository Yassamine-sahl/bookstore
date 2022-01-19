<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/auteur")
 */
class AuteurController extends AbstractController
{
    /**
     * @Route("/", name="auteur_index", methods={"GET"})
     */
    public function index(AuteurRepository $auteurRepository): Response
    {
        $auteurs = $auteurRepository->findAll();

        return $this->render('auteur/index.html.twig', [
            'auteurs' => $auteurs,
        ]);
    }

    /**
     * @Route("/new", name="auteur_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($auteur);
            $entityManager->flush();
            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auteur/new.html.twig', [
            'auteur' => $auteur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="auteur_show", methods={"GET"})
     */
    public function show(Auteur $auteur): Response
    {
        // dd($auteur->getLivres());
        return $this->render('auteur/show.html.twig', [
            'auteur' => $auteur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="auteur_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Auteur $auteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auteur/edit.html.twig', [
            'auteur' => $auteur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="auteur_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Auteur $auteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $auteur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($auteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
