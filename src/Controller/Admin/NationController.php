<?php

namespace App\Controller\Admin;

use App\Entity\Nation;
use App\Form\NationType;
use App\Repository\NationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/nation")
 */
class NationController extends Controller
{
    /**
     * @Route("/", name="admin_nation_index", methods="GET")
     */
    public function index(NationRepository $nationRepository): Response
    {
        return $this->render('admin/nation/index.html.twig', ['nations' => $nationRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_nation_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $nation = new Nation();
        $form = $this->createForm(NationType::class, $nation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($nation);
            $em->flush();

            return $this->redirectToRoute('admin_nation_index');
        }

        return $this->render('admin/nation/new.html.twig', [
            'nation' => $nation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{nameSlug}", name="admin_nation_show", methods="GET")
     */
    public function show(Nation $nation): Response
    {
        return $this->render('admin/nation/show.html.twig', ['nation' => $nation]);
    }

    /**
     * @Route("/{nameSlug}/edit", name="admin_nation_edit", methods="GET|POST")
     */
    public function edit(Request $request, Nation $nation): Response
    {
        $form = $this->createForm(NationType::class, $nation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            if ( $nation->getImageName() && ($nation->getImageName() !== ($nation->getNameSlug().".png")) )
            {
                $path = $this->container->getParameter("asset_paths.nation_dir");
                $imageName = $nation->getImageName();
                $newImageName = $nation->getNameSlug().".png";

                $imagePath = $path . $imageName;
                $newImagePath = $path . $newImageName;

                $fileSystem = new Filesystem();
                $fileSystem->rename($imagePath, $newImagePath);

                $nation->setImageName($newImageName);

                $em = $this->getDoctrine()->getManager();
                $em->persist($nation);
                $em->flush();
            }

            return $this->redirectToRoute('admin_nation_edit', ['id' => $nation->getId()]);
        }

        return $this->render('admin/nation/edit.html.twig', [
            'nation' => $nation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{nameSlug}", name="admin_nation_delete", methods="DELETE")
     */
    public function delete(Request $request, Nation $nation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nation->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($nation);
            $em->flush();
        }

        return $this->redirectToRoute('admin_nation_index');
    }
}
