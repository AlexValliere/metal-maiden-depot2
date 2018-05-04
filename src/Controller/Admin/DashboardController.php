<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends Controller
{
	/**
	 * @Route("/admin/", name="admin_index")
	 */
	public function index(): Response
	{
		return $this->render('admin/dashboard/index.html.twig');
	}
}
?>