<?php

namespace App\Controller\Admin;

use App\Entity\MetalMaiden;
use App\Entity\Nation;
use App\Form\MetalMaidenType;
use App\Repository\MetalMaidenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/metal-maiden")
 */
class MetalMaidenController extends Controller
{
    /**
     * @Route("/", name="admin_metal_maiden_index", methods="GET")
     */
    public function index(MetalMaidenRepository $metalMaidenRepository): Response
    {
        return $this->render('admin/metal_maiden/index.html.twig', ['metal_maidens' => $metalMaidenRepository->findAllWithAttireCategoriesAndNations()]);
    }

    /**
     * @Route("/attire-category/{attireCategoryAbbreviation}", name="admin_metal_maiden_index_by_attire_category", methods="GET")
     */
    public function indexByAttireCategory(MetalMaidenRepository $metalMaidenRepository, $attireCategoryAbbreviation): Response
    {
        return $this->render('admin/metal_maiden/index.html.twig', ['metal_maidens' => $metalMaidenRepository->findByAttireCategoryWithAttireCategoriesAndNations($attireCategoryAbbreviation)]);
    }

    /**
     * @Route("/nation/{nation}", name="admin_metal_maiden_index_by_nation", methods="GET")
     */
    public function indexByNation(MetalMaidenRepository $metalMaidenRepository, $nation): Response
    {
        return $this->render('admin/metal_maiden/index.html.twig', ['metal_maidens' => $metalMaidenRepository->findByNationWithAttireCategoriesAndNations($nation)]);
    }

    /**
     * @Route("/new", name="admin_metal_maiden_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $metalMaiden = new MetalMaiden();
        $form = $this->createForm(MetalMaidenType::class, $metalMaiden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($metalMaiden);
            $em->flush();

            return $this->redirectToRoute('admin_metal_maiden_index');
        }

        return $this->render('admin/metal_maiden/new.html.twig', [
            'metal_maiden' => $metalMaiden,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_metal_maiden_show", methods="GET")
     */
    public function show(MetalMaiden $metalMaiden): Response
    {
        return $this->render('admin/metal_maiden/show.html.twig', ['metal_maiden' => $metalMaiden]);
    }

    /**
     * @Route("/{id}/edit", name="admin_metal_maiden_edit", methods="GET|POST")
     */
    public function edit(Request $request, MetalMaiden $metalMaiden): Response
    {
        $form = $this->createForm(MetalMaidenType::class, $metalMaiden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('metal_maiden_edit', ['id' => $metalMaiden->getId()]);
        }

        return $this->render('admin/metal_maiden/edit.html.twig', [
            'metal_maiden' => $metalMaiden,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_metal_maiden_delete", methods="DELETE")
     */
    public function delete(Request $request, MetalMaiden $metalMaiden): Response
    {
        if ($this->isCsrfTokenValid('delete'.$metalMaiden->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($metalMaiden);
            $em->flush();
        }

        return $this->redirectToRoute('admin_metal_maiden_index');
    }
}
