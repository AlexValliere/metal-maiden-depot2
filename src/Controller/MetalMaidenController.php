<?php

namespace App\Controller;

use App\Entity\AttireCategory;
use App\Entity\MetalMaiden;
use App\Entity\Nation;
use App\Form\MetalMaidenType;
use App\Repository\MetalMaidenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/metal-maiden")
 */
class MetalMaidenController extends Controller
{
    /**
     * @Route("/", name="metal_maiden_index", methods="GET")
     */
    public function index(MetalMaidenRepository $metalMaidenRepository): Response
    {
        $nations = $this->getDoctrine()
            ->getRepository(Nation::class)
            ->findAll();

        $attireCategories = $this->getDoctrine()
            ->getRepository(AttireCategory::class)
            ->findAll();

        return $this->render(
            'metal_maiden/index.html.twig',
            [
                'attire_categories'     => $attireCategories,
                'metal_maidens'         => $metalMaidenRepository->findAllWithJoin(),
                'nations'               => $nations,
            ]
        );
    }

    /**
     * @Route("/attire-category/{attireCategoryAbbreviation}", name="metal_maiden_index_filtered_by_attire_category_abbreviation", methods="GET")
     * @Route("/nation/{nationName}", name="metal_maiden_index_filtered_by_nation_name", methods="GET")
     * @Route("/nation/{nationName}/attire-category/{attireCategoryAbbreviation}", name="metal_maiden_index_filtered_by_attire_category_abbreviation_and_nation_name", methods="GET")
     */
    public function indexFiltered(MetalMaidenRepository $metalMaidenRepository, $nationName = "", $attireCategoryAbbreviation = ""): Response
    {
        $nations = $this->getDoctrine()
            ->getRepository(Nation::class)
            ->findAll();

        $attireCategories = $this->getDoctrine()
            ->getRepository(AttireCategory::class)
            ->findAll();

        return $this->render(
            'metal_maiden/index.html.twig',
            [
                'attire_categories'     => $attireCategories,
                'metal_maidens'         => $metalMaidenRepository->findAllByAttireCategoryAbbreviationOrNationName(
                                            [
                                                'attire_category_abbreviation' => $attireCategoryAbbreviation,
                                                'nation_name' => $nationName,
                                            ]
                                        ),
                'metal_maidens_filter'  =>
                    [
                        'attire_category_abbreviation' => $attireCategoryAbbreviation,
                        'nation_name'                  => $nationName,
                    ],
                'nations' => $nations,
            ]
        );
    }

    /**
     * @Route("/new", name="metal_maiden_new", methods="GET|POST")
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

            return $this->redirectToRoute('metal_maiden_index');
        }

        return $this->render('metal_maiden/new.html.twig', [
            'metal_maiden' => $metalMaiden,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="metal_maiden_show", methods="GET")
     */
    public function show(MetalMaiden $metalMaiden): Response
    {
        return $this->render('metal_maiden/show.html.twig', ['metal_maiden' => $metalMaiden]);
    }

    /**
     * @Route("/{id}/edit", name="metal_maiden_edit", methods="GET|POST")
     */
    public function edit(Request $request, MetalMaiden $metalMaiden): Response
    {
        $form = $this->createForm(MetalMaidenType::class, $metalMaiden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('metal_maiden_edit', ['id' => $metalMaiden->getId()]);
        }

        return $this->render('metal_maiden/edit.html.twig', [
            'metal_maiden' => $metalMaiden,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="metal_maiden_delete", methods="DELETE")
     */
    public function delete(Request $request, MetalMaiden $metalMaiden): Response
    {
        if ($this->isCsrfTokenValid('delete'.$metalMaiden->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($metalMaiden);
            $em->flush();
        }

        return $this->redirectToRoute('metal_maiden_index');
    }
}
