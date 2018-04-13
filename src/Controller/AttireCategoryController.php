<?php

namespace App\Controller;

use App\Entity\AttireCategory;
use App\Form\AttireCategoryType;
use App\Repository\AttireCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attire-category")
 */
class AttireCategoryController extends Controller
{
    /**
     * @Route("/", name="attire_category_index", methods="GET")
     */
    public function index(AttireCategoryRepository $attireCategoryRepository): Response
    {
        return $this->render('attire_category/index.html.twig', ['attire_categories' => $attireCategoryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="attire_category_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $attireCategory = new AttireCategory();
        $form = $this->createForm(AttireCategoryType::class, $attireCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($attireCategory);
            $em->flush();

            return $this->redirectToRoute('attire_category_index');
        }

        return $this->render('attire_category/new.html.twig', [
            'attire_category' => $attireCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attire_category_show", methods="GET")
     */
    public function show(AttireCategory $attireCategory): Response
    {
        return $this->render('attire_category/show.html.twig', ['attire_category' => $attireCategory]);
    }

    /**
     * @Route("/{id}/edit", name="attire_category_edit", methods="GET|POST")
     */
    public function edit(Request $request, AttireCategory $attireCategory): Response
    {
        $form = $this->createForm(AttireCategoryType::class, $attireCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attire_category_edit', ['id' => $attireCategory->getId()]);
        }

        return $this->render('attire_category/edit.html.twig', [
            'attire_category' => $attireCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attire_category_delete", methods="DELETE")
     */
    public function delete(Request $request, AttireCategory $attireCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attireCategory->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($attireCategory);
            $em->flush();
        }

        return $this->redirectToRoute('attire_category_index');
    }
}
