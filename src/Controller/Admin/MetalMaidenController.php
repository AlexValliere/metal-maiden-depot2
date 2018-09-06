<?php

namespace App\Controller\Admin;

use App\Entity\MetalMaiden;
use App\Entity\Nation;
use App\Form\MetalMaidenType;
use App\Repository\MetalMaidenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        return $this->render('admin/metal_maiden/index.html.twig', ['metal_maidens' => $metalMaidenRepository->findAllWithJoin()]);
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
            'admin/metal_maiden/index.html.twig',
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
     * @Route("/{attireSlug}", name="admin_metal_maiden_show", methods="GET")
     */
    public function show(MetalMaiden $metalMaiden): Response
    {
        return $this->render('admin/metal_maiden/show.html.twig', ['metal_maiden' => $metalMaiden]);
    }

    /**
     * @Route("/{attireSlug}/edit", name="admin_metal_maiden_edit", methods="GET|POST")
     */
    public function edit(Request $request, MetalMaiden $metalMaiden): Response
    {
        $form = $this->createForm(MetalMaidenType::class, $metalMaiden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            if ( $metalMaiden->getPortraitImageName() && ($metalMaiden->getPortraitImageName() !== ($metalMaiden->getAttireSlug().".png")) )
            {
                $path = $this->container->getParameter("asset_paths.metal_maiden_portrait");
                $portraitImageName = $metalMaiden->getPortraitImageName();
                $newPortraitImageName = $metalMaiden->getAttireSlug().".png";

                $portraitImagePath = $path . $portraitImageName;
                $newPortraitImagePath = $path . $newPortraitImageName;

                $fileSystem = new Filesystem();
                $fileSystem->rename($portraitImagePath, $newPortraitImagePath);

                $metalMaiden->setPortraitImageName($newPortraitImageName);

                $em = $this->getDoctrine()->getManager();
                $em->persist($metalMaiden);
                $em->flush();
            }

            return $this->redirectToRoute('admin_metal_maiden_edit', ['attireSlug' => $metalMaiden->getAttireSlug()]);
        }

        return $this->render('admin/metal_maiden/edit.html.twig', [
            'metal_maiden' => $metalMaiden,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{attireSlug}", name="admin_metal_maiden_delete", methods="DELETE")
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
