<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/genre")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("/", name="genre_index", methods={"GET"})
     */
    public function index(GenreRepository $genreRepository): Response
    {

        $genres =  $genreRepository->findAll();

        return $this->render('genre/index.html.twig', [
            'genres' => $genres,
        ]);
    }

    /**
     * @Route("/new", name="genre_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($genre);
            $entityManager->flush();
            return $this->redirectToRoute('genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genre/new.html.twig', [
            'genre' => $genre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="genre_show", methods={"GET"})
     */
    public function show(Genre $genre): Response
    {
        return $this->render('genre/show.html.twig', [
            'genre' => $genre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="genre_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Genre $genre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genre/edit.html.twig', [
            'genre' => $genre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="genre_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Genre $genre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $genre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($genre);
            $entityManager->flush();
        }
        return $this->redirectToRoute('genre_index', [], Response::HTTP_SEE_OTHER);
    }
}
